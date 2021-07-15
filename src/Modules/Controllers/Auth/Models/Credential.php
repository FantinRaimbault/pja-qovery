<?php

namespace App\Modules\Controllers\Auth\Models;

use \App\Core\Database\Entity;
use App\Modules\BinksBeatHelper;

class Credential extends Entity
{

    protected string | null $token;
    protected int | null $userId;
    protected int | null $verified;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->token = BinksBeatHelper::cleanData($token ??= null);
        $this->userId = BinksBeatHelper::cleanData($userId ??= null);
        $this->verified = $verified ?? null;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}
