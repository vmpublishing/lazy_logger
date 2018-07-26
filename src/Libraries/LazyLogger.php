<?php

namespace VM\Libraries;

use \Psr\Container\ContainerInterface;
use \Psr\Log\LoggerInterface;


final class LazyLogger implements LoggerInterface {

    private $container;

    /**
     * sets the container to be used to retrieve the logger
     *
     * @param ContainerInterface $container
     */
    public function setLoggerContainer(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * returns instance of containerinterface, that must contain a value for 'logger'
     *
     * @return ContainerInterface
     */
    public function getLoggerContainer() {
        return $this->container;
    }

    public function emergency($message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->emergency($message, $context);
    }

    public function alert($message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->alert($message, $context);
    }

    public function critical($message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->critical($message, $context);
    }

    public function error($message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->error($message, $context);
    }

    public function warning($message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->warning($message, $context);
    }

    public function notice($message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->notice($message, $context);
    }

    public function info($message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->info($message, $context);
    }

    public function debug($message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->debug($message, $context);
    }

    public function log($level, $message, array $context = array()) {
        return $this->getLoggerContainer()->get('logger')->log($level, $message, $context);
    }
}
