<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\Tools;
use Mithridatem\Validation\Validator;
use App\Entity\DTO\LoginDTO;

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
        
        //12 Retour du tableau error/validation/success
        return $errors;
    }

    /**
     * Méthode qui gére la logique métier de connexion à la plateforme
     * @return array $errors Tableau d'erreur/validation/success
     */
    public function connectUser(): array
    {
        $errors = [];

        //1 Nettoyer les données
        Tools::sanitizeArray($_POST);

        //2 Créer un objet LoginDTO (représente un objet de Connexion)
        $loginDTO = new LoginDTO($_POST["email"], $_POST["password"]);

        //3 Récupération des erreurs de validation 
        $errors_validation = $this->validator->validate($loginDTO);

        //4 Tests des erreurs de validation
        if (!empty($errors_validation)) {
            $errors["validation"] = $errors_validation;
            return $errors;
        }

        //5 Récupération du compte
        $user = $this->userRepository->findByEmail($_POST["email"]);

        //6 Test si le compte existe
        if (!$user) {
            $errors["error"] = "Les informations de connexion ne sont pas valides";
            return $errors;
        }

        //7 Test si le mot de passe est valide
        if (!password_verify($_POST["password"], $user->getPassword())) {
            $errors["error"] = "Les informations de connexion ne sont pas valides";
            return $errors;
        }

        //8 Renouvellement de l'id de session
        session_regenerate_id(true);

        //9 Création de la super globale de session
        $_SESSION["user"] = [
            "id"=> $user->getId(),
            "firstname"=> $user->getFirstname(),
            "lastname"=> $user->getLastname(),
            "email"=> $user->getEmail(),
            "grant"=> $user->getGrant() ?? ""
        ];

        //10 Message de succés de connexion
        $errors["success"] = "Connexion réussie";
        
        //11 Retour du tableau error/validation/success
        return $errors;
    }

    /**
     * Méthode qui gére la logique métier de la déconnexion à la plateforme
     * @return void
     */
    public function disconnectUser(): void
    {
        //1 Suppression de la session
        session_destroy();
        //2 Suppression du cookie de session
        unset($_COOKIE["PHPSESSID"]);
        //3 Redirection vers la page d'accueil
        header('Location:/');
    }
}
