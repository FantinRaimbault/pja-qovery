<?php

namespace App\Modules\Controllers\Projects\Models;

use App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;

class Project extends Entity
{
    protected array $nullables = [
        'templateApplied'
    ];

    protected string|null $name;
    protected int|null $owner;
    protected string|null $description;
    protected int|null $allowCommunity;
    protected string|null $slug;
    protected string|null $picture;
    protected int|null $templateApplied;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->name = BinksBeatHelper::cleanData($name ??= null);
        $this->owner = BinksBeatHelper::cleanData($owner ??= null);
        $this->description = BinksBeatHelper::cleanData($description ??= null);
        $this->allowCommunity = BinksBeatHelper::cleanData($allowCommunity ??= null);
        $this->slug = BinksBeatHelper::cleanData($slug ??= null);
        $this->picture = BinksBeatHelper::cleanData($picture ??= null);
        $this->templateApplied = BinksBeatHelper::cleanData($templateApplied ??= null);
    }

    public function setName(string $name): void
    {
        $this->name = BinksBeatHelper::cleanData($name);
    }

    public function setDescription(string $description): void
    {
        $this->description = BinksBeatHelper::cleanData($description);
    }

    public static function createForm(array $data = []): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_project",
                "class" => ["bb-form"],
                "submit" => [
                    "value" => "Enregistrer",
                    "class" => ["submit"]
                ]
            ],
            "inputs" => [
                "name" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Nom de votre projet",
                        "id" => "name",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "value" => $data['name'] ?? "",
                        "error" => "Le nom de votre projet doit faire entre 1 et 255 caractères",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 1,
                        maxLength: 255
                    )
                ],
            ]
        ]);
    }

    public static function generalForm(array $data = [], string $action = ""): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => $action,
                "id" => "general_form",
                "class" => ["bb-form"],
                "submit" => [
                    "value" => "Enregistrer",
                    "class" => ["submit"]
                ]
            ],
            "inputs" => [
                "name" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Nom du projet",
                        "id" => "name",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "value" => $data['name'] ?? "",
                        "error" => "Le nom de votre projet doit faire entre 1 et 255 caractères",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 1,
                        maxLength: 255
                    )
                ],
                "description" => [
                    "props" => [
                        "type" => "textarea",
                        "label" => "Description du projet",
                        "id" => "description",
                        "class" => ["height-100"],
                        "placeholder" => "Décrivez votre projet ...",
                        "value" => $data['description'] ?? "",
                        "error" => "Votre description ne doit pas dépasser 500 charactères",
                        "required" => false
                    ],
                    "validator" => new FormValidator(
                        minLength: 0,
                        maxLength: 500
                    )
                ],
            ]
        ]);
    }

    public static function communityForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "description_form",
                "class" => ["row", "bb-form"],
                "submit" => [
                    "value" => "Enregistrer",
                    "class" => ["flex-1", "submit-desc"]
                ]
            ],
            "inputs" => [
                "allowCommunity" => [
                    "props" => [
                        "type" => "checkbox",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "value" => "",
                        "error" => "Votre description ne doit pas dépasser 500 charactères",
                        "required" => false
                    ],
                    "validator" => new FormValidator(
                        contains: [0, 1]
                    )
                ],
            ]
        ]);
    }
}
