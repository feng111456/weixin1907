<?php
namespace App\Http\Controllers\Tools;
use Illuminate\Support\Facades\Cache;
class Wechat 
{
    const appID = 'wxff7f4f8c33328445';
    const appsecret = 'ac636f8bea398c79823344cec41e4cb2';
    /**获取access_token */
    public static function getAccess_token(){
        $access_token = Cache::get('access_token');
        if(impty($access_token)){
            $Url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::appID."&secret=".self::appsecret;
            $res = file_get_contents($Url);
            $resArr = json_decode($res,true);
            Cache::put('access_token',$resArr['access_token'],7000);
            $access_token = Cache::get('access_token');
            return $access_token;
        }
        return $access_token;
        

    }
}
