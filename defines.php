<?php

$env = new Dotenv\Dotenv(__DIR__);
$env->load();

define('DIR_BASE', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
define('DIR_PUBLICO', DIR_BASE. DS . getenv('DIR_PUBLICO') . DS);
define('DIR_APLICACION', DIR_BASE . DS . getenv('DIR_APP') . DS);
define('DIR_VIEWS', DIR_APLICACION . getenv("DIR_TEMPLATES"));
define('DIR_DB', DIR_BASE. DS . getenv('DIR_DB') . DS);
define('DB', DIR_DB. getenv('DB'));