<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>sign_in</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/sign_up.css" type="text/css">
</head>
<body>
<div class="sign_up">
    <img src="../../img/images/photo.jpg" />
    <h3>登录</h3>
    <form name="form" action="register_in.php" method="post">
        用户名：
        <br>
        <input type="text" name="username"placeholder="请输入用户名" id="username">
        <br>
        密码：
        <br>
        <input type="password" name="password" placeholder="请输入密码" id="password">
        <br>

            <input type="submit" value="登录" name="subl">

        <br>
        新用户？：
        <br>
        <a href="sign_up.php"><input type="button" value="注册"></a>
    </form>
</div>
<footer>
    <p>图片版权所有：19ss</p>
    <p>联系人：xx</p>
    &copy;
</footer>
</body>
</html>
