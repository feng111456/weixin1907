<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    public function index(){
        echo  $echostr =request()->echostr;die;
        $data = request();
        dump($data);
        echo $data->echostr;
    }
}
