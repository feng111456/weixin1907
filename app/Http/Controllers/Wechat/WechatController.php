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
        //     }
        // }else{
        // echo $signature; 
        // }
        //调用获取access_token方法
        $access_token =Wechat::getAccess_token();
        echo $access_token;
    }
}
