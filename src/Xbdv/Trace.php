<?php

namespace Xbdv;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Xbdv\Formatter\NoneFormatter;

/**
 * Description of Trace
 *
 * @author xbdv
 */
class Trace
{

    /**
     * nom du fichier de log
     */
    private $logName = "trace.log";

    /**
     * @var Logger
     */
    private $log = null;

    /**
     * record time
     * @var array 
     */
    private $flagRecord = array();

    /**
     * 
     * @var string
     */
    private $buffer;

    /**
     * renvoi C:\temp sous windows
     * renvoi /tmp sinon
     * @return string temp directory
     */
    private function getTmpDir()
    {
        if (preg_match('/win/i', PHP_OS)) {
            return "C:" . DIRECTORY_SEPARATOR . "temp";
        }
        return "/tmp";
    }

    /**
     * fabrique au besoin et renvoi un objet Zend_Log
     * @return Zend_Log
     */
    private function getLog()
    {
        if ($this->log === NULL) {
            $this->log = new Logger('xbdv_log');
            $streamHandler = new StreamHandler(
                    $this->getTmpDir() . DIRECTORY_SEPARATOR . $this->logName, Logger::DEBUG);
            $streamHandler->setFormatter(new NoneFormatter());
            $this->log->pushHandler($streamHandler);
        }
        return $this->log;
    }

    /**
     * memorisation d'une string pour affichage ulterieur
     * @param string $str 
     */
    public function appendBuffer($str)
    {
        $this->buffer .= $str;
    }

    /**
     * log msg in a file
     * @param string $msg
     */
    public function log($msg)
    {
        echo $msg;
        $log = $this->getLog();
        //$log->info($msg . " : " . xdebug_time_index());
        $log->info($msg);
    }

    /**
     * calculate time spend beetween 2 identicals flags
     * 
     * @param string $flag
     * @param boolean $purgeBuffer
     */
    public function flag($flag, $purgeBuffer = true)
    {
        if (!isset($this->flagRecord[$flag])) {
            $this->flagRecord[$flag] = microtime(true);
        } else {
            $log = $this->getLog();
            $now = microtime(true);
            $timeSpendInFlag = $now - $this->flagRecord[$flag];
            $this->flagRecord[$flag] = $now;
            $msg = $this->buffer . "\n" . "time spend between last <$flag> flag : " . $timeSpendInFlag . " at " . $now;
            $log->info($msg);

            if ($purgeBuffer) {
                $this->buffer = '';
            }
        }
    }

    /**
     * var_dump the param into log file
     * @param mixed $foo
     */
    public function dump($foo, $deep = NULL)
    {
        if (!is_null($deep)) {
            ini_set('xdebug.var_display_max_depth', $deep);
        }
        ob_start();
        var_dump($foo);
        $this->log(ob_get_clean());
    }

    /**
     * var_dump de la pile d'appel de la fonction
     * @throws Opitml_Exception_Trace
     */
    public function dumpTrace()
    {
        try {
            throw new Exception ();
        } catch (Opitml_Exception_Trace $ex) {
            $this->dump($ex->getTraceAsString());
        }
    }

}
