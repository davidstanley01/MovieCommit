<?php namespace MovieCommit;

use MovieCommit\MovieDataInterface;

class MovieData implements MovieDataInterface
{
    public function __construct(array $connection)
    {
        $host = $connection['host'];
        $dbname = $connection['dbname'];
        $username = $connection['username'];
        $password = $connection['password'];
        $dsn = "mysql:host=$host;dbname=$dbname";

        // parent::__construct($dsn, $username, $password, array());
    }

    public function getAllMovies()
    {
        return true;
    }

    public function getMovie()
    {
        return true;
    }

    public function getLine()
    {

    }

    public function getLineById($id)
    {

    }

}