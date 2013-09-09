<?php
$currentIncPath = get_include_path();
// Application Path Root is one dir above.
$appPath =  __DIR__ . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR;
// Add Application Path to our include paths
set_include_path($currentIncPath . PATH_SEPARATOR . $appPath );

// Autoloader function that is PSR-0 compliant
// @todo Make this an object include exception handling. 
function upvoteAutoload($className)
{
	$className = ltrim($className, '\\');
	$fileName  = '';
	$namespace = '';
	if ($lastNsPos = strrpos($className, '\\')) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

	require $fileName;
}
// Register the autoloader with the spl autoloader.
spl_autoload_register('upvoteAutoload');

// Start A session
session_start();

// Get our configuration array (Include for now)
$config = require_once('../config.php');
$frontController = new \Upvote\Library\Front\Controller($config);

// @todo try/catch?
echo $frontController->execute();