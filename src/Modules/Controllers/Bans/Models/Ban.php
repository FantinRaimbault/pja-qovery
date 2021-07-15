<?php

namespace App\Modules\Controllers\Bans\Models;

use App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;

class Ban extends Entity
{


    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->userId = BinksBeatHelper::cleanData($userId ??= null);
        $this->reason = BinksBeatHelper::cleanData($reason ??= null);
        $this->until = BinksBeatHelper::cleanData($until ??= null);
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
                "reason" => [
                    "props" => [
                        "type" => "",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "Le motif doit faire entre 1 et 255 charactères",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        minLength: 1,
                        maxLength: 255
                    )
                ],
                "until" => [
                    "props" => [
                        "type" => "",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "Date de bannissement invalide",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        regex: '/\d{4}-\d{2}-\d{2}/',
                        min: (new \DateTime())->format('Y-m-d')
                    )
                ],
            ]
        ]);
    }
}
