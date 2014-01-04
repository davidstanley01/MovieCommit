<?php namespace MovieCommit;

class Tracking
{
    /**
     * Holder for tracking object
     *
     * @var obj
     */
    public $stack;

    /**
     * Pageview object
     *
     * @var obj
     */
    public $pageview;

    /**
     * Environment variable
     *
     * @var string
     */
    public $env;

    /**
     * Class Constructor
     * @param string $env Environment Variable
     */
    public function __construct($env)
    {
        $this->env = $env;
        $this->stack = $this->newTracking();
        $this->pageview = $this->newPageView();
        $this->stack->setAccountID('UA-46582110-1');
    }

    /**
     * Cheap-ass DI for tracking object
     *
     * @return \Racecore\GATracking\GATracking Tracking obj
     */
    public function newTracking()
    {
        return new \Racecore\GATracking\GATracking();
    }

    /**
     * Cheap-ass DI for pageview object
     *
     * @return \Racecore\GATracking\Tracking\Pageview Pageview obj
     */
    public function newPageView()
    {
        return new \Racecore\GATracking\Tracking\Pageview();
    }

    /**
     * Set the PageView Values
     *
     * @param string $path  Page being viewed
     * @param string $title Title of page
     *
     * @return null
     */
    public function setPageView($path, $title)
    {
        $this->pageview->setDocumentPath($path);
        $this->pageview->setDocumentTitle($title);

        // add to stack
        $this->stack->addTracking($this->pageview);
    }

    /**
     * Send the page view
     *
     * @return void
     */
    public function send()
    {
        // if we are in prod, then send the analytics
        if ($this->env == 'prod') {
            try {
                $this->stack->send();
            } catch (Exception $e) {
                echo "shit";
            }
        }
    }
}