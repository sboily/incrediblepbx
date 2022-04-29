<?php

$title = "Incredible PBX";
$sub_title = "Welcome to Incredible PBX";
$root_application = "";

$wazo_host = "127.0.0.1";
$wazo_port = 443;
$wazo_backend_user = "wazo_user";

$wazo_host = false !== getenv('WAZO_HOST') ? getenv('WAZO_HOST') : $wazo_host;
$wazo_port = false !== getenv('WAZO_PORT') ? getenv('WAZO_PORT') : $wazo_port;
$wazo_backend_user = false !== getenv('WAZO_BACKEND_USER') ? getenv('WAZO_BACKEND_USER') : $wazo_backend_user;

?>
