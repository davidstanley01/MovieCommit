<?php

class MovieCommitTest extends \BaseTest
{
    /**
     * @test
     */
    public function testGetLineMethodReturnsLine()
    {
        $movieData = array(
            'HolyGrail'
        );
        $testLine = 'The nights who say, "ni!". - HolyGrail';
        $testPath = __DIR__ .'/../data/';

        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->setConstructorArgs(array($movieData))
            ->setMethods(array())
            ->getMock();

        $this->setAttribute($movieMock, 'path', $testPath);
        $movie = $this->invokeMethod($movieMock, 'getLine');
        $this->assertEquals($movie, $testLine, 'Picked the wrong week to quit sniffing glue');
    }

    /**
     * @test
     */
    public function testGetLineMethodReturnsProperValueOnMissingFile()
    {
        $movieData = array(
            'NakedGun'
        );
        $testLine = "Dave's not here, man.";
        $testPath = __DIR__ .'/../data/';

        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->setConstructorArgs(array($movieData))
            ->setMethods(array())
            ->getMock();

        $this->setAttribute($movieMock, 'path', $testPath);
        $movie = $this->invokeMethod($movieMock, 'getLine');
        $this->assertEquals($movie, $testLine, 'Picked the wrong week to quit sniffing glue');
    }

    /**
     * @test
     */
    public function testGetLineMethodReturnsProperValueOnEmptyFile()
    {
        $movieData = array(
            'EmptyFile'
        );
        $testLine = "Dave's not here, man.";
        $testPath = __DIR__ .'/../data/';

        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->setConstructorArgs(array($movieData))
            ->setMethods(array())
            ->getMock();

        $this->setAttribute($movieMock, 'path', $testPath);
        $movie = $this->invokeMethod($movieMock, 'getLine');
        $this->assertEquals($movie, $testLine, 'Picked the wrong week to quit sniffing glue');
    }
}