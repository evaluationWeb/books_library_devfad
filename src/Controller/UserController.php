<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Service\UserService;

class UserController extends AbstractController
{
    //Attribut
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function register(): mixed
    {
        //Tester si le formulaire est soumis
        if (isset($_POST["submit"])) {
            $data["msg"] = $this->userService->insertUser();
        }
        //Retourne la vue 
        return $this->render('register', 'Inscription', $data ?? []);
    }

    public function login():mixed 
    {
        //Test si le formulaire est soumis
        if (isset($_POST["submit"])) {
            //Traitement de la connexion
            $data["msg"] = $this->userService->connectUser();
        }
        //Retourne la vue
        return $this->render('login', 'Connexion', $data ?? []);
    }
}
