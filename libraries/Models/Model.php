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

    public function __construct( Database $database )
    {
        $this->db = new $database;
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
        return $this->db->query( $this->buildSelectQuery() )->get();
    }

    public function update( $data ) : void
    {
        $this->validateUpdateParameters( $data );

        $this->db->query( $this->buildUpdateQuery( $data ) );
    }

    public function delete() : void
    {
        $this->db->query( $this->buildDeleteQuery() );
    }

    public function insert( $data ) : void
    {
        $this->validateInsertParameters( $data );

        $this->db->query( $this->buildInsertQuery( $data ) );
    }

    private function buildInsertQuery( $data ) : string
    {
        $update = 'INSERT INTO ' . $this->table;

        $columns = ' ( ' . implode( ', ', array_keys( $data )  ) . ' ) ';
        $values = ' VALUES ( ' . implode( ', ', $this->addQuotesToManyValues( array_values( $data ) ) ) . ' ) ';

        return $update . $columns . $values;
    }

    private function buildDeleteQuery() : string
    {
        $delete = 'DELETE FROM ' . $this->table;

        $delete .= !empty( $this->joinWhereStatements() ) ? ' WHERE ' . $this->joinWhereStatements() : '';

        return $delete;
    }

    private function buildUpdateQuery( $data ) : string
    {
        $update = 'UPDATE ' . $this->table;

        $update .= ' SET ' . implode( ' AND ', $this->joinAssociativeArrayDataWithEqual( $data ) );

        $update .= !empty( $this->joinWhereStatements() ) ? ' WHERE ' . $this->joinWhereStatements() : '';

        return $update;
    }

    private function buildSelectQuery() : string
    {
        $select = 'SELECT * FROM ' . $this->table;

        $select .= !empty( $this->joinWhereStatements() ) ? ' WHERE ' . $this->joinWhereStatements() : '';

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

    private function validateUpdateParameters( $updateFields ) : void
    {
        if( empty( $updateFields ) )
        {
            throw new Exception( 'The parameter passed to update is empty.' );
        }

        if ( ! is_array( $updateFields ) ) 
        {
            throw new Exception( 'Make sure the parameter being passed to update is of type array, with key value pairs.' );
        }

        if( array_keys( $updateFields ) === range( 0, count( $updateFields ) - 1 ) )
        {
            throw new Exception( 'The array parameter passed is not of type associative array.' );
        }

        foreach( $updateFields as $field => $value )
        {
            $this->validateFillable( $field );
        }
    }

    private function validateInsertParameters( $insertFields ) : void
    {
        if( empty( $insertFields ) )
        {
            throw new Exception( 'The parameter passed to insert is empty.' );
        }

        if ( ! is_array( $insertFields ) ) 
        {
            throw new Exception( 'Make sure the parameter being passed to insert is of type array, with key value pairs.' );
        }

        if( array_keys( $insertFields ) === range( 0, count( $insertFields ) - 1 ) )
        {
            throw new Exception( 'The array parameter passed is not of type associative array.' );
        }

        foreach( $insertFields as $field => $value )
        {
            $this->validateFillable( $field );
        }
    }

    private function joinAssociativeArrayDataWithEqual( $data ) : array
    {
        $result = [];

        foreach ( $data as $key => $value ) {

            $result[] = "{$key} = '{$value}'";
        }

        return $result;
    }

    private function joinWhereStatements() : string
    {
        $statements = [
            'where' => [
                $this->buildWhereStatement(),
                $this->buildorWhereStatement()
            ]
        ];

        $whereStatement = implode( ' OR ', array_filter( $statements[ 'where' ] ) );

        return $whereStatement;
    }

    private function addQuotesToManyValues( $data ) : array
    {
        $arr = [];

        foreach( $data as $value )
        {
            $value = '\'' . $value . '\'';
            $arr[] = $value;
        }

        return $arr;
    }
}