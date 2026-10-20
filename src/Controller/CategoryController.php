<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Service\CategoryService;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * Méthode pour ajouter une catégorie
     * @return mixed $this->render template_add_category.php
     */
    public function addCategory(): mixed
    {
        //Test si le formulaire est soumis
        if ($this->isFormSubmitted($_POST)) {
            //Traitement ajout de la categorie
            $data = $this->categoryService->insertCategory();
        }
        //Retourner le template + $data["msg"]
        return $this->render('add_category', 'Ajouter une catégorie', $data ?? []);
    }

    /**
     * Méthode pour afficher la liste des catégories
     * @return mixed $this->render template_show_all_categories.php
     */
    public function showAllCategorie(): mixed
    {
        //Récupération de la liste des categories
        $categories = $this->categoryService->getAllCategories();

        //Retourner le template + $data (liste des catégories)
        return $this->render('show_all_categories', 'Liste des catégories', $categories);
    }
}
