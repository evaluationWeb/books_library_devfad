<?php

namespace App\Entity\DTO;

use Mithridatem\Validation\Attributes\Email;
use Mithridatem\Validation\Attributes\NotBlank;
use Mithridatem\Validation\Attributes\Length;

//Représentation Objet de Connexion (login)
final readonly class LoginDTO
{
    public function __construct(
        #[NotBlank]
        #[Email]
        public ?string $email,
        #[NotBlank]
        #[Length(min: 8, max: 50)]
        public ?string $password
    ) {}
}
