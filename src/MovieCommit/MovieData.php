<?php namespace MovieCommit;

class MovieData
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

}