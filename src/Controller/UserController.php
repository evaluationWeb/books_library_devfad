<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Service\UserService;
use Mithridatem\Validation\ValidationError;

class UserController extends AbstractController
{
    //Attribut
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Méthode pour s'enregistrer sur la plateforme (créer un compte)
     * @return mixed $this->render template_register.php
     */
    public function register(): mixed
    {
        //Tester si le formulaire est soumis
        if (isset($_POST["submit"])) {
            //Traitement de l'inscription
            $data = $this->userService->insertUser();
        }

        //Retourne la vue 
        return $this->render('register', 'Inscription', $data ?? []);
    }

    /**
     * Méthode pour se connecter sur la plateforme (se connecter)
     * @return mixed $this->render template_login.php
     */
    public function login():mixed 
    {
        //Test si le formulaire est soumis
        if (isset($_POST["submit"])) {
            //Traitement de la connexion
            $data = $this->userService->connectUser();
        }
        //Retourne la vue
        return $this->render('login', 'Connexion', $data ?? []);
    }

    /**
     * Méthode pour se déconnecter de la plateforme (se déconnecter)
     * @return void
     */
    public function logout(): void 
    {
        //Appel de la méthode disconnectUser
        $this->userService->disconnectUser();
    }
}
