<?php

header("Content-Type: text/html;charset=utf-8");
//建立连接
$conn = mysqli_connect('localhost', 'chenmin', '316325chenmin');
if ($conn) {
    //数据库连接成功
    $select = mysqli_select_db($conn, "new_travel");  //选择数据库
    if (isset($_POST["subr"])) {

        $user = $_POST["username"];
        $pass = $_POST["password"];
        $re_pass = $_POST["re_password"];
        $eml = $_POST["email"];

        if ($user == "" || $pass == "") {
            //用户名or密码为空
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "用户名或密码不能为空！" . "\"" . ")" . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "sign_up.php" . "\"" . "</script>";
            exit;
        }
        if ($pass == $re_pass){
            //两次密码输入一致
            mysqli_set_charset($conn, 'utf8'); //设置编码

            //sql语句

            $sql_select = "SELECT * FROM traveluser WHERE  UserName = '$user'";
            //sql语句执行
            $result = mysqli_query($conn, $sql_select);
            //判断用户名是否已存在
            $num = mysqli_num_rows($result);

            if ($num) {
                //用户名已存在
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "用户名已存在！" . "\"" . ")" . ";" . "</script>";
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "sign_up.php" . "\"" . "</script>";
                exit;
            } else {
                //用户名不存在
                $idMath = 1;
                $sql_select2 = "select * from traveluser order by UID";
                $result2 = mysqli_query($conn, $sql_select2);
                while ( $num2 = mysqli_fetch_array($result2)){
                    if ($num2["UID"]>=$idMath){
                        $idMath = $num2["UID"];
                    }
                }
                $idMath+=1;

                $sql_insert = "insert into traveluser(UID,Email,UserName,Pass) values('$idMath','$eml','$user','$pass')";
                //插入数据
                $ret = mysqli_query($conn, $sql_insert);
                $row = mysqli_fetch_array($ret);
                //跳转注册成功页面
                header("Location:sign_in.php");
            }
        } else {
            //两次密码输入不一致
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "两次密码输入不一致！" . "\"" . ")" . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "sign_up.php" . "\"" . "</script>";
            exit;
        }
    }
    //关闭数据库
    mysqli_close($conn);
} else {
    //连接错误处理
    die('Could not connect:' . mysql_error());
}

