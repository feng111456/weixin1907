<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Tools\Wechat;
use App\Http\Controllers\Tools\Curl;
use App\Model\Send;

class WechatController extends Controller
{
    public function index(){
        // $signature  = request()->signature;
        // if(!empty($signature)){
        //     $timestamp  = request()->timestamp;
        //     $nonce      = request()->nonce;
        //     $token = '123456abc';
        //     $tmparrat = array($token,$timestamp,$nonce);
        //     sort($tmparrat,SORT_STRING);
        //     $impstr = implode($tmparrat);
        //     $impstr = sha1($impstr);
        //     if($impstr == $signature){
        //         echo $_GET['echostr'];
        //          连接测试成功
        //     } 
        // }
        //调用获取access_token方法
        //$access_token =Wechat::getAccess_token(); 
        //$wechatIp = Wechat::getWechatIp();
        //print_r($wechatIp);die;
        // $res = Wechat::addMenu();
        $xml=file_get_contents('php://input');
        file_put_contents('check.txt',"\n".$xml,FILE_APPEND);
        $xmlObj = simplexml_load_string($xml);
        if($xmlObj->MsgType=='event'){
            //说明是事件 在判断什么是事件
            if($xmlObj->Event=='subscribe'){
                //关注事件
                $content = '你好欢迎关注张攀峰的公众号!主要功能是复读机！亲爱的用户在您使用公众号的期间！您发送什么消息我将回复您什么消息，当你发送：文章 ，我会给你发送一篇文章';
                $res = Wechat::restoreText($xmlObj,$content);
            }else if($xmlObj->Event=='CLICK'){
                if($xmlObj->EventKey=='vx00001'){
                    //说明用户点击了今日菜单
                    $content = '您点击了今日菜单！';
                    $res = Wechat::restoreText($xmlObj,$content);
                }
            }else if($xmlObj->Event=='TEMPLATESENDJOBFINISH'){
                    $msgid = $xmlObj->MsgID;
                    $status = $xmlObj->Status=='success'?'1':'2';
                    //实例化model
                    $sendModel = new Send;
                    $addRes = $sendModel::where('msgid','=',$msgid)->updata(['status'=>$status]);
            }
        }else if($xmlObj->MsgType=='text'){
            if($xmlObj->Content=='爸爸'){
                $content = '哎！乖儿子';
                $res = Wechat::restoreText($xmlObj,$content);
            }else if($xmlObj->Content=='文章'){
               $contentArr = [
                    [
                        'Title'=>'在石家庄你到底挣多少钱你才能够养活自己',
                        'Description'=>'这世界充满着许多坎坷,觉得难过的时候,就低头看看卡里的余额,你就会更难过了！',
                        'PicUrl'=>"http://dingyue.ws.126.net/r962dQYkjNWddLGW252b2FghuUTiH8FrOnMcBmF7YbRdU1525154566271transferflag.png",
                        'Url'=>"http://dy.163.com/v2/article/detail/DGNV2ILE0514DL02.html"
                    ]
                ];
               $res = Wechat::restoreNews($xmlObj,$contentArr);
            }else{
                $content = $xmlObj->Content;
                $res = Wechat::restoreText($xmlObj,$content);
            }
        }

    }
    public function sendTemplate(){
        //获取access_token
        $access_token =Wechat::getAccess_token();
        $code = rand(100000,999999);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $data = [
                "touser"=>"om-z3we2J1YzOuQGjj1MIGu6OzOo",
                "template_id"=>"ojDgQkBLhfbA6cAhGBVDeGFdsm-YNzcyKOnh7LsHMvw",
                "data"=>[
                    "name"=>[
                        "value"=>"攀峰",
                        "color"=>"#173177"
                    ],
                    "code"=>[
                        "value"=>$code,
                        "color"=>"#173177"
                    ]
                ]
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        $res = Curl::curlPost($url,$data);
        $res = json_decode($res,true);
        $msgid = $res['msgid'];
        $sendInfo=["msgid"=>$msgid,"addtime"=>time()];
        //实例化model
        $sendModel = new Send;
        $addRes = $sendModel::create($sendInfo);
        if($addRes){
            echo "成功";
        }else{
            echo "失败";
        }
    }
}