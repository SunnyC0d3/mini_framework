<?php

namespace Demo\Models;

use Demo\Database;
use Exception;
use PDO;

class Model
{
    protected string $table;
    protected array $fillable = [];

    protected Database $db;
    protected array $statement = [
        'where' => []
    ];

    public function __construct()
    {
        $this->db = new Database();
    }

    protected function where( string $column, string $operator, string $value ) : self
    {
        $this->validateWhereParameters( $column, $operator, $value );

        $this->statement[ 'where' ][] = compact( 'column', 'operator', 'value' );

        return $this;
    }

    protected function execute() : string
    {
        return $this->buildWhereStatement();
    }

    // protected function execute() : array
    // {
    //     $query = $this->buildQuery();
    //     return $this->db->query( $query )->get();
    // }

    private function buildQuery() : string
    {
        $whereStatement = $this->buildWhereStatement();

        return 'SELECT * FROM ' . $this->table . $whereStatement;
    }

    private function buildWhereStatement() : string
    {
        if ( empty( $this->statement['where'] ) ) {
            return '';
        }

        $whereConditions = [];
        foreach ( $this->statement[ 'where' ] as $query ) {
            $whereConditions[] = "{$query[ 'column' ]} {$query[ 'operator' ]} '{$query[ 'value' ]}'";
        }

        return ' WHERE ' . implode(' AND ', $whereConditions);
    }

    private function validateWhereParameters(string $column, string $operator, string $value) : void
    {
        if ( empty( $column ) || empty($operator) || empty($value) ) 
        {
            throw new Exception( 'Conditions do not meet the function parameters.' );
        }

        if ( !in_array( $column, $this->fillable ) ) 
        {
            throw new Exception( "The column '$column' is not part of the fillable." );
        }
    }
}