<?php

class MovieCommitTest extends \BaseTest
{
    /**
     * @test
     */
    public function testGetLineMethodReturnsLine()
    {
        $movieName = 'HolyGrail';
        $lineNumber = 1;
        $default = [
            'line'  => 'The nights who say, "ni!".',
            'title' => 'Holy Grail',
            'permalink' => base64_encode(json_encode([$movieName, $lineNumber]))
        ];
        $testPath = __DIR__ .'/../data/';
        $fileData = file($testPath . $movieName .'.txt', FILE_IGNORE_NEW_LINES);

        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->disableOriginalConstructor()
            ->setMethods(array('formatResponseArray', 'loadData'))
            ->getMock();
        $movieMock->expects($this->once())
            ->method('loadData')
            ->will($this->returnValue($fileData));
        $movieMock->expects($this->once())
            ->method('formatResponseArray')
            ->will($this->returnValue($default));

        $this->setAttribute($movieMock, 'path', $testPath);
        $movie = $this->invokeMethod($movieMock, 'getLine', array($movieName));
        $this->assertEquals($movie, $default, 'Picked the wrong week to quit sniffing glue');
    }

    /**
     * @test
     */
    public function testGetLineMethodReturnsProperValueOnMissingFile()
    {
        $movieName = 'HolyGrail';
        $lineNumber = 1;
        $default = [
            "line"  => "Dave's not here, man.",
            "title" => "The Big Lebowski",
            "permalink" => null
        ];
        $testPath = __DIR__ .'/../data/';
        $fileData = false;

        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->disableOriginalConstructor()
            ->setMethods(array('formatResponseArray', 'loadData'))
            ->getMock();
        $movieMock->expects($this->once())
            ->method('loadData')
            ->will($this->returnValue($fileData));
        $movieMock->expects($this->never())
            ->method('formatResponseArray');

        $this->setAttribute($movieMock, 'path', $testPath);
        $movie = $this->invokeMethod($movieMock, 'getLine', array($movieName));
        $this->assertEquals($movie, $default, 'Picked the wrong week to quit sniffing glue');
    }

    /**
     * @test
     */
    public function testGetLineMethodReturnsProperValueOnEmptyFile()
    {
        $movieName = 'EmptyFile';
        $default = [
            "line"  => "Dave's not here, man.",
            "title" => "The Big Lebowski",
            "permalink" => null
        ];
        $testPath = __DIR__ .'/../data/';
        $fileData = file($testPath . $movieName .'.txt', FILE_IGNORE_NEW_LINES);

        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->disableOriginalConstructor()
            ->setMethods(array('formatResponseArray', 'loadData'))
            ->getMock();
        $movieMock->expects($this->once())
            ->method('loadData')
            ->will($this->returnValue($fileData));
        $movieMock->expects($this->never())
            ->method('formatResponseArray');

        $this->setAttribute($movieMock, 'path', $testPath);
        $movie = $this->invokeMethod($movieMock, 'getLine', array($movieName));
        $this->assertEquals($movie, $default, 'Picked the wrong week to quit sniffing glue');
    }

    /**
     * @test
     */
    public function testGetQuote()
    {
        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->disableOriginalConstructor()
            ->setMethods(array('getMovie', 'getLine'))
            ->getMock();
        $movieMock->expects($this->once())
            ->method('getMovie')
            ->will($this->returnValue('asdf'));
        $movieMock->expects($this->once())
            ->method('getLine')
            ->with($this->equalTo('asdf'))
            ->will($this->returnValue('returnValue'));

        $quote = $movieMock->getQuote();
        $this->assertEquals('returnValue', $quote);
    }

    /**
     * @test
     */
    public function testGetQuoteByIdWithValidId()
    {
        $movieName = 'HolyGrail';
        $lineNumber = 1;
        $permalink = base64_encode(json_encode([$movieName, $lineNumber]));
        $default = [
            'line'  => 'The nights who say, "ni!".',
            'title' => 'Holy Grail',
            'permalink' => $permalink
        ];

        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->disableOriginalConstructor()
            ->setMethods(array('getLineByNumber'))
            ->getMock();
        $movieMock->expects($this->once())
            ->method('getLineByNumber')
            ->with($this->equalTo($movieName),
                   $this->equalTo($lineNumber))
            ->will($this->returnValue($default));

        $result = $movieMock->getQuoteById($permalink);
        $this->assertEquals($default, $result);
    }

    /**
     * @test
     */
    public function testGetQuoteByIdWithInvalidId()
    {
        $movieName = 'HolyGrail';
        $lineNumber = 1;
        $permalink = 'asdf';
        $default = [
            "line"  => "Dave's not here, man.",
            "title" => "The Big Lebowski",
            "permalink" => null
        ];

        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->disableOriginalConstructor()
            ->setMethods(array('getLineByNumber'))
            ->getMock();
        $movieMock->expects($this->never())
            ->method('getLineByNumber');
        $this->setAttribute($movieMock, 'default', $default);

        $result = $movieMock->getQuoteById($permalink);
        $this->assertEquals($default, $result);
    }

    /**
     * @test
     */
    public function testGetMovie()
    {
        $movies = array(
            'HolyGrail'
        );
        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();
        $this->setAttribute($movieMock, 'movies', $movies);
        $result = $this->invokeMethod($movieMock, 'getMovie');

        $this->assertEquals('HolyGrail', $result);
    }

    /**
     * @test
     */
    public function testFormatResponseArray()
    {
        $lines = [
            'A Test Movie',
            'The first line'
        ];
        $lineNumber = 1;
        $movieName = 'test';

        $expected = [
            'line' => 'The first line',
            'title' => 'A Test Movie',
            'permalink' => base64_encode(json_encode([$movieName, $lineNumber]))
        ];
        $movieMock = $this->getMockBuilder('MovieCommit\MovieCommit')
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();
        $result = $this->invokeMethod(
            $movieMock,
            'formatResponseArray',
            array($lines, $lineNumber, $movieName)
        );

        $this->assertEquals($expected, $result);
    }
}