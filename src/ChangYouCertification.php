<?php
/**
 * Created by PhpStorm.
 * User: darkwindcc
 * Date: 17-10-18
 * Time: 上午11:11
 */

namespace Darkwind\Certification\Src;


class ChangYouCertification implements CertificationInterface
{
    private $config;

    public function __construct($config = [])
    {
        $default_config = [];
        $this->config = array_merge($config, $default_config);
    }

    public function certification($realname, $idcard, $bankcard, $mobile)
    {
        $host = "http://jisubank4.market.alicloudapi.com";
        $path = "/bankcardverify4/verify";
        $method = "GET";
        $appcode = "your_appcode";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $realname = '张先生';  //真实姓名 utf8格式
        $querys = "bankcard=6228480402564881235&idcard=410184198501181235&mobile=13333333333&realname=$realname";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $result = curl_exec($curl);

        $jsonarr = json_decode($result, true);
        if ($jsonarr['status'] != 0) {
            echo $jsonarr['msg'];
            exit();
        }

        $result = $jsonarr['result'];
        echo $result['bankcard'] . ' ' . $result['realname'] . ' ' . $result['mobile'] . ' ' . $result['idcard'] . '<br />';
        echo $result['verifystatus'] . ' ' . $result['verifymsg'] . '<br />';
    }
}