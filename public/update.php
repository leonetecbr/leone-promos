<?php
require __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_GET['access_token']===$_ENV['PASSWORD_WEBHOOK']) {
  file_put_contents('resources/logs/git_updates.txt', shell_exec('git pull origin main 2>&1')."\n", FILE_APPEND);
}