#!/usr/bin/php
<?php

//For easy use.

//TODO: probably need to rewrite it to symfony command

use Hexmedia\Crontab\Reader\SystemReader;
use Hexmedia\Crontab\Writter\SystemWritter;
use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\ReaderFactory;

include("../vendor/autoload.php");

if ($argc < 2) {
    error_log("Too less arguments for crontab.");
}

$action = null;
$user = null;
$file = null;
$type = 'ini';
$name = null;
$machine = null;

foreach ($argv as $i => $arg) {
    switch ($arg) {
        case "synchronize":
            if (null === $action) {
                $action = "synchronize";
            } else {
                error_log("Cannot call two actions at once");
            }
            break;
        case "echo":
            if (null === $action) {
                $action = "echo";
            } else {
                error_log("Cannot call two actions at once");
            }
            break;
        case "--user":
            $user = $argv[$i + 1];
            unset($argv[$i + 1]);
            break;
        case "--file":
            $file = $argv[$i + 1];
            unset($argv[$i + 1]);
            break;
        case "--type":
            $type = $argv[$i + 1];
            unset($argv[$i + 1]);
            break;
        case "--name":
            $name = $argv[$i + 1];
            unset($argv[$i + 1]);
            break;
        case "--machine":
            $machine = $argv[$i + 1];
            unset($argv[$i + 1]);
            break;
    }
}

if (null === $file) {
    error_log("Configuration file not provided.");
    exit;
}

switch ($action) {
    case "synchronize":
    case "echo":
        $conf = array();

        if (null !== $user) {
            $conf['user'] = $user;
        }

        $crontab = new Crontab($user, $name);

        $systemReader = new SystemReader($crontab, $conf);

        $conf['file'] = $file;


        if (null !== $machine) {
            $conf['machine'] = $machine;
        }

        $conf['type'] = $type;
        $conf['crontab'] = $crontab;

        $crontab = $systemReader->read();
        $crontab->clearManagedTasks();

        $configReader = ReaderFactory::create($conf);

        $crontab = $configReader->read();

        $writter = new SystemWritter($conf);

        if ($action == "echo") {
            echo $writter->toCronFile($crontab);
        } else {
            $writter->save($crontab);
        }
        break;
    default:
        error_log("Unknown action.");
}
