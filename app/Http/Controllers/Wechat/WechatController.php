<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    public function index(){
        echo $_GET['echostr'];die;
        $signature  = $_GET['signature'];
        $timestamp  = $_GET['timestamp'];
        $nonce      = $_GET['nonce'];
        $token = '123456abc';
        $tmparrat = array($token,$timestamp,$nonce);
        sotr($tmparrat,SORT_STRING);
        $impstr = implode($tmparrat);
        $impstr = sha1($impstr);
        if($impstr == $signature){
            echo $_GET['echostr'];
        }
    }
}
