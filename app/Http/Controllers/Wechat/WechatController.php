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
        $xml=file_get_contents('php://input');
        $xml = file_put_contents('check.txt',"\n".$xml,FILE_APPEND);
        $xmlObj = simplexml_load_string($xml);
        dd($xmlObj);
        if($xmlObj->MsgType=='event'){
            //说明是事件 在判断什么是事件
            if($xmlObj->Event=='subscribe]'){
                //关注事件
                $content = '你好欢迎关注张攀峰的公众号！';
                $res = Wechat::restoreText($xmlObj->FromUserName,$xmlObj->ToUserName,$content);
            }
        }

    }
}