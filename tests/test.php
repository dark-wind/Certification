<?php
/**
 * Created by PhpStorm.
 * User: darkwindcc
 * Date: 17-10-19
 * Time: 下午4:57
 */

require '../src/CertificationInterface.php';
require '../src/JiSuCertification.php';
require '../src/ChangYouCertification.php';

//参数过滤
$realname = '小明';
$idcard = 'error_idcard';
$bankcard = 'error_bankcard';
$mobile = 1234567890;
$api = new \Darkwind\Certification\Src\JiSuCertification();
$result = $api->certification($realname, $idcard, $bankcard, $mobile);

if ($result['status'] == 'error') {
    echo "√\n";
}

