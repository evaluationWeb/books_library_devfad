<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Utils\Tools;
use Mithridatem\Validation\Validator;
use Mithridatem\Validation\ValidationError;

class CategoryService
{
    private CategoryRepository $categoryRepository;
    private Validator $validator;

    //injection de dépendance
    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->validator = new Validator();
    }

    /**
     * Méthode qui retourne la liste de toutes les categories
     * @return array<Category> $categories Tableau objet Category
     */
    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * Méthode qui gére la logique d'ajout de categorie
     * @return string $message 
     */
    public function insertCategory(): string|array
    {
        $errors = [];

        //test si le champ est vide
        if (empty($_POST["category_name"]) || $_POST["category_name"] == 'null') {
            $errors["msg"] = "Veuillez remplir le nom de categorie";
        }
        
        //test si on n'à pas d' erreurs
        if (empty($errors)) {

            //Nettoyage des données
            Tools::sanitizeArray($_POST);

            //Récupération de la catégorie
            $category = $this->categoryRepository->findByName($_POST["category_name"]);

            //test si la catégorie existe déja
            if ($category && $category != null) {
                $errors["msg"]= "La categorie : " . $_POST["category_name"] .  " existe déja";
            }
        }
        
        if (empty($errors)) {
            //Hydratation en Objet Category
            $newCategory = Category::hydrate($_POST);

            //Récupérer les erreurs de validations
            $errors_validation =  $this->validator->validate($newCategory);
            //Test si il y à des erreurs de validation
            if (!empty($errors_validation)) {
                //ajouter au tableau
                $errors["validation"] = $errors_validation;   
            } else {
                $this->categoryRepository->create($newCategory);
                $errors["success"] = "La catégorie : " . $_POST["category_name"] . " a été ajouté avec succés";
            }
        }
    
        return $errors;
    }
}
