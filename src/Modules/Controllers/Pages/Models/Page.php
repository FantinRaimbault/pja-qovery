<?php

namespace App\Modules\Controllers\Pages\Models;

use App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;

class Page extends Entity
{
    protected string|null $name;
    protected int|null $isMain;
    protected int|null $isPublished;
    protected int|null $projectId;
    protected string|null $content;
    protected string|null $slug;
    protected string|null $backgroundColor;
    protected string|null $seoTitle;
    protected string|null $seoDescription;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->name = BinksBeatHelper::cleanData($name ??= null);
        $this->slug = BinksBeatHelper::cleanData($slug ??= null ? preg_replace('/\s+/', '', $slug) : null);
        $this->isMain = BinksBeatHelper::cleanData($isMain ??= null);
        $this->isPublished = BinksBeatHelper::cleanData($isPublished ??= null);
        $this->projectId = BinksBeatHelper::cleanData($projectId ??= null);
        $this->content = ($content ??= null);
        $this->backgroundColor = BinksBeatHelper::cleanData($backgroundColor ??= null);
        $this->seoTitle = BinksBeatHelper::cleanData($seoTitle ??= null);
        $this->seoDescription = BinksBeatHelper::cleanData($seoDescription ??= null);
    }

    public static function createForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_project",
                "class" => ["form_builder"],
                "submit" => [
                    "value" => "Créer ma page",
                    "class" => ["submit"]
                ]
            ],
            "inputs" => [
                "name" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Nom de votre page",
                        "id" => "name",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Nom de la page invalide (entre 1 et 255 charactères)",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 1,
                        maxLength: 255,
                    )
                ],
                "slug" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Chemin de votre Page (URL)",
                        "id" => "slug",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Chemin de la page invalide (entre 1 et 255 charactères, doit contenir des lettres et/ou des tirets)",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 1,
                        maxLength: 255,
                        regex: '/^[A-Z-]+$/i'
                    )
                ],
                "isMain" => [
                    "props" => [
                        "type" => "checkbox",
                        "label" => "Nom de votre page",
                        "id" => "name",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Page principale non assignable",
                        "required" => true
                    ],
                    "validator" => new FormValidator(contains: ["0", "1"])
                ],
                "isPublished" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Chemin de votre Page (URL)",
                        "id" => "slug",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Status de la page non assignable",
                        "required" => true
                    ],
                    "validator" => new FormValidator(contains: ["0", "1"])
                ],
            ]
        ]);
    }

    public static function updateForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_project",
                "class" => ["form_builder"],
                "submit" => [
                    "value" => "Enregistrer",
                    "class" => ["submit"]
                ]
            ],
            "inputs" => [
                "name" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Nom de votre page",
                        "id" => "name",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Nom de la page invalide",
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        minLength: 1,
                        maxLength: 255,
                    )
                ],
                "slug" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Chemin de votre Page (URL)",
                        "id" => "slug",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Chemin de la page invalide",
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        minLength: 1,
                        maxLength: 255,
                        regex: '/^[A-Z-]+$/i'
                    )
                ],
                "isMain" => [
                    "props" => [
                        "type" => "checkbox",
                        "label" => "Nom de votre page",
                        "id" => "name",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Page principale non assignable",
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        contains: ["0", "1"]
                    )
                ],
                "isPublished" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Chemin de votre Page (URL)",
                        "id" => "slug",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Status de la page non assignable",
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        contains: ["0", "1"]
                    )
                ],
                "backgroundColor" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Background color",
                        "id" => "backgroundColor",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "BackgroundColor invalide",
                    ],
                    "validator" => new FormValidator(
                        required: false,
                    )
                ],
                "seoTitle" => [
                    "props" => [
                        "type" => "text",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "Balise Title erreur",
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        maxLength: 255,
                    )
                ],
                "seoDescription" => [
                    "props" => [
                        "type" => "text",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "Balise Description erreur",
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        maxLength: 255,
                    )
                ],
            ]
        ]);
    }

    public function checkContent()
    {
        if (preg_match('/<script>|<\/script>/', $this->content)) {
            throw new \Exception('content page not valid');
        }
    }
}
