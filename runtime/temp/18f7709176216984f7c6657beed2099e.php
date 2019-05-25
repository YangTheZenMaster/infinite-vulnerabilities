<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"D:\phpstudy\PHPTutorial\WWW\cumtdininghall\public/../application/admin\view\index\login.html";i:1556847308;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>用户登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="author" content="DeathGhost"/>
    <link rel="stylesheet" type="text/css" href="/css/particleStyle.css"/>
    <link rel="stylesheet" type="text/css" href="/css/fishing.css"/>

    <script src="/js/jquery-1.11.1.min.js"></script>
    <script src="/js/verificationNumbers.js"></script>
    <script src="/js/Particleground.js"></script>
    <script>
        $(document).ready(function () {
            //粒子背景特效
            $('body').particleground({
                dotColor: 'white',
                lineColor: 'white'
            });
            //验证码
            createCode();
            //测试提交，对接程序删除即可
            $(".submit_btn").click(function () {
                location.href = "index.html"/*tpa=http://***index.html*/;
            });
        });
    </script>
</head>
<body class="loginBd">
<form action="check" method="post">
    <dl class="admin_login">
        <dt>
            <strong>后台管理系统</strong>
            <em>Management System</em>
        </dt>

        <dd class="user_icon">
            <input name="name" type="text" placeholder="账号" class="login_txtbx"/>
        </dd>
        <dd class="pwd_icon">
            <input name="password" type="password" placeholder="密码" class="login_txtbx"/>
            <span class="eyes">
  </span>

        </dd>
        <dd class="val_icon">
            <div class="checkcode">
                <input name="code" type="text" id="J_codetext" placeholder="输入验证码" maxlength="6" class="login_txtbx">
                <img src="<?php echo captcha_src(); ?>" alt="captcha" onclick="this.src=this.src+'?'" style="cursor: pointer"/>
            </div>
        </dd>
        <dd>
            <input type="submit" value="登 陆" class="submit_btn"/>
        </dd>
    </dl>
</form>

</body>
<script type="text/javascript">
    $('.eyes').click(function () {
        /*密码s是否可视*/
        $(this).find('img').fadeToggle();
        if ($(this).prev('input').attr('type') == 'text') {
            $(this).prev('input').attr('type', 'password');
        } else {
            $(this).prev('input').attr('type', 'text');
        }

    });
</script>
</html>
