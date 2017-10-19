<?php
/**
 * Created by PhpStorm.
 * User: darkwindcc
 * Date: 17-10-18
 * Time: 上午11:11
 */

namespace Darkwind\Certification\Src;


class JiSuCertification implements CertificationInterface
{

    private $config;

    public function __construct($config = [])
    {
        $default_config = [];
        $this->config = array_merge($config, $default_config);
    }

    public function certification($realname, $idcard, $bankcard, $mobile)
    {
        $errors = $this->filter($realname, $idcard, $bankcard, $mobile);
        if ($errors) {
            return [
                'status' => 'error',
                'verifymsg' => implode(',', $errors),
                'errormsg' => '参数不正确'
            ];
        }
        $host = "http://jisubank4.market.alicloudapi.com";
        $path = "/bankcardverify4/verify";
        $method = "GET";
        $appcode = $this->config['appcode'];
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);

        $querys = "bankcard={$bankcard}&idcard={$idcard}&mobile={$mobile}&realname={$realname}";
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
        $result = $this->result($jsonarr);
        return $result;

    }

    private function filter($realname, $idcard, $bankcard, $mobile)
    {
        $errors = [];
        if (strlen($idcard) != 18) {
            $errors[] = '身份证号不正确';
        }
        if (strlen($bankcard) < 16) {
            $errors[] = '银行卡号不正确';
        }
        $mobile = intval($mobile);
        if (strlen($mobile) < 6) {
            $errors[] = '手机号码不正确';
        }
        return $errors;
    }

    private function result($jsonarr)
    {
        if (!$jsonarr) {
            return [
                'status' => 'error',
                'verifymsg' => '网络链接失败，请重试',
                'errormsg' => '接口秘钥错误'
            ];
        }
        if ($jsonarr['status'] != 0) {
            return [
                'status' => 'error',
                'verifymsg' => $jsonarr['msg'],
                'errormsg' => $jsonarr['msg']
            ];
        }
        //通信成功
        $result = $jsonarr['result'];
        if ($result['verifystatus'] == 0) {
            return [
                'status' => 'ok',
                "bankcard" => $result['bankcard'],
                "realname" => $result['realname'],
                "idcard" => $result['idcard'],
                "mobile" => $result['mobile'],
                "verifymsg" => $result['verifymsg']
            ];
        } else {
            return [
                'status' => 'error',
                "bankcard" => $result['bankcard'],
                "realname" => $result['realname'],
                "idcard" => $result['idcard'],
                "mobile" => $result['mobile'],
                "verifymsg" => $result['verifymsg']
            ];
        }
    }
}