<?php namespace Notify;

define('IS_NOTIFY', true);
include __DIR__.'/lib/Processor.php';
include __DIR__.'/lib/Controller.php';
include __DIR__.'/lib/Mailer.php';

$processor = new Processor();
$controller = new Controller($processor);
