<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\Tools;
use Mithridatem\Validation\Validator;

class UserService
{
    //Attributs
    private UserRepository $userRepository;
    private Validator $validator;

    public function __construct()
    {
        //Injection des dépendances
        $this->userRepository = new UserRepository();
        $this->validator = new Validator();
    }

    /**
     * Méthode qui gére la logique métier d'enregistrement d'un nouveau compte en BDD
     * @return array $errors Tableau d'erreur/validation/success
     */
    public function insertUser(): array
    {
        $errors = [];

        //1 Nettoyer les données
        Tools::sanitizeArray($_POST);

        //2 Hydrater un objet User
        $user = User::hydrate($_POST);

        //3 Récupération des erreurs de validation 
        $errors_validation = $this->validator->validate($user);

        //4 Tests des erreurs de validation
        if (!empty($errors_validation)) {
            $errors["validation"] = $errors_validation;
            return $errors;
        }

        //5 Tests si les 2 mot de sont différents
        if ($_POST["password"] != $_POST["confirm-password"]) {
            $errors["error"] = "Les mots de passe ne sont pas identiques";
            return $errors;
        }

        //6 Récupérer le compte par son email
        $userFindByEmail = $this->userRepository->findByEmail($user->getEmail());

        //7 Tester si le compte existe
        if ($userFindByEmail) {
            $errors["error"] = "Le compte existe déja";
            return $errors;
        }

        //8 Hasher le mot de passe
        $hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        //9 Setter le mot de passe hashé
        $user->setPassword($hash);

        //10 Ajouter en BDD le compte
        $this->userRepository->create($user);

        //11 Message de succés d'enregistrement
        $errors["success"] = "Le compte " . $user->getEmail() . " a été ajouté en BDD";
        
        return $errors;
    }

    public function connectUser(): string
    {
        //Test si les champs sont remplis
        if (empty($_POST["email"]) || empty($_POST["password"])) {
            return "Veuillez remplir tous les champs";
        }

        //Nettoyage des entrées utilisateurs
        Tools::sanitizeArray($_POST);
        //Test si le mail est valide
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            return "Le format de l’email est invalide.";
        }

        //Récupération du compte
        $user = $this->userRepository->findByEmail($_POST["email"]);

        //Test si le compte existe
        if (!$user) {
            return "Les informations de connexion ne sont pas valides";
        }

        //Test si le mot de passe est valide
        if (!password_verify($_POST["password"], $user->getPassword())) {
            return "Les informations de connexion ne sont pas valides";
        }

        //Renouvellement de l'id de session
        session_regenerate_id(true);

        //Création de la super globale de session
        $_SESSION["user"] = [
            "id"=> $user->getId(),
            "firstname"=> $user->getFirstname(),
            "lastname"=> $user->getLastname(),
            "email"=> $user->getEmail(),
            "grant"=> $user->getGrant() ?? ""
        ];

        return "Connexion réussie";
    }
}
