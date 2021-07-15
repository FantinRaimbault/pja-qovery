<?php


namespace App\Core\Database;


use App\Core\Logger;

abstract class Entity
{

    protected array $nullables = [];

    protected string $table;
    protected int|null $id;
    protected string $created_at;
    protected string $updated_at;

    public function __construct(array $data = [])
    {
        extract($data);
        $this->id = $id ?? null;
        $getCalledClassExploded = explode("\\", get_called_class());
        $this->table = strtolower(end($getCalledClassExploded)) . 's';
    }

    public function setId(int $id): void
    {
        $this->id = intval($id, 10);
    }

    public function save()
    {
        $q = new Query();
        $properties = $this->getProperties();
        if ($this->id) {
            unset($properties['id']);
            return $q->table($this->table)
                ->where('id', '=', $this->id)
                ->insertValues($properties)
                ->update();
        } else {
            return $q->table($this->table)
                ->insertValues($properties)
                ->insert();
        }
    }

    public function getById()
    {
        $q = new Query();
        return $q->table($this->table)
            ->where('id', '=', $this->id)
            ->get()[0] ?? [];
    }

    public function deleteById(): string
    {
        $q = new Query();
        return $q->table($this->table)
            ->where('id', '=', $this->id)
            ->delete();
    }

    public function find(array $filters = null): array
    {
        $q = new Query();
        $q = $q->table($this->table);
        if (isset($filters)) {
          foreach ($filters as $key => $filter) {
            $q = $q->where($filter[0], $filter[1], $filter[2]);
          }
        }
        return $q->get();
    }

    public function findOne(array $filters): array|bool
    {
        $q = new Query();
        $q = $q->table($this->table);
        foreach ($filters as $key => $filter) {
            $q = $q->where($filter[0], $filter[1], $filter[2]);
        }
        return $q->get()[0] ?? false;
    }

    public function update(array $filters)
    {
        $q = new Query();
        $properties = $this->getProperties();
        $q = $q->table($this->table);
        foreach ($filters as $key => $filter) {
            $q = $q->where($filter[0], $filter[1], $filter[2]);
        }
        $q = $q->insertValues($properties);
        return $q->update();
    }

    public function delete(array $filters)
    {
        $q = new Query();
        $q = $q->table($this->table);
        foreach ($filters as $key => $filter) {
            $q = $q->where($filter[0], $filter[1], $filter[2]);
        }
        return $q->delete();
    }

    private function getProperties(): array
    {
        $vars = get_object_vars($this);
        $nullables = $vars['nullables'];
        unset($vars['created_at']);
        unset($vars['updated_at']);
        unset($vars['table']);
        unset($vars['nullables']);
        Logger::log($nullables);
        return array_filter($vars, function ($var, $key) use ($nullables) {
            return !is_null($var) || in_array($key, $nullables);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
