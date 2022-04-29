<?php

/*
 Copyright (C) 2016-2022 Ward Mundy, Sylvain Boily
 SPDX-License-Identifier: GPL-3.0+
*/

require("/usr/local/lib/php/Smarty/Smarty.class.php");

include_once("config/config.inc.php");
include_once("lib/wazo.php");

$wazo = new Wazo($wazo_host, $wazo_port);
$wazo->backend_user = $wazo_backend_user;

$tpl = new Smarty();
$tpl->assign("title", $title);

if ($_POST) {
    $session = $wazo->login($_POST['username'], $_POST['password']);
    if ($session) {
        setcookie("wazo[session]", $session, time() + 3600);
        header('Location: index.php');
    }
}

$session = isset($_COOKIE['wazo']['session']) ? $_COOKIE['wazo']['session'] : "";
$tenant_uuid = isset($_COOKIE['wazo']['tenant_uuid']) ? $_COOKIE['wazo']['tenant_uuid'] : "";
$wazo->tenant_uuid = $tenant_uuid;

if (!empty($session)) {
    $tpl->assign("displayname", "Incredible root");
    $tpl->assign("uuid", $session);
    $tpl->assign("root_application", $root_application);
    $obj_tenants = $wazo->list_tenants()->items;
    $tenants = array();
    foreach($obj_tenants as $key => $value) {
        $tenants[$value->uuid] = $value->name;
    }
    $tpl->assign("tenants", $tenants);
    $tpl->assign("tenant_uuid", $tenant_uuid);

    $action = '';
    if ($_GET['action']) {
       $action = $_GET['action'];
       $tpl->assign("nav", $action);
    }

    switch($action) {
        case 'users':
            $tpl->assign("users", $wazo->list_users()->items);
            $tpl->display("tpl/users.html");
            break;

        case 'cdrs':
            $tpl->assign("cdrs", $wazo->get_cdr()->items);
            $tpl->display("tpl/cdrs.html");
            break;

        case 'trunks':
            $tpl->assign("trunks", $wazo->list_trunks()->items);
            $tpl->display("tpl/trunks.html");
            break;

        case 'lines':
            $lines = $wazo->list_lines()->items;
            $array_endpoint = array();

            foreach($lines as $key => $line) {
                $sip = $wazo->get_endpoint_sip($line->id);
                $line->sip = $sip;
                array_push($array_endpoint, $line);
            }

            $tpl->assign("lines", $array_endpoint);
            $tpl->display("tpl/lines.html");
            break;

        case 'logout':
            $wazo->logout();
            break;

        default:
            $tpl->display("tpl/home.html");
    }

} else {

    $tpl->display("tpl/login.html");

}

?>
