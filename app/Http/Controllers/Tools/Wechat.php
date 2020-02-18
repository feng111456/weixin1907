<?php
namespace App\Http\Controllers\Tools;
class Wechat 
{
    const appID = 'wxff7f4f8c33328445';
    const appsecret = 'ac636f8bea398c79823344cec41e4cb2';
    /**获取access_token */
    public static function getAccess_token(){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid="
        .self::appID."&secret=".self::appsecret;
        $resStr = file_get_contents($url);
        $resArr = json_decode($resStr,true);
        return $resArr['access_token'];
    }
}
