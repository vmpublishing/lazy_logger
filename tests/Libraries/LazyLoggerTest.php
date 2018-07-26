<?php

namespace VM\Libraries\Tests;

use \PHPUnit\Framework\TestCase;
use \Psr\Container\ContainerInterface;
use \Psr\Log\LoggerInterface;
use \VM\Libraries\LazyLogger;

class LazyLoggerTest extends TestCase
{

    protected $container_mock;

    protected $logger_mock;

    protected $lazy_logger;

    protected $logger_state_methods = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug',
    ];

    public function setUp()
    {

        $this->container_mock = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'has', 'set'])
            ->getMock()
        ;

        $this->logger_mock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(array_merge($this->logger_state_methods, ['log']))
            ->getMock()
        ;

        $this->lazy_logger = new LazyLogger;
        $this->lazy_logger->setLoggerContainer($this->container_mock);
    }

    public function tearDown()
    {
        $this->container_mock = null;
        $this->logger_mock    = null;
    }

    public function testLoggerStateMethodsShouldFetchTheLoggerAndPassThroughTheRequest()
    {

        $test_message = 'some test message';
        $test_data    = ['some' => 'test data'];

        foreach ($this->logger_state_methods as $logger_state_method) {
            $this->setUp();
            $this->logger_mock->expects($this->once())
                ->method($logger_state_method)
                ->with($test_message, $test_data)
            ;
            $this->container_mock->expects($this->once())
                ->method('get')
                ->with('logger')
                ->willReturn($this->logger_mock)
            ;

            $this->lazy_logger->$logger_state_method($test_message, $test_data);
            $this->tearDown();
        }
    }

    public function testLogMethodShouldPassThroughTheRequestToTheActualLogger() {
        $test_message = 'some test message';
        $test_data    = ['some' => 'test data'];
        $test_level   = 'some level';

        $this->logger_mock->expects($this->once())
            ->method('log')
            ->with($test_level, $test_message, $test_data)
        ;
        $this->container_mock->expects($this->once())
            ->method('get')
            ->with('logger')
            ->willReturn($this->logger_mock)
        ;

        $this->lazy_logger->log($test_level, $test_message, $test_data);
    }

}
