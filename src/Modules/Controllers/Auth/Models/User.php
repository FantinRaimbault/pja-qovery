<?php

namespace App\Modules\Controllers\Auth\Models;

use \App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;

class User extends Entity
{
    protected string | null $firstname;
    protected string | null $lastname;
    protected string | null $email;
    protected string | null $password;
    protected string | null $picture;
    protected string | null $role;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->firstname = ucfirst(BinksBeatHelper::cleanData($firstname ??= null));
        $this->lastname = ucfirst(BinksBeatHelper::cleanData($lastname ??= null));
        $this->email = BinksBeatHelper::cleanData($email ??= null);
        $tempPassword = htmlspecialchars($password ??= "", ENT_QUOTES);
        $this->password = $tempPassword ? password_hash($tempPassword, PASSWORD_DEFAULT) : null;
        $this->role = BinksBeatHelper::cleanData($role ??= null);
        $this->picture = BinksBeatHelper::cleanData($picture ??= null);
    }

    public static function createRegisterForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_register",
                "class" => ["form_builder"],
                "submit" => [
                    "value" => "S'inscrire",
                    "class" => ["submit", "bb-bg-blue", "full-width"]
                ]
            ],
            "inputs" => [
                "firstname" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Votre prénom",
                        "minLength" => 2,
                        "maxLength" => 55,
                        "id" => "firstname",
                        "class" => ["form_input"],
                        "placeholder" => "Exemple: Fantin",
                        "error" => "Votre prénom doit faire entre 2 et 55 caractères",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 2,
                        maxLength: 55,
                        regex: "/^[a-z ,.'-]+$/i"
                    )
                ],
                "lastname" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Votre nom",
                        "minLength" => 2,
                        "maxLength" => 255,
                        "id" => "lastname",
                        "class" => ["form_input"],
                        "placeholder" => "Exemple: Raimbault",
                        "error" => "Votre nom doit faire entre 2 et 255 caractères",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 2,
                        maxLength: 55,
                        regex: "/^[a-z ,.'-]+$/i"
                    )
                ],
                "email" => [
                    "props" => [
                        "type" => "email",
                        "label" => "Votre email",
                        "minLength" => 8,
                        "maxLength" => 320,
                        "id" => "email",
                        "class" => ["form_input"],
                        "placeholder" => "Exemple: nom@gmail.com",
                        "error" => "Votre email doit faire entre 8 et 320 caractères",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 8,
                        maxLength: 320,
                        email: true
                    )
                ],
                "password" => [
                    "props" => [
                        "type" => "password",
                        "label" => "Votre mot de passe",
                        "minLength" => 8,
                        "id" => "password",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Votre mot de passe doit faire au minimum 8 caractères",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 8,
                    )
                ],
                "passwordConfirm" => [
                    "props" => [
                        "type" => "password",
                        "label" => "Confirmation",
                        "confirm" => "password",
                        "id" => "passwordConfirm",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Votre mot de mot de passe de confirmation ne correspond pas",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        equalTo: 'password'
                    )
                ],
            ]
        ]);
    }

    public static function createLoginForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_login",
                "class" => ["form_builder"],
                "submit" => [
                    "value" => "Se connecter",
                    "class" => ["submit", "bb-bg-blue", "full-width"]
                ]
            ],
            "inputs" => [
                "email" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Votre email",
                        "id" => "email",
                        "class" => ["form_input my-1"],
                        "placeholder" => "Exemple: fantin@binksbeat.io",
                        "error" => "Mot de passe ou identifiants incorrects",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 8,
                        maxLength: 320
                    )
                ],
                "password" => [
                    "props" => [
                        "type" => "password",
                        "label" => "Votre mot de passe",
                        "id" => "password",
                        "class" => ["form_input my-1"],
                        "placeholder" => "",
                        "error" => "Mot de passe ou identifiants incorrects",
                        "required" => true
                    ],
                    "validator" => new FormValidator()
                ],
            ]
        ]);
    }

    public static function editInfoForm(array $data = []): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_register",
                "class" => [""],
                "submit" => [
                    "value" => "Mettre à jour",
                    "class" => ["submit", "bb-bg-blue", "full-width"]
                ]
            ],
            "inputs" => [
                "firstname" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Votre prénom",
                        "minLength" => 2,
                        "maxLength" => 55,
                        "id" => "firstname",
                        "class" => ["form_input"],
                        "value" => $data['firstname'] ?? "",
                        "placeholder" => "Exemple: Fantin",
                        "error" => "Votre prénom doit faire entre 2 et 55 caractères et contenir uniquement des lettres",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 2,
                        maxLength: 55,
                        regex: "/^[a-z ,.'-]+$/i"
                    )
                ],
                "lastname" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Votre nom",
                        "minLength" => 2,
                        "maxLength" => 255,
                        "id" => "lastname",
                        "value" => $data['lastname'] ?? "",
                        "class" => ["form_input"],
                        "placeholder" => "Exemple: Raimbault",
                        "error" => "Votre nom doit faire entre 2 et 55 caractères et contenir uniquement des lettres",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 2,
                        maxLength: 55,
                        regex: "/^[a-z ,.'-]+$/i"
                    )
                ],
            ]
        ]);
    }
}
