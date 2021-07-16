<?php

namespace App\Modules\Middlewares;

use App\Core\Router\Middleware;

class IsEntityFound extends Middleware
{
    public function __construct(array $entities)
    {
        $this->entities = $entities;
    }

    public function handle($params)
    {
        foreach ($this->entities as $entityName => $entityIdFormat) {
            $id = $params[$entityIdFormat];
            $entityName = $entityName;
            $classe = "\App\Modules\Controllers\\$entityName" . "s\Models\\$entityName";
            $entity = (new $classe(['id' => $id]))->getById();
            if(empty($entity)) {
                throw new \Exception("Entity $entityName Not found", 404);
            }
        }
    }
}
