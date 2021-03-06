#!/usr/bin/env php
<?php

// Tired of chasing typos and finding them after a commit.
// Run this from cmdline in basedir and quickly see if we've
// got any parse errors in our application files.


use Friendica\App;
use Friendica\BaseObject;

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '1');
ini_set('log_errors', '0');

include 'boot.php';

$a = new App(dirname(__DIR__));
BaseObject::setApp($a);

@include '.htconfig.php';

$phpath = $a->getConfigValue('config', 'php_path', 'php');

echo 'Directory: src' . PHP_EOL;
$Iterator = new RecursiveDirectoryIterator('src');

foreach (new RecursiveIteratorIterator($Iterator) as $file) {
	if (substr($file, -4) === '.php') {
		passthru("$phpath -l $file", $ret);
		$ret === 0 || die();
	}
}

echo "Directory: mod\n";
$files = glob('mod/*.php');
foreach ($files as $file) {
	passthru("$phpath -l $file", $ret);
	$ret === 0 || die();
}

echo "Directory: include\n";
$files = glob('include/*.php');
foreach ($files as $file) {
	passthru("$phpath -l $file", $ret);
	$ret === 0 || die();
}

echo "Directory: object\n";
$files = glob('object/*.php');
foreach ($files as $file) {
	passthru("$phpath -l $file", $ret);
	$ret === 0 || die();
}

echo "Directory: addon\n";
$dirs = glob('addon/*');

foreach ($dirs as $dir) {
	$addon = basename($dir);
	$files = glob($dir . '/' . $addon . '.php');
	foreach ($files as $file) {
		passthru("$phpath -l $file", $ret);
		$ret === 0 || die();
	}
}

echo "String files\n";

echo 'util/strings.php' . "\n";
passthru("$phpath -l util/strings.php", $ret);
$ret === 0 || die();

$files = glob('view/lang/*/strings.php');
foreach ($files as $file) {
	passthru("$phpath -l $file", $ret);
	$ret === 0 || die();
}
