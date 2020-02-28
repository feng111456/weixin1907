<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
    <title>Document</title>
</head>
<body>
   <input type="hidden" id="sign" value="{{$signature}}">
   {{$signature}}
</body>
</html>

<script>
    var sign= document.getElementById("sign").value;
    alert(sign);
    return 111;
    wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: 'wxff7f4f8c33328445', // 必填，公众号的唯一标识
        timestamp: {{time()}}, // 必填，生成签名的时间戳
        nonceStr: '123456abc', // 必填，生成签名的随机串
        signature:sign,// 必填，签名
        jsApiList: [
            'checkJsApi',
            'updateAppMessageShareData',
            'updateTimelineShareData'
        ] // 必填，需要使用的JS接口列表
    });
    wx.ready(function(){
        wx.updateAppMessageShareData({ 
            title: '分享', // 分享标题
            desc: '分享给朋友', // 分享描述
            link: 'http://weixin07.zhangpanfeng.top/wechat/test', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '', // 分享图标
            success:function(){
                alert('OK');
            }
        })
    });
</script>