<?php

namespace App\Modules\Controllers\Reports\Models;

use App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;

class Report extends Entity
{

    const METRICS = ['insult' => 'insult', 'violence' => 'violence', 'bullying' => 'bullying'];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->userId = BinksBeatHelper::cleanData($userId ??= null);
        $this->commentId = BinksBeatHelper::cleanData($commentId ??= null);
        $this->metric = BinksBeatHelper::cleanData($metric ??= null);
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
                "metric" => [
                    "props" => [
                        "type" => "",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "Valeur de signalement invalide, veuillez réessayer",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        contains: Report::METRICS
                    )
                ],
            ]
        ]);
    }

}
