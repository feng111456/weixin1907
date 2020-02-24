<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Tools\Wechat;

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
        $res = Wechat::addMenu();
        echo $res;die;
        $xml=file_get_contents('php://input');
        file_put_contents('check.txt',"\n".$xml,FILE_APPEND);
        $xmlObj = simplexml_load_string($xml);
        if($xmlObj->MsgType=='event'){
            //说明是事件 在判断什么是事件
            if($xmlObj->Event=='subscribe'){
                //关注事件
                $content = '你好欢迎关注张攀峰的公众号!主要功能是复读机！亲爱的用户在您使用公众号的期间！您发送什么消息我将回复您什么消息，当你发送：文章 ，我会给你发送一篇文章';
                $res = Wechat::restoreText($xmlObj,$content);
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
}