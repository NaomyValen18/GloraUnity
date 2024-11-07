<?php
/**
* @author Ske Software https://facebook.com/skesoftware
* 
* @since 2021
* 
* @package API Đổi thẻ tự động bên Thesieure
* 
* @license FREE CODE
* 
* @see DÙNG ĐỂ TÍCH HỢP NẠP THẺ CHO SHOP GAME, SHOP DỊCH VỤ, WEB ĐỔI THẺ
*/

//NHẬP CONFIG VÀO ĐỂ XỬ LÝ
require_once 'config.php';
$return = '';
if (isset($_POST['submit-doithe'])) {
// RANDOM YÊU CẦU ID (KHÔNG THAY ĐỔI)
$request_id = rand(100000000,999999999);

// ĐẶT GIÁ TRỊ MẢNG THÀNH NULL TRÁNH LỖI
$POSTGET = array();

// YÊU CẦU ID
$POSTGET['request_id'] = $request_id;

// MÃ THẺ NẠP TỪ POST USER
$POSTGET['code'] = $_POST['code_card'];

// tên account
$username = stripslashes($_REQUEST['username']);
$username = mysqli_real_escape_string($con, $username);


// PARTENER ID (CONFIG TRONG PHẦN CONFIG.PHP)
$POSTGET['partner_id'] = $partner_id;

// SERI THẺ CÀO TỪ POST USER
$POSTGET['serial'] = $_POST['seri'];

// NHÀ MẠNG TỪ POST USER
$POSTGET['telco'] = $_POST['type'];

// LỆNH (MẶC ĐỊNH: NẠP THẺ)
$POSTGET['command'] = $command;

// SẮP XẾP MẢNG
ksort($POSTGET);

//CHỮ KÝ KHI ĐỔI THẺ
$sign = $partner_key;

//Đặt chữ ký MD5 vào item
foreach ($POSTGET as $item) {
  $sign .= $item;
}

//CHUYỂN CHỮ KÝ SANG ĐỊNH DẠNG MD5 (BẮT BUỘC)
$mysign = md5($sign);

// MỆNH GIÁ THẺ TỪ POST USER
$POSTGET['amount'] = $_POST['amount'];

// CHỮ KÝ MD5
$POSTGET['sign'] = $mysign;

// XUẤT RA URL ĐỂ GỬI LÊN TSR
$data = http_build_query($POSTGET);
// CHẠY CURL
$ch = curl_init();
// QUÁ TRÌNH GỬI LÊN TSR (ĐỪNG THAY ĐỔI)
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$SERVER_NAME = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
curl_setopt($ch, CURLOPT_REFERER, $SERVER_NAME);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
// ĐÓNG GỬI LÊN TSR
curl_close($ch);

// XUẤT RA JSON (STD CLASS)
$return = json_decode($result);

if (isset($return->status)) {

  if ($return->status == 99) {
// NẾU THẺ CHỜ XỬ LÝ THÌ CODE TẠI ĐÂY
  } elseif ($return->status == 4) {
// NẾU NHÀ MẠNG BẢO TRÌ THÌ CODE TẠI ĐÂY
  } else {
//Code thực hiện mặc định tại đây
  }
} else {
//Code thực hiện mặc định tại đây
}
}

// NẾU THẺ CHỜ DUYỆT THÌ TỰ ĐỘNG THESIEURE SẼ GỌI LẠI CHO BẠN, VUI LÒNG VÀO PHẦN CALLBACK.PHP ĐỂ THÊM SỰ KIỆN !
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Web Nạp Thẻ SAMP</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-4">
  <br>
  <br>
  <br>
  <h4 class="h4 fw-bold text-muted text-center">Web Nạp Thẻ Samp</h4>
  <p class="text-muted text-center">Vui Lòng Thoát Game Trước Khi Nạp Thẻ Và Nhận Đúng Tên Nhân Vật ( tên ic ) sai bằng mất thẻ</p>
  <div class="row">
    <div class="col-sm-6 mx-auto">
      <form method="post">
        <div class="form-group">
          <select name="type" class="form-select" required="">
            <option value="">Chọn loại thẻ</option>
            <option value="VIETTEL">Viettel</option>
            <option value="MOBIFONE">Mobifone</option>
            <option value="VINAPHONE">Vinaphone</option>
            <option value="GATE">Gate</option>
            <option value="ZING">Zing</option>
          </select>
        </div>
        <br>
        <div class="form-group">
          <select name="amount" class="form-select" required="">
            <option value="">Chọn mệnh giá</option>
            <option value="100">10.000</option>
            <option value="200">20.000</option>
            <option value="300">30.000</option>
            <option value="500">50.000</option>
            <option value="1000">100.000</option>
            <option value="2000">200.000</option>
            <option value="3000">300.000</option>
            <option value="5000">500.000</option>
          </select>
        </div>
        <br>
        <div class="form-group">
          <input type="number" class="form-control" name="seri" placeholder="Mã SERI" required="">
        </div>
        <br>
        <div class="form-group">
          <input type="number" class="form-control" name="code_card" placeholder="Mã thẻ" required="">
        </div>
        <br>
        <div class="form-group">
          <input type="text" class="form-control" name="username" placeholder="Tên ic" required />
        </div>
        <br>
        <div class="form-group">
          <center><button type="submit" name="submit-doithe" class="btn btn-outline-primary">XÁC NHẬN</button></center>
        </div>
      </form>
      <br>
    </div>
  </div>
</div>
</body>
</html>