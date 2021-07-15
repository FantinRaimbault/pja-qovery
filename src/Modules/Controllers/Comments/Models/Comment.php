<?php

namespace App\Modules\Controllers\Comments\Models;

use App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;

class Comment extends Entity
{
    protected int|null $userId;
    protected int|null $projectId;
    protected string|null $content;
    protected int|null $disabled;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->userId = BinksBeatHelper::cleanData($userId ??= null);
        $this->projectId = BinksBeatHelper::cleanData($projectId ??= null);
        $this->content = BinksBeatHelper::cleanData($content ??= null);
        $this->disabled = BinksBeatHelper::cleanData($disabled ??= null);
    }

    public static function createForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "",
                "class" => [""],
                "submit" => [
                    "value" => "",
                    "class" => [""]
                ]
            ],
            "inputs" => [
                "content" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Nom de votre page",
                        "id" => "name",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Soyez constructif ! Le commentaire doit contenir entre 20 et 500 charatères.",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 20,
                        maxLength: 500,
                    )
                ],
            ]
        ]);
    }

    public static function disabledCommentForm(): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "",
                "class" => [""],
                "submit" => [
                    "value" => "",
                    "class" => [""]
                ]
            ],
            "inputs" => [
                "disabled" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Nom de votre page",
                        "id" => "name",
                        "class" => ["form_input"],
                        "placeholder" => "",
                        "error" => "Valeur invalide pour la désactivation du commentaire",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        contains: ["0", "1"]
                    )
                ],
            ]
        ]);
    }
}
