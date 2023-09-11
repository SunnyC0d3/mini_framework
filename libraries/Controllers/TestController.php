<?php

namespace Demo\Controllers;

class TestController 
{
    public function index()
    {
        echo "
            <form action='/' method='POST' >
                <input type='hidden' name='_method' value='DELETE' >
                <input type='submit' value='DELETE' />
            </form>
        ";
    }

    public function delete()
    {
        echo 'delete';
    }
}