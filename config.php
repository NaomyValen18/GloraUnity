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

// CÁCH DÒNG CHO DỄ CONFIG

// NẾU BẠN KHÔNG MUỐN IN LỖI RA MÀN HÌNH THÌ BỎ // BÊN DƯỚI ĐI
//error_reporting(0);

$command = 'charging'; // LỆNH NẠP THẺ, KHÔNG NÊN THAY ĐỔI

$url = 'https://thesieure.com/chargingws/v2'; // URL ĐỔI THẺ, KHÔNG THAY ĐỔI

$partner_id = ''; // PARTNER ID TSR CỦA BẠN

$partner_key = ''; // PARTNER KEY TSR CỦA BẠN

$con = mysqli_connect("localhost","root","","samp");