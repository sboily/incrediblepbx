<?php

/*
 Copyright (C) 2016 - Ward Mundy, Sylvain Boily
 SPDX-License-Identifier: GPL-3.0+
*/

require("/usr/share/php/smarty3/Smarty.class.php");

include_once("config/config.inc.php");
include_once("lib/xivo.php");

$xivo = new XiVO($xivo_host);
$xivo->xivo_backend_user = $xivo_backend_user;

$tpl = new Smarty();
$tpl->assign("title", $title);

if ($_POST) {
    $session = $xivo->xivo_login($_POST['username'], $_POST['password']);
    if ($session) {
        setcookie("asteridex[session]", $session, time() + 3600);
        header('Location: index.php');
    }
}

$session = isset($_COOKIE['asteridex']['session']) ? $_COOKIE['asteridex']['session'] : "";

if (!empty($session)) {
    $tpl->assign("displayname", "Incredible root");
    $tpl->assign("uuid", $session);
    $tpl->assign("root_application", $root_application);

    $action = '';
    if ($_GET['action']) {
       $action = $_GET['action'];
       $tpl->assign("nav", $action);
    }

    switch($action) {
        case 'users':
            $tpl->assign("users", $xivo->list_users()->items);
            $tpl->display("tpl/users.html");
            break;

        case 'cdrs':
            $tpl->assign("cdrs", array_map('str_getcsv', str_getcsv($xivo->get_cdr(), "\n")));
            $tpl->display("tpl/cdrs.html");
            break;

        case 'trunks':
            $tpl->assign("trunks", $xivo->list_trunks()->items);
            $tpl->display("tpl/trunks.html");
            break;

        case 'lines':
            $lines = $xivo->list_lines()->items;
            $array_endpoint = array();

            foreach($lines as $key => $line) {
                $sip = $xivo->get_endpoint_sip($line->id);
                $line->sip = $sip;
                array_push($array_endpoint, $line);
            }

            $tpl->assign("lines", $array_endpoint);
            $tpl->display("tpl/lines.html");
            break;

        case 'logout':
            $xivo->xivo_logout();
            break;

        default:
            $tpl->display("tpl/home.html");
    }

} else {

    $tpl->display("tpl/login.html");

}

?>
