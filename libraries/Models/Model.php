<?php

namespace Demo\Models;

use Demo\Database;
use Exception;

class Model
{
    protected string $table;
    protected array $fillable = [];

    protected Database $db;
    protected array $statement = [
        'where' => [],
        'orWhere' => []
    ];

    public function __construct()
    {
        $this->db = new Database();
    }

    public function find( $id ) : array
    {
        if ( empty( $id ) ) 
        {
            throw new Exception( 'ID value is null.' );
        }

        return $this->where( 'id', '=', $id )->get();
    }

    public function where( string $column, string $operator, string $value ) : self
    {
        $this->validateFillable( $column );
        $this->validateWhereParameters( $column, $operator, $value );

        $this->statement[ 'where' ][] = compact( 'column', 'operator', 'value' );

        return $this;
    }

    public function orWhere( string $column, string $operator, string $value ) : self
    {
        $this->validateFillable( $column );
        $this->validateorWhereParameters( $column, $operator, $value );

        $this->statement[ 'orWhere' ][] = compact( 'column', 'operator', 'value' );

        return $this;
    }

    public function get() : array
    {
        return $this->db->query( $this->buildQuery() )->get();
    }

    private function buildQuery() : string
    {
        $select = 'SELECT * FROM ' . $this->table;

        $statements = [
            'where' => [
                $this->buildWhereStatement(),
                $this->buildorWhereStatement()
            ]
        ];

        $whereStatement = implode( ' OR ', array_filter( $statements[ 'where' ] ) );

        $select .= !empty( $whereStatement ) ? ' WHERE ' . $whereStatement : '';

        return $select;
    }

    private function buildWhereStatement() : string
    {
        if ( empty( $this->statement[ 'where' ] ) ) {
            return '';
        }

        $whereConditions = [];
        foreach ( $this->statement[ 'where' ] as $query ) {
            $whereConditions[] = "{$query[ 'column' ]} {$query[ 'operator' ]} '{$query[ 'value' ]}'";
        }

        return implode( ' AND ', $whereConditions );
    }

    private function buildorWhereStatement() : string
    {
        if ( empty( $this->statement[ 'orWhere' ] ) ) {
            return '';
        }

        $whereConditions = [];
        foreach ( $this->statement[ 'orWhere' ] as $query ) {
            $whereConditions[] = "{$query[ 'column' ]} {$query[ 'operator' ]} '{$query[ 'value' ]}'";
        }

        return implode( ' OR ', $whereConditions );
    }

    private function validateFillable( $column )
    {
        if ( !in_array( $column, $this->fillable ) ) 
        {
            throw new Exception( "The column '$column' is not part of the fillable." );
        }
    }

    private function validateWhereParameters( string $column, string $operator, string $value ) : void
    {
        if ( empty( $column ) || empty($operator) || empty($value) ) 
        {
            throw new Exception( 'Conditions do not meet the function parameters.' );
        }
    }

    private function validateorWhereParameters( string $column, string $operator, string $value ) : void
    {
        $this->validateWhereParameters( $column, $operator, $value );
    }
}