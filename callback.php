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

if (isset($_GET['status']) && $_GET['code'] && $_GET['tenaccg'] && $_GET['serial'] && $_GET['trans_id'] && $_GET['telco'] && $_GET['callback_sign']) {

	// GỌI CONFIG
	include 'config.php';

	// TRẠNG THÁI
	$status = $_GET['status'];
	// MÃ THẺ NẠP
	$code = $_GET['code'];
	// SERIAL THẺ NẠP
	$serial = $_GET['serial'];
	// TRẠNG THÁI TIN NHẮN (THẤT BẠI - THÀNH CÔNG) TỪ THESIEURE
	$message = $_GET['message'];
	// MỆNH GIÁ GỐC THẺ NẠP
	$real_money = $_GET['value'];
	// MỆNH GIÁ THỰC NHẬN
	$geted_money = $_GET['amount'];
	// NHÀ MẠNG THẺ CÀO
	$nhamang = $_GET['telco'];
	// ĐƠN GIAO DỊCH BÊN THESIEURE
	$trans_id = $_GET['trans_id'];
	// KIỂM TRA CHỮ KÝ MD5
	$check_sign = md5($partner_key.$code.$serial);

	// KIỂM TRA CHỮ KÝ HỢP LỆ TRÁNH TRƯỜNG HỢP BUG
	if ($_GET['callback_sign'] == $check_sign) {

	// ĐÂY LÀ CHỖ LƯU LOG THẺ NẠP VÀO FILE ĐỂ KIỂM TRA KẾT QUẢ XEM SAO, NẾU BẠN DÙNG WEBSITE THẬT THÌ NHỚ BỎ ĐI NHÉ
	$open = "lognapthe.txt";
	file_put_contents($open,$_GET['status'].'|'.$_GET['message'].'|'.$_GET['value'].'|'.$_GET['code'].'|'.$_GET['serial'].'|'.$_GET['telco'].'|'$_GET['tenacc'].'|'.$_GET['trans_id'].PHP_EOL, FILE_APPEND);

	if ($status == 1) {
		// NẾU THẺ NẠP THÀNH CÔNG THÌ CODE TẠI ĐÂY
        UPDATE `accounts` SET `Credits` = `Credits` + $real_money WHERE `username` = '$username'
        echo "<div class='form'>
        <h3>Bạn Đã Nạp Tiền Thành Công</h3>
        <br/>Click để <a href='registration.php'>Quay Về Trang Chủ</a></div>";
	} elseif ($status == 2) {
		// NẾU THẺ NẠP THÀNH CÔNG NHƯNG SAI MỆNH GIÁ THÌ CODE TẠI ĐÂY
        UPDATE `accounts` SET `Credits` = `Credits` + $geted_money WHERE `username` = '$username'
        echo "<div class='form'>
        <h3>Bạn Đã Nạp Tiền Thành Công Nhưng Bạn Đã Nhập Sai Mệnh Giá Nên Sẽ Không Nhận Được Đầy Đủ Credits</h3>
        <br/>Click để <a href='registration.php'>Quay Về Trang Chủ</a></div>";
	} elseif ($status == 3) {
		// NẾU THẺ SAI KHÔNG DÙNG ĐƯỢC THÌ CODE TẠI ĐÂY
        <h3>Bạn Đã Nạp Tiền Không Thành Công Mã Thẻ Hoặc Seri sai</h3>
        <br/>Click để <a href='registration.php'>Quay Về Trang Chủ</a></div>";
	} elseif ($status == 4) {
		// NẾU NHÀ MẠNG BẢO TRÌ THÌ CODE TẠI ĐÂY
        <h3>Nhà Mạng Này Đang Bảo Trì Vui Lòng Thử Lại Sau !! Cảm Ơn</h3>
        <br/>Click để <a href='registration.php'>Quay Về Trang Chủ</a></div>";
	} elseif ($status == 99) {
		// NẾU THẺ CHỜ XỬ LÝ THÌ CODE TẠI ĐÂY
        <h3>Thẻ Đang Xử Lý Vui Lòng Chờ 3p-5p sau đó vào game nếu credits chưa Cộng vào tài khoản vui lòng liên hệ admin</h3>
        <br/>Click để <a href='registration.php'>Quay Về Trang Chủ</a></div>";
	} else {
		// NẾU THẺ TRẠNG THÁI KHÔNG XÁC ĐỊNH THÌ CODE TẠI ĐÂY
       <h3>Thẻ Không Thể Xác Định !! </h3>
        <br/>Click để <a href='registration.php'>Quay Về Trang Chủ</a></div>";
	}

	} else {
		
	}
} else {
	die('No per to access here');
}