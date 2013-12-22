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

    public function getQuoteById($id)
    {
        // decode the id
        $movie = json_decode(base64_decode($id), true);

        if ($movie) {
            list($movieName, $title, $line) = $movie;
            return [
                'line' => $line,
                'title' => $title,
                'permalink' => $id
            ];
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
    protected function getLine($movie)
    {
        // Get the file and read it into an array
        $filename = $this->path . "$movie.txt";

        // supressing the errors is stupid, but I'm tired
        $lines = @file($filename, FILE_IGNORE_NEW_LINES);

        // If we have lines...
        if ($lines) {

            // The first line of the file is the movie title.  Grab it and get rid of it.
            $title = $lines[0];
            unset($lines[0]);
            $lines = array_values($lines);

            // get our line.  subtract 1 to account for zero index
            $line = (count($lines) == 1) ? 0 : rand(1, count($lines)) - 1;

            // return the obvious
            return array(
                "line"  => $lines[$line],
                "title" => $title,
                "permalink" => base64_encode(
                    json_encode([$movie, $title, $lines[$line]])
                )
            );

        } else {

            // something.  anything
            return $this->default;
        }
    }
}