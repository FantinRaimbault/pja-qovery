<?php

namespace App\Modules\Controllers\Auth\Models;

use App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;

class Contributor extends Entity
{

    const ROLES = ['admin' => 'admin', 'editor' => 'editor', 'producer' => 'producer'];

    protected int | null $userId;
    protected int | null $projectId;
    protected string | null $role;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->userId = BinksBeatHelper::cleanData($userId ??= null);
        $this->projectId = BinksBeatHelper::cleanData($projectId ??= null);
        $this->role = BinksBeatHelper::cleanData($role ??= null);
    }

    public function displayRole(): string
    {
        switch ($this->role) {
            case 'admin':
                return 'Administrateur';
            case 'editor':
                return 'Editeur de page';
            case 'producer':
                return 'Producteur de Musique';
            default:
                return '?';
        }
    }

    public function isOwnerOfProject(int $projectId): bool
    {
        return $this->userId === $projectId;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLES['admin'];
    }

    public function canAccessPages()
    {
        return $this->role === self::ROLES['admin'] || $this->role === self::ROLES['editor'];
    }

    public function canAccessMusiques()
    {
        return $this->role === self::ROLES['admin'] || $this->role === self::ROLES['producer'];
    }

    public function canAccessTemplates()
    {
        return $this->role === self::ROLES['admin'] || $this->role === self::ROLES['editor'];
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public static function updateRole()
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
}
