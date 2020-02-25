<?php
namespace App\Http\Controllers\Tools;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Tools\Curl;
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
    /**回复文本信息的方法*/
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
        //echo $xmlData;
    } 
    /**获取微信服务器ip */
    public static function getWechatIp(){
        //获取access_token
        $access_token = self::getAccess_token();
        //获取微信服务器ip接口
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$access_token;
        //调用curl发送请求
        $WechatIp = Curl::curlGet($url);
        return $WechatIp;
    }
    /**添加菜单的方法 */
    public static function addMenu(){
        //获取access_token
        $access_token = self::getAccess_token();
        //添加问下菜单接口
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $data = [
            'button'=>[
                //一级菜单
                [
                'type'=>'click',
                'name'=>'今日菜单',
                'key'=>'vx00001'
                ],
                [
                   //菜单 带子级菜单
                   'name'=>'菜单',
                   'sub_button'=>[
                       [
                           'type'=>'view',
                           'name'=>'百度一下',
                           'url'=>"http://www.baidu.com/"
                       ],
                       [
                            'name'=>'发送位置',
                            'type'=>'location_select',
                            'key'=>'v00002'
                       ]
                   ] 
                ],
                [
                    'name'=>'发图',
                    'sub_button'=>[
                        [
                            "type"=>"pic_sysphoto", 
                            "name"=>"拍照发图", 
                            "key"=>"v00003", 
                        ],
                        [
                            "type"=>"pic_weixin", 
                            "name"=>"微信相册发图", 
                            "key"=> "v00004", 
                        ]
                    ]
                ]
            ]
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        $res = Curl::curlPost($url,$data);
        return $res;
    }
}
