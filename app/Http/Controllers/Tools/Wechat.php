<?php
namespace App\Http\Controllers\Tools;
class Wechat 
{
    const appID = 'wxff7f4f8c33328445';
    const appsecret = 'ac636f8bea398c79823344cec41e4cb2';
    /**获取access_token */
    public static function getAccess_token(){
        $Url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxff7f4f8c33328445&secret=ac636f8bea398c79823344cec41e4cb2";
        $res = file_get_contents($Url);
        $resArr = json_decode($res,true);
        return $resArr;
    }
}
