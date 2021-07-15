<?php


namespace App\Modules\Controllers\Auth\Models;


class Verification extends \App\Core\Database\Entity
{
  protected string | null $verificationToken;
  protected int | null $userId;

  public function __construct(array $data = [])
  {
    parent::__construct($data);
    extract($data);
    $this->verificationToken = $verificationToken ?? null;
    $this->userId = $userId ?? null;
  }
}