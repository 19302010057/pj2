<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>sign_up</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/sign_up.css" type="text/css">
</head>
<body>
<div class="sign_up">
    <img src="../../img/images/photo.jpg"/>
    <h3>注册</h3>
    <form name="form" method="post" action="register_up.php">
        用户名：
        <br>
        <input type="text" name="username" required pattern="^[\u4E00-\u9FA5A-Za-z_.]+$" placeholder="限中文字母和下划线与点" title="请输入中文字母和下划线与点">
        <br>
        邮箱地址：
        <br>
        <input type="text" name="email" required pattern="^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$" title="请输入正确的邮箱格式" placeholder="请输入邮箱"/>
        <br>
        密码：
        <br>
        <input type="password" name="password" required pattern="[0-9A-Za-z_]{8,20}" title="请输入至少8位的密码" placeholder="限8位及以上的英文数字下划线">
        <br>
        确认密码：
        <br>
        <input type="password" name="re_password" placeholder="请与密码相同">
        <br>
        <a href="sign_in.php">
            <input type="submit" value="注册" name="subr">
        </a>
    </form>
</div>
<footer>
    <p>图片版权所有：19ss</p>
    <p>联系人：xx</p>
    &copy;
</footer>
</body>
</html>