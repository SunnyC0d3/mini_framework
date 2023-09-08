<?php

namespace Demo\Models;

use Demo\Database;
use Exception;

class Model
{
    private $table;
    protected $fillable = [];

    private $db;

    private $statement = [
        'where' => []
    ];

    public function __construct()
    {
        $this->db = new Database();
    }

    protected function getTable() 
    {
        return $this->table;
    }
    protected function setTable( $table ) 
    {
        $this->table = $table;
    }

    protected function where( $column, $operator, $value )
    {
        if( empty( $column ) || empty( $operator ) || empty( $value ) )
        {
            throw new Exception( 'Conditions do not meet the function parameters.' );
        }

        if( ! in_array( $column, $this->fillable ) )
        {
            throw new Exception( 'The following column ' . $column .  ' is not part of the fillable.' );
        }

        $this->statement[ 'where' ] = [ 'column' => $column,  'operator' => $operator,  'value' => $value ];

        return $this;
    }

    protected function find()
    {
        return $this->buildWhereStatement();
        //$this->db->query( 'SELECT *' )
    }

    private function buildWhereStatement()
    {
        $whereStatement = '';
        $addAnd = false;

        if( count( $this->statement[ 'where' ] ) > 0 )
        {
            $whereStatement = ' WHERE ';

            foreach( $this->statement[ 'where' ] as $query )
            {
                if ( $addAnd ) 
                {
                    $whereStatement .= ' AND ';
                }

                $whereStatement .= $query[ 'column' ] . $query[ 'operator' ] . $query[ 'value' ];

                $addAnd = true;
            }

            return $whereStatement;
        }

        return $whereStatement;
    }
}

/**
 * A Model should be able to connect to the correct table
 * 
 * A Model should be able to perform CRUD related operations related to its own Model
 * 
 * A Model should be able to validate rules before uploading or making interactions between database
 * 
 * Has the ability to select which columns are editable and remain hidden or untouched
 * 
 * User extends Model
 *  - Gets everything to do with Model and can get its own properties and methods
 */