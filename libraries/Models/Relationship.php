<?php

namespace Demo\Models;

use Demo\Database;
use Exception;

class Relationship
{
    private Database $db;

    protected $belongsTo = [];
    protected $hasOne = [];
    protected $hasMany = [];

    public function __construct(Database $database)
    {
        $this->db = new $database;
    }

    public function belongsTo($table)
    {
        $this->belongsTo[] = $table;
    }

    public function hasOne($table)
    {
        $this->hasOne[] = $table;
    }

    public function hasMany($table)
    {
        $this->hasMany[] = $table;
    }

    public function eagerLoad($table1, $table2): array
    {
        $this->tableException($table1);
        $this->tableException($table2);
        $this->hasRelationship($table1, $table2);

        $results = [];

        switch ($table2) {
            case in_array($table2, $this->belongsTo):
                $results = $this->belongsToRelationship($table1, $table2);
                break;
            case in_array($table2, $this->hasOne):
                $results = $this->hasOneRelationship($table1, $table2);
                break;
            case in_array($table2, $this->hasMany):
                $results = $this->hasManyRelationship($table1, $table2);
                break;
            default:
                break;
        }

        return $results;
    }

    private function belongsToRelationship($table1, $table2)
    {
        return $this->db->query("SELECT * FROM $table1 INNER JOIN $table2 ON  $table1.id = $table2." . removePlurals($table1) . "_id")->get();
    }

    private function hasOneRelationship($table1, $table2)
    {
        //dd("SELECT * FROM $table1 INNER JOIN $table2 ON  $table1.".removePlurals( $table2 )."_id = $table2.id");
        return $this->db->query("SELECT * FROM $table1 INNER JOIN $table2 ON  $table1.id = $table2.id")->get();
    }

    private function hasManyRelationship($table1, $table2)
    {
        $manyToManyTable = removePlurals($table1) . '_' . removePlurals($table2);

        return $this->db->query(
            'SELECT * FROM :table1 INNER JOIN :combinedTable ON :table1ID = :combinedTableID1 INNER JOIN :table2 ON :table2ID = combinedTableID2',
            [
                ':combinedTable' => $manyToManyTable,
                ':table1' => $table1,
                ':table2' => $table2,
                ':combinedTableID1' => $manyToManyTable . '.' . removePlurals($table1) . '_id',
                ':combinedTableID2' => $manyToManyTable . '.' . removePlurals($table2) . '_id',
                ':table1ID' => $table1 . '.id',
                ':table2ID' => $table2 . '.id',
            ]
        )->get();
    }

    private function hasRelationship($table1, $table2): void
    {
        $this->tableException($table1);
        $this->tableException($table2);

        $result = $this->db->query(
            'SELECT COUNT(*) as count FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = :dbname AND REFERENCED_TABLE_NAME = :table1 AND TABLE_NAME = :table2',
            [
                ':dbname' => $_ENV['DB_DATABASE'],
                ':table1' => $table1,
                ':table2' => $table2
            ]
        )->find() > 0;

        if (empty($result)) {
            throw new Exception('Relationship do not exist between ' . $table1 . ' and ' . $table2);
        }
    }

    private function tableException($table)
    {
        if (!is_string($table)) {
            throw new Exception('Table provided is not of type string.');
        }

        if (empty($table)) {
            throw new Exception('Table provided is empty.');
        }
    }
}
