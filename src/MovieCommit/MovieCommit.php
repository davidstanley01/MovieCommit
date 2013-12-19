<?php namespace MovieCommit;

class MovieCommit
{
    /**
     * Holds our line
     * @var string
     */
    public $line;

    /**
     * Holds the path to our file
     * @var string
     */
    public $path;

    /**
     * Array containing our movies
     * @var array
     */
    protected $movies;

    /**
     * Number of movies to select from
     * @var int
     */
    protected $movieCount;

    /**
     * Class Constructor
     * @param array $movies The array of movies we have from which to choose
     */
    public function __construct(array $movies)
    {
        $this->movies = $movies;
        $this->path = __DIR__ .'/data/';    // set the file path - feels durty
        $this->line = $this->getLine();     // make the line available
    }

    /**
     * Get the line
     * @return string The movie line
     */
    protected function getLine()
    {
        // Get the movie we want. Subtract 1 to account for zero index
        $movie = (count($this->movies) == 1) ? 0 : rand(1, count($this->movies)) - 1;

        // What is our movie?
        $movieName = $this->movies[$movie];

        // Get the file and read it into an array
        $filename = $this->path . "$movieName.txt";

        // supressing the errors is stupid, but I'm tired
        $lines = @file($filename, FILE_IGNORE_NEW_LINES);

        if ($lines) {
            // get the line we want. Subtract 1 to account for zero index
            $line = (count($lines) == 1) ? 0 : rand(1, count($lines)) - 1;

            // return the obvious
            return array(
                "line"  => $lines[$line],
                "title" => $movieName
            );

        } else {

            // something.  anything
            return array(
                "line"  => "Dave's not here, man.",
                "title" => "The Big Lebowski"
            );
        }
    }
}