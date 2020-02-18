<?php
namespace App\Http\Controllers\Tools;
class Wechat 
{
    const appID = 'wxff7f4f8c33328445';
    const appsecret = 'ac636f8bea398c79823344cec41e4cb2';
    /**获取access_token */
    public static function getAccess_token(){
        $access_token ='';
        $access_token.= file_get_contents('/access_token.txt');
        if(empty($access_token)){
            echo "未发现文件";
        }
        $access_token = json_decode($access_token,true);
        if(time()-$access_token['time']>=7000){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid="
            .self::appID."&secret=".self::appsecret;
            $resStr = file_get_contents($url);    
            $resArr = json_decode($resStr,true);
            $resArr['time']= time();
            $resString = json_encode($resArr);
            file_put_contents('/access_token.txt',$resString);
            $access_token = file_get_contents('/access_token.txt');
            $access_token = json_decode($access_token,true);
            return $access_token['access_token'];
        }    
        return $access_token['access_token'];
    }
}
