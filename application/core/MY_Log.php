<?php 
class MY_Log extends CI_Log {

public function write_log($level, $msg)
{
    $backtrace = debug_backtrace();
    $caller = isset($backtrace[3]) ? $backtrace[3] : null;
    if ($caller) {
        $logMessage = "File: {$caller['file']}, Line: {$caller['line']} , MSG: " .$msg;
      
    }
    return parent::write_log($level, $logMessage);
}

}