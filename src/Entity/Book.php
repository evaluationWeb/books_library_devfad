<?php

namespace App\Entity;
use App\Entity\Category;

class Book
{
    //Attributs
    private ?int $id;
    private ?string $title;
    private ?string $content;
    private ?\DateTimeImmutable $publishAt;
    private ?string $author;
    private ?string $cover;
    private ?\DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt;
    private array $categories;

    //Constructeur
    public function __construct(
        ?string $title,
        ?string $content,
        ?\DateTimeImmutable $publishAt,
        ?string $author
    )
    {
        $this->title = $title;
        $this->content = $content;
        $this->publishAt = $publishAt;
        $this->author = $author;
        $this->createdAt = new \DateTimeImmutable();
        $this->categories = [];
    }

    //Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getPublishAt(): ?\DateTimeImmutable
    {
        return $this->publishAt;
    }

    public function setPublishAt(?\DateTimeImmutable $publishAt): void
    {
        $this->publishAt = $publishAt;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): void
    {
        $this->cover = $cover;
    }
    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
    }

    public function removeCategory(Category $category): void
    {
        unset($this->categories[array_search($category, $this->categories)]);
        sort($this->categories);
    }

    /**
     * Méthode pour transformer un tableau associatif en objet Book
     * @param array $book tableau associatif en provenance de la BDD (fetch_assoc) ou super globale POST
     * @return Book $newBook objet Book 
     */
    public static function hydrate(array $book): Book
    {
        //Création d'un objet Book (avec les valeurs par défaut du constructeur)
        $newBook = new Book(
            $book["title"]?? null,
            $book["content"]?? null,
            new \DateTimeImmutable($book["publish_at"]) ?? null,
            $book["author"]?? null
        );

        //Set des autres attributs
        $newBook->setId($book["id_book"] ?? null);
        $newBook->setCover($book["cover"] ?? null);
        $newBook->setCreatedAt(new \DateTimeImmutable($book["created_at"]) ?? null);
        $newBook->setUpdatedAt(new \DateTimeImmutable($book["updated_at"]) ?? null);

        //Assignation des categories
        foreach ($book["categories"] as $category) {
            //Création de la catégorie
            $newCategory = new Category($category["category_name"] ?? null);
            //Set de l'id
            $newCategory->setId($category["id_category"]?? null);
            //Ajout à la collection de catégories
            $newBook->addCategory($newCategory);
        }

        //Retour de l'objet Book
        return $newBook;
    }
}
