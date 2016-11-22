<?php

$title = "Incredible PBX";
$sub_title = "Welcome to Incredible PBX";
$root_application = "/incrediblepbx";

$xivo_host = "127.0.0.1";
$xivo_backend_user = "xivo_admin";

$xivo_host = false !== getenv('XIVO_HOST') ? getenv('XIVO_HOST') : $xivo_host;
$xivo_host_db = false !== getenv('XIVO_HOST_DB') ? getenv('XIVO_HOST_DB') : $xivo_host_db;
$xivo_backend_user = false !== getenv('XIVO_BACKEND_USER') ? getenv('XIVO_BACKEND_USER') : $xivo_backend_user;

?>
