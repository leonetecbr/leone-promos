<?php
require __DIR__.'/router.php';

$router = new Router;

require __DIR__.'/pages.php';

$router->run();