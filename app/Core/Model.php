<?php

namespace App\Core;

abstract class Model
{
    protected string $table = '';

    protected ?\mysqli $db;

    public function __construct()
    {
        $this->db = DB::getConnection();
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create(array $data): ?int
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        $types = '';
        $values = [];
        foreach ($data as $value) {
            $values[] = $value;

            if (is_int($value)) {
                $types .= 'i'; // integer
            } elseif (is_float($value)) {
                $types .= 'd'; // double (float)
            } elseif (is_string($value)) {
                $types .= 's'; // string
            } else {
                $types .= 'b'; // blob or unknown (handled as binary)
            }
        }

        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return null;
    }

    public function deleteById(int $id): ?bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return true;
        }
        return null;
    }

    public function update(int $id, array $data): ?bool
    {
        $setClause = implode(", ", array_map(fn($column) => "$column = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE {$this->table} SET $setClause WHERE id = ?");
        $types = '';
        $values = [];
        foreach ($data as $value) {
            $values[] = $value;

            if (is_int($value)) {
                $types .= 'i'; // integer
            } elseif (is_float($value)) {
                $types .= 'd'; // double (float)
            } elseif (is_string($value)) {
                $types .= 's'; // string
            } else {
                $types .= 'b'; // blob or unknown (handled as binary)
            }
        }
        $types .= 'i';
        $values[] = $id;

        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            return true;
        }
        return null;
    }
}