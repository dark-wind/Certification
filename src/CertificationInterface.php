<?php
/**
 * Created by PhpStorm.
 * User: darkwindcc
 * Date: 17-10-18
 * Time: 上午11:07
 */

namespace Darkwind\Certification\Src;


interface CertificationInterface
{
    /**
     * 用户四要素验证接口
     * @param $realname
     * @param $idcard
     * @param $bankcard
     * @param $mobile
     * @return mixed
     */
    public function certification($realname, $idcard, $bankcard, $mobile);
}