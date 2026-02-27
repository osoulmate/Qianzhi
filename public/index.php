<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

/**
 * 优先兼容旧的 ?url=controller/action 参数，
 * 同时支持通过 REQUEST_URI 解析路由，避免依赖 .htaccess 重写。
 */
$url = null;
if (isset($_GET['url']) && $_GET['url'] !== '') {
    $url = trim($_GET['url'], '/');
} else {
    $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $scriptDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

    if ($scriptDir !== '' && $scriptDir !== '.' && strpos($requestUri, $scriptDir) === 0) {
        $requestUri = substr($requestUri, strlen($scriptDir));
    }

    $requestUri = trim($requestUri, '/');
    $url = $requestUri === '' ? null : $requestUri;
}

require_once(ROOT . DS . 'library' . DS . 'bootstrap.php');
