<?php

namespace App\Modules\Controllers\Projects\Models;

use App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;
use App\Modules\Controllers\Auth\Models\Contributor;

class Invitation extends Entity
{
    protected string|null $email;
    protected int|null $projectId;
    protected string|null $role;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->email = BinksBeatHelper::cleanData($email ??= null);
        $this->projectId = BinksBeatHelper::cleanData($projectId ??= null);
        $this->role = BinksBeatHelper::cleanData($role ??= null);
    }

    public static function createForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_invitation",
                "class" => ["bb-form"],
                "submit" => [
                    "value" => "Ajouter",
                    "class" => ["submit"]
                ]
            ],
            "inputs" => [
                "email" => [
                    "props" => [
                        "type" => "email",
                        "label" => "Votre email",
                        "minLength" => 8,
                        "maxLength" => 320,
                        "id" => "email",
                        "class" => ["form_input"],
                        "placeholder" => "Exemple: nom@gmail.com",
                        "error" => "L'adresse email ne correspond pas",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 8,
                        maxLength: 320,
                        email: true
                    )
                    ],
                "role" => [
                    "props" => [
                        "type" => "",
                        "label" => "",
                        "minLength" => 1,
                        "maxLength" => 60,
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "Role invalide",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        contains: Contributor::ROLES
                    )
                ]
            ]
        ]);
    }

    public static function sendReponseForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_invitation",
                "class" => ["bb-form"],
                "submit" => [
                    "value" => "Ajouter",
                    "class" => ["submit"]
                ]
            ],
            "inputs" => [
                "response" => [
                    "props" => [
                        "type" => "",
                        "label" => "",
                        "minLength" => "",
                        "maxLength" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => ""
                    ],
                    "validator" => new FormValidator(
                        contains: [true, false]
                    )
                ]
            ]
        ]);
    }
}
