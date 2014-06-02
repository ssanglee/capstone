--TEST--
Test opendir() function : error conditions - Non-existent directory
--SKIPIF--
<?php
if (substr(PHP_OS, 0, 3) != 'WIN') {
  die("skip Valid only on Windows");
}
?>
--FILE--
<?php
/* Prototype  : mixed opendir(string $path[, resource $context])
 * Description: Open a directory and return a dir_handle 
 * Source code: ext/standard/dir.c
 */

/*
 * Pass a non-existent directory as $path argument to opendir() to test behaviour
 */

echo "*** Testing opendir() : error conditions ***\n";

echo "\n-- Pass a non-existent absolute path: --\n";
$path = dirname(__FILE__) . "/idonotexist";
var_dump(opendir($path));

echo "\n-- Pass a non-existent relative path: --\n";
chdir(dirname(__FILE__));
var_dump(opendir('idonotexist'));
?>
===DONE===
--EXPECTF--
*** Testing opendir() : error conditions ***

-- Pass a non-existent absolute path: --

Warning: opendir(%s/idonotexist,%s/idonotexist): The system cannot find the file specified. (code: %d) in %s on line %d

Warning: opendir(%s/idonotexist): failed to open dir: %s in %s on line %d
bool(false)

-- Pass a non-existent relative path: --

Warning: opendir(idonotexist,idonotexist): The system cannot find the file specified. (code: %d) in %s on line %d

Warning: opendir(idonotexist): failed to open dir: %s in %s on line %d
bool(false)
===DONE===
