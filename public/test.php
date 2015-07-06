<?php
/**
 * test.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

$errorHandler = set_error_handler('custom_error_handler');

/**
 * 自定义错误处理
 *
 * @param $errorNo
 * @param $errorStr
 * @param $errorFile
 * @param $errorLine
 *
 * @return bool
 */
function custom_error_handler($errorNo, $errorStr, $errorFile, $errorLine)
{
    $logFile = "PHP_log_%s_" . date('Ynd') . '.log';
    $now = date('Y-m-d H:i:s');
    $templateStr = "[$now] %s on line $errorLine in file $errorFile : $errorStr" . PHP_EOL;
    $logStr = '';
    switch ($errorNo) {
        case E_USER_ERROR:
            $logFile = sprintf($logFile, 'ERROR');
            $logStr = sprintf($templateStr, 'Fatal error');
            break;
        case E_USER_WARNING:
            $logFile = sprintf($logFile, 'WARNING');
            $logStr = sprintf($templateStr, 'WARNING');
            break;
        case E_USER_NOTICE:
            $logFile = sprintf($logFile, 'NOTICE');
            $logStr = sprintf($templateStr, 'NOTICE');
            break;
    }
    if ($logStr != '') {
        error_log($logStr, 3, $logFile);
    }
    return true;
}
