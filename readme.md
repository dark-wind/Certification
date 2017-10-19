功能

扩展包提供四要素身份验证功能
对参数进行基本判断，返回判断结果

集成配置文件：
php artisan vendor:publish

可以不写配置文件，直接添加秘钥数据给接口


接受参数：

    realname    真实姓名
    idcard      身份证号码     
    bankcard    银行卡号
    mobile      电话号码
    
返回值：

        成功
        return [
                    'status'=>'ok',
                    "bankcard"=> '39898789798789',
                    "realname"=>'小明',
                    "idcard"=>'41908988776786',
                    "mobile"=>'10086',
                    "verifymsg"=>'验证信息'
                ];
                
        接口认证失败。。欠费了                
        return [
                        'status'=>'error',
                        'verifymsg'=>'网络链接失败，请重试',
                        'errormsg'=>'接口秘钥错误'
                ];
                
        验证失败
         return [
                        'status'=>'error',
                        'verifymsg'=>'用户错误提示',
                        'errormsg'=>'真实错误原因'
                ];