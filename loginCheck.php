<?php
session_start(); //啟用session 變數功能
require("dbconnect.php"); //匯入連結資料庫之共用程式碼
$userName = $_POST['id']; //取得從HTML表單傳來之POST參數
$passWord = $_POST['pwd'];

$userName = mysqli_real_escape_string($conn,$userName); //將特殊SQL字元編碼，以免被SQL Injection

$sql = "SELECT password, id FROM user WHERE loginID='$userName'"; //產生SQL指令
if ($result = mysqli_query($conn,$sql)) { //執行SQL查詢
    if ($row=mysqli_fetch_assoc($result)) { //取得第一筆資料
        if ($row['password'] == $passWord) { //比對密碼
            //keep the user ID in session as a mark of login
            $_SESSION['uID'] = $row['id']; //若正確－－＞將userID存在session變數中，作為登入成功之記號
            //provide a link to the message list UI
            //echo "login Success!!<br>"; //輸出登入成功之訊息
            //echo '<a href="index.php">Home</a> ';
            header('Location: view.php');
        } 
        else {
            //print error message
            echo "Invalid Username or Password - Please try again <br />";
            echo '<a href="loginForm.php">Login again</a> ';
        }
    } 
    else {
        //print error message
        echo "Invalid Username or Password - Please try again <br />";
        echo '<a href="loginForm.php">Login again</a> ';	
    }
} else{
    //print error message
    echo "DB connect error<br />";
    echo '<a href="loginForm.php">Login again</a> ';
}
?>
