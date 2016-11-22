<?php

/*
 Copyright (C) 2016 - Ward Mundy, Sylvain Boily
 SPDX-License-Identifier: GPL-3.0+
*/


include_once("restclient.php");


class XiVO {

    function __construct($xivo_host) {
        $this->xivo_host = $xivo_host;
        $this->xivo_backend_user = "xivo_user";
        $this->xivo_session = $_COOKIE['asteridex']['session'];
        $this->xivo_uuid = $this->_get_uuid();
    }

    private function _connect($port, $version, $token=NULL, $login=NULL, $password=NULL) {
        $connect = new RestClient([
            'base_url' => "https://$this->xivo_host:$port/$version",
            'headers' => ['X-Auth-Token' => $token],
            'curl_options' => [CURLOPT_SSL_VERIFYPEER => false,
                               CURLOPT_SSL_VERIFYHOST => false,
                               CURLOPT_ENCODING => 'application/json',
                              ],
            'decoders' => ['json'],
            'username' => $login,
            'password' => $password

        ]);

        return $connect;
    }

    private function _get_uuid() {
        if (empty($this->xivo_session)) {
            return false;
        }

        $connect = $this->_connect(9497, "0.1", $this->xivo_session);
        $uuid = $connect->get("token/$this->xivo_session");

        if ($uuid->info->http_code == 200) {
            return json_decode($uuid->response)->data->xivo_user_uuid; 
        }

        return false;
    }

    private function _get_token($login, $password, $backend) {
        $auth_info = json_encode(['backend' => $backend,
                                  'expiration' => 3600
                                 ]);

        $connect = $this->_connect(9497, "0.1", NULL, $login, $password);
        $t = $connect->post("token", $auth_info, ['Content-Type' => 'application/json']);

        if ($t->info->http_code == 200) {
            $info['token'] = json_decode($t->response)->data->token;
            $info['uuid'] = json_decode($t->response)->data->xivo_user_uuid;

            return $info;
        }

        return false;
    }

    public function xivo_login($login, $password) {
        $info = $this->_get_token($login, $password, $this->xivo_backend_user);

        return $info['token'];
    }

    public function xivo_logout() {
        $connect = $this->_connect(9497, "0.1");
        $connect->delete("token/$this->xivo_session");

        setcookie("asteridex[session]", "", time() - 3600);
        setcookie("asteridex[uuid]", "", time() - 3600);

        header('Location: index.php');
    }

}

?>
