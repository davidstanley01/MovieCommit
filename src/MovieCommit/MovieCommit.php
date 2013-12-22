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
     * Our default response if something went wrong
     *
     * @var array
     */
    protected $default = [
        "line"  => "Dave's not here, man.",
        "title" => "The Big Lebowski",
        "permalink" => null
    ];

    /**
     * Class Constructor
     * @param array $movies The array of movies we have from which to choose
     */
    public function __construct(array $movies)
    {
        $this->movies = $movies;
        $this->path = __DIR__ .'/data/';    // set the file path - feels durty
        $this->line = $this->getQuote();     // make the line available
    }

    /**
     * Get a Movie Quote
     *
     * @param  string $id The id of the quote to retrieve
     * @return string     The movie line
     */
    public function getQuote($id = null)
    {
        // with no id, do the random thing...
        $movie = $this->getMovie();
        return $this->getLine($movie);
    }

    /**
     * Get Quote by ID
     *
     * @param  string $id the encoded json array
     * @return array      The quote we are looking for
     */
    public function getQuoteById($id)
    {
        // decode the id
        $movie = json_decode(base64_decode($id), true);

        if ($movie) {

            list($movieName, $line) = $movie;
            return $this->getLineByNumber($movieName, $line);

        } else {
            return $this->default;
        }
    }

    /**
     * Get a Movie from the list
     *
     * @return string Path to a movie file
     */
    protected function getMovie()
    {
        // Get the movie we want. Subtract 1 to account for zero index
        $movie = (count($this->movies) == 1) ? 0 : rand(1, count($this->movies)) - 1;

        // What is our movie?
        return $this->movies[$movie];
    }

    /**
     * Get a line from a specific movie
     *
     * @param  string $movie The movie we are looking for
     * @return array         An associative array with out datas
     */
    protected function getLine($movieName)
    {
        // get the array of lines
        $lines = $this->loadData($movieName);

        // If we have lines...
        if ($lines) {
            $lineNumber = (count($lines) == 1) ? 0 : rand(1, count($lines)) - 1;
            return $this->formatResponseArray($lines, $lineNumber, $movieName);
        } else {
            // something.  anything
            return $this->default;
        }
    }

    /**
     * Get line from file by line number in file
     *
     * @param  string $movieName  the filename
     * @param  int    $lineNumber The line number starting at 1
     * @return array              The response data
     */
    protected function getLineByNumber($movieName, $lineNumber)
    {
        // get the array of lines
        $lines = $this->loadData($movieName);

        // If we have lines...
        if ($lines) {
            return $this->formatResponseArray($lines, $lineNumber, $movieName);
        } else {
            return $this->default;
        }
    }

    /**
     * Load the file and return the data
     *
     * @param  string $movieName the filename
     * @return array             the raw array of all the lines
     */
    protected function loadData($movieName)
    {
        // Get the file and read it into an array
        $filename = $this->path . "$movieName.txt";

        // supressing the errors is stupid, but I'm tired
        return @file($filename, FILE_IGNORE_NEW_LINES);
    }

    /**
     * Format data for response
     *
     * @param  array  $lines      The array of lines
     * @param  int    $lineNumber The index of the line we want
     * @param  string $movieName  The name of the file
     * @return array              The formatted data
     */
    protected function formatResponseArray($lines, $lineNumber, $movieName)
    {
        // The first line of the file is the movie title.  Grab it and get rid of it.
        $title = $lines[0];
        unset($lines[0]);
        $lines = array_values($lines);

        // return the obvious
        return array(
            "line"  => $lines[$lineNumber],
            "title" => $title,
            "permalink" => base64_encode(json_encode([$movieName, $lineNumber]))
        );
    }
}