<?php
function Validating_username($name)
{
    $check = explode("_", $name);
    if (!preg_match('/^[a-zA-Z]+$/', $check[0])) {
        $result['error'] = 1;
        $result['message'] = 'Lỗi ký tự "' . $check[0] . '" Không hợp lệ.';
        return $result;
    } else {
        if (!preg_match('/^[a-zA-Z]+$/', $check[1])) {
            $result['error'] = 1;
            $result['message'] = 'Lỗi ký tự "' . $check[1] . '" Không hợp lệ.';
            return $result;
        } else if (isset($check[2])) {
            if (!preg_match('/^[a-zA-Z]+$/', $check[2])) {
                $result['error'] = 1;
                $result['message'] = 'Lỗi ký tự "' . $check[2] . '" Không hợp lệ.';
                return $result;
            }
        }
    }
    return 'success';
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Trang Đăng Ký Samp</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <?php
    require('db.php');
    if (isset($_REQUEST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $UpdateDate = date("Y-m-d H:i:s");

        if (Validating_username($username) != 'success') {
            echo "<div class='form'>
                <h3> tên ko hợp lệ!</h3>
                <br/>Click để <a href='registration.php'>đăng ký</a></div>";
        } else {
            $query = "SELECT * FROM `accounts` WHERE username='$username' or email='$email'";
            $result = mysqli_query($con, $query);
            $rows = mysqli_num_rows($result);
            if ($rows != 0) {
                echo "<div class='form'>
                <h3>Username hoặc email đã tồn tại!</h3>
                <br/>Click để <a href='registration.php'>đăng ký</a></div>";
            } else {
                $query = "INSERT INTO `accounts` (username, password, email, UpdateDate)
                VALUES('$username', '$password', '$email', '$UpdateDate' )";
                $result = mysqli_query($con, $query);
                if ($result) {
                    echo "<div class='form'>
                    <h3>Đăng ký thành công!</h3>
                    <br/>Click để <a href='index.html'>Quay Về Trang Chủ</a></div>";
                } else {
                    echo "<div class='form'>
                    <h3>Đăng ký thất bại!</h3>
                    <br/>Click để <a href='registration.php'>đăng ký</a></div>";
                }
            }
        }
    } else {
    ?>
        <div class="form">
            <h1>Đăng ký</h1>
            <form name="registration" action="" method="post">
                <input type="text" name="username" placeholder="Tên đăng nhập" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Mật khẩu" required />
                <input type="submit" name="submit" value="Đăng ký" />
            </form>
        </div>
    <?php } ?>
</body>

</html>