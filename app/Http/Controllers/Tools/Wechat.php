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
        if(empty($access_token)){
            $Url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::appID."&secret=".self::appsecret;
            $res = file_get_contents($Url);
            $resArr = json_decode($res,true);
            Cache::put('access_token',$resArr['access_token'],7000);
            $access_token = Cache::get('access_token');
            return $access_token;
        }
        return $access_token;
    }
    /**被动回复文本信息的方法*/
    public static function restoreText($xmlObj,$Content){
        $xmlText = "<xml>
			  <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
			  <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
			  <CreateTime>".time()."</CreateTime>
			  <MsgType><![CDATA[text]]></MsgType>
			  <Content><![CDATA[".$Content."]]></Content>
            </xml>";
        echo $xmlText;
    } 
    /**回复文章方法 */
    public static function restoreNews($xmlObj,$contentArr){
       $xmlData= "<xml>
                        <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
                        <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
                        <CreateTime>".time()."</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>".count($contentArr)."</ArticleCount>
                        <Articles>";
                        foreach($contentArr as $v){
                            $xmlData.="<item>
                                        <Title><![CDATA[".$v['Title']."]]></Title>
                                        <Description><![CDATA[".$v['Description']."]]></Description>
                                        <PicUrl><![CDATA[".$v['PicUrl']."]]></PicUrl>
                                        <Url><![CDATA[".$v['Url']."]]></Url>
                                    </item>";
                        }   
                    $xmlData .="</Articles>
                    </xml>";
        echo $xmlData;
    } 
}
