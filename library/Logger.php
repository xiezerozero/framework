<?php
/**
 * Logger.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library;


/**
 * Class Logger
 *
 * @package Library
 */
class Logger
{
    const EMERGENCY = 0;

    const CRITICAL = 1;

    const ERROR = 2;

    const WARNING = 3;

    const NOTICE = 4;

    const INFO = 5;

    const DEBUG = 6;

    const CUSTOM = 7;

    const SPECIAL = 8;

    private $_logLevel;

    private $_filePath;

    /**
     * @param $filePath
     */
    function __construct($filePath)
    {
        $this->_filePath = $filePath;
    }

    /**
     * @param $type
     * @param $message
     */
    public function log($type, $message)
    {
        $title = '[' . date('D, d F H:i:s P') . ']';
        switch ($type) {
            case self::CRITICAL:
                $title .= '[CRITICAL]';
                break;
            case self::EMERGENCY:
                $title .= '[EMERGENCY]';
                break;
            case self::ERROR:
                $title .= '[ERROR]';
                break;
            case self::WARNING:
                $title .= '[WARNING]';
                break;
            case self::NOTICE:
                $title .= '[NOTICE]';
                break;
            case self::INFO:
                $title .= '[INFO]';
                break;
            case self::DEBUG:
                $title .= '[DEBUG]';
                break;
            case self::CUSTOM:
                $title .= '[CUSTOM]';
                break;
            case self::SPECIAL:
                $title .= '[SPECIAL]';
                break;
            default:
                break;
        }
        error_log($title . $message, 3, $this->_filePath);
    }

    /**
     * @param $message
     */
    public function debug($message)
    {
        $this->log(self::DEBUG, $message);
    }


    /**
     * @param $message
     */
    public function info($message)
    {
        $this->log(self::INFO, $message);
    }

    /**
     * @param $message
     */
    public function notice($message)
    {
        $this->log(self::NOTICE, $message);
    }

    /**
     * @param $message
     */
    public function warning($message)
    {
        $this->log(self::WARNING, $message);
    }

    /**
     * @param $message
     */
    public function error($message)
    {
        $this->log(self::ERROR, $message);
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->_filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $this->_filePath = $filePath;
    }

    /**
     * @return int
     */
    public function getLogLevel()
    {
        return $this->_logLevel;
    }

    /**
     * @param int $logLevel
     */
    public function setLogLevel($logLevel)
    {
        $this->_logLevel = $logLevel;
    }


} 