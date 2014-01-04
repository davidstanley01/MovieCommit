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
}