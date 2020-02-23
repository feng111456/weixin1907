<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Curl
{
    /**发送get请求 */
    public static function CurlGet($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式原生
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//关闭https验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
        $output = curl_exec($curl); //执行curl
        curl_close($curl); //关闭curl请求
        return $output; //返回结果
    }
    /**发送post请求 */
    public static function CurlPost($url,$data){      
        $curl = curl_init();    //初始化  
        curl_setopt($curl, CURLOPT_URL, $url);//设置抓取的url
        curl_setopt($curl, CURLOPT_HEADER, 1);        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //设置获取的信息以文件流的形式返回，而不是直接输出。     
        curl_setopt($curl, CURLOPT_POST, 1);//设置post方式提交
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($curl);//执行curl
        curl_close($curl);//关闭URL请求
        return $output;  //返回结果
    }
}
