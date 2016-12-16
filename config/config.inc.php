<?php

$title = "Incredible PBX";
$sub_title = "Welcome to Incredible PBX";
$root_application = "/incrediblepbx";

$wazo_host = "127.0.0.1";
$wazo_backend_user = "xivo_admin";

$wazo_host = false !== getenv('WAZO_HOST') ? getenv('WAZO_HOST') : $wazo_host;
$wazo_backend_user = false !== getenv('WAZO_BACKEND_USER') ? getenv('WAZO_BACKEND_USER') : $wazo_backend_user;

?>
