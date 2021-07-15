<?php

namespace App\Core\Database;

use App\Core\Logger;
use App\Modules\BinksBeatHelper;

class Query
{
    private \PDO $conn;

    private string $table;

    private array $select = [];

    private array $join = [];

    private array $insertValues = [];

    // on separe car plusieurs conditions peuvent s'appliquer au meme param
    private array $whereParams = [];

    private string $groupBy;
    private string $limit;
    private string $orderBy;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function getUpdateString(): string
    {
        $queryString[] = 'UPDATE';
        if (isset($this->table)) {
            $queryString[] = $this->table;
        }
        $queryString[] = 'SET';
        $columns = [];
        if (empty($this->insertValues)) {
            throw new \Exception('missing values to insert/update');
        }
        foreach ($this->insertValues as $key => $value) {
            $columns[] = $key . ' = :' . $key;
        }
        $queryString[] = join(', ', $columns);
        $this->writeWhere($queryString);
        return join(' ', $queryString);
    }

    public function getDeleteString(): string
    {
        $queryString[] = 'DELETE';
        $this->writeTable($queryString);
        $this->writeWhere($queryString);
        return join(' ', $queryString);
    }

    public function getInsertString(): string
    {
        $queryString[] = 'INSERT INTO';
        if (isset($this->table)) {
            $queryString[] = $this->table;
            $queryString[] = '(';
        }
        $columns = [];
        if (empty($this->insertValues)) {
            throw new \Exception('missing values to insert/update');
        }
        foreach ($this->insertValues as $key => $value) {
            $columns[] = $key;
        }
        $queryString[] = join(', ', $columns);
        $queryString[] = ') VALUES (';
        $columns = [];
        foreach ($this->insertValues as $key => $value) {
            $columns[] = ':' . $key;
        }
        $queryString[] = join(', ', $columns);
        $queryString[] = ')';
        return $queryString = join(' ', $queryString);
    }

    public function get(): array|string
    {
        $statement = $this->conn->prepare($this->getSelectString());
        foreach ($this->whereParams as $key => $value) {
            $statement->bindParam(':' . $key, $this->whereParams[$key]);
        }
        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function join(string $leftColumn, string $rightColumn): Query
    {
        if (empty($this->where)) {
            $this->where[] = "$leftColumn = $rightColumn";
        } else {
            $this->where[] = 'AND';
            $this->where[] = "$leftColumn = $rightColumn";
        }
        return $this;
    }

    public function delete(): bool
    {
        $statement = $this->conn->prepare($this->getDeleteString());
        foreach ($this->whereParams as $key => $value) {
            $statement->bindParam(':' . $key, $this->whereParams[$key]);
        }
        try {
            $statement->execute();
        } catch (\PDOException $e) {
            BinksBeatHelper::getPDOException($e);
        }
        return true;
    }

    public function insertValues(array $values): Query
    {
        $this->insertValues = $values;
        return $this;
    }

    public function update(): int
    {
        $statement = $this->conn->prepare($this->getUpdateString());
        foreach ($this->insertValues as $key => $value) {
            $statement->bindParam(':' . $key, $this->insertValues[$key]);
        }
        foreach ($this->whereParams as $key => $value) {
            $statement->bindParam(':' . $key, $this->whereParams[$key]);
        }

        try {
            $statement->execute();
        } catch (\PDOException $e) {
            BinksBeatHelper::getPDOException($e);
        }
        return true;
    }

    public function insert(): int
    {
        $statement = $this->conn->prepare($this->getInsertString());

        foreach ($this->insertValues as $key => $value) {
            $statement->bindParam(':' . $key, $this->insertValues[$key]);
        }
        try {
            $statement->execute();
        } catch (\PDOException $e) {
            BinksBeatHelper::getPDOException($e);
        }
        $lastId = $this->conn->lastInsertId();
        return intval($lastId);
    }

    public function select(array $columns): Query
    {
        $this->select = $columns;
        return $this;
    }

    public function table(string $table): Query
    {
        $this->table = $table;
        return $this;
    }

    public function where(string $left, string $comparator, $right): Query
    {
        if (empty($this->where)) {
            $this->where[] = $left . ' ' . $comparator . ' :' . count($this->whereParams);
            $this->whereParams[] = $right;
        } else {
            $this->where[] = 'AND';
            $this->where[] = $left . ' ' . $comparator . ' :' . count($this->whereParams);
            $this->whereParams[] = $right;
        }
        return $this;
    }

    public function orWhere(string $left, string $comparator, $right): Query
    {
        if (empty($this->where)) {
            $this->where[] = $left . ' ' . $comparator . ' :' . count($this->whereParams);
            $this->whereParams[] = $right;
        } else {
            $this->where[] = 'OR';
            $this->where[] = $left . ' ' . $comparator . ' :' . count($this->whereParams);
            $this->whereParams[] = $right;
        }
        return $this;
    }

    public function groupBy(string $column): Query
    {
        $this->groupBy = $column;
        return $this;
    }

    public function limit(int $limit): Query
    {
        $this->limit = $limit;
        return $this;
    }

    public function orderBy(string $orderBy): Query
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function getSelectString(): string
    {
        $queryString[] = 'SELECT';
        $this->writeSelect($queryString);
        $this->writeTable($queryString);
        $this->writeWhere($queryString);
        $this->writeGroupBy($queryString);
        $this->writeOrderBy($queryString);
        $this->writeLimit($queryString);
        return join(' ', $queryString);
    }

    private function writeSelect(array &$queryString): void
    {
        if (isset($this->select) && !empty($this->select)) {
            $queryString[] = join(', ', $this->select);
        } else {
            $queryString[] = '*';
        }
    }

    private function writeWhere(array &$queryString): void
    {
        if (isset($this->where)) {
            $queryString[] = 'WHERE';
            $queryString[] = join(' ', $this->where);
        }
    }

    private function writeTable(array &$queryString): void
    {
        if (isset($this->table)) {
            $queryString[] = 'FROM';
            $queryString[] = $this->table;
        } else {
            throw new \Exception('missing table');
        }
    }

    private function writeGroupBy(array &$queryString): void
    {
        if (isset($this->groupBy)) {
            $queryString[] = 'GROUP BY';
            $queryString[] = $this->groupBy;
        }
    }

    private function writeLimit(array &$queryString): void
    {
        if (isset($this->limit)) {
            $queryString[] = 'LIMIT';
            $queryString[] = $this->limit;
        }
    }

    private function writeOrderBy(array &$queryString): void
    {
        if (isset($this->orderBy)) {
            $queryString[] = 'ORDER BY';
            $queryString[] = $this->orderBy;
        }
    }
}
