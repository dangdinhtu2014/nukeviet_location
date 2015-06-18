<?php

/**
 * @Project NUKEVIET 4.x
 * @Author DANG DINH TU (dlinhvan@gmail.com)
 * @Copyright (C) 2014 webdep24.com All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 19 Jan 2015 11:09:15 GMT 
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_city";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_ward";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_city (
	city_id mediumint(8) NOT NULL AUTO_INCREMENT,
	title varchar(255) NOT NULL DEFAULT '',
	alias varchar(255) NOT NULL DEFAULT '',
	weight mediumint(8) unsigned NOT NULL DEFAULT '0',
	status tinyint(1) unsigned NOT NULL DEFAULT '0',
	type varchar(30) NOT NULL,
	PRIMARY KEY (city_id),
	UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district (
	district_id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	city_id mediumint(8) unsigned NOT NULL DEFAULT '0',
	title varchar(255) NOT NULL DEFAULT '',
	alias varchar(255) NOT NULL DEFAULT '',
	type varchar(30) NOT NULL,
	location varchar(30) NOT NULL,
	weight mediumint(8) unsigned NOT NULL DEFAULT '0',
	status tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (district_id),
	UNIQUE KEY alias_city_id (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_ward (
	ward_id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	district_id mediumint(8) unsigned NOT NULL DEFAULT '0',
	city_id mediumint(8) unsigned NOT NULL DEFAULT '0',
	title varchar(255) NOT NULL DEFAULT '',
	alias varchar(255) NOT NULL DEFAULT '',
	location varchar(30) NOT NULL,
	weight mediumint(8) unsigned NOT NULL DEFAULT '0',
	status tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (ward_id),
	UNIQUE KEY alias_district_id_city_id (alias)
) ENGINE=MyISAM";




$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_city (city_id, title, alias, weight, status, type) VALUES
(1, 'Hà Nội', 'Ha-Noi', 1, 0, 'Thành Phố'),
(2, 'Hà Giang', 'Ha-Giang', 2, 0, 'Tỉnh'),
(4, 'Cao Bằng', 'Cao-Bang', 3, 0, 'Tỉnh'),
(6, 'Bắc Kạn', 'Bac-Kan', 4, 0, 'Tỉnh'),
(8, 'Tuyên Quang', 'Tuyen-Quang', 5, 0, 'Tỉnh'),
(10, 'Lào Cai', 'Lao-Cai', 6, 0, 'Tỉnh'),
(11, 'Điện Biên', 'Dien-Bien', 7, 0, 'Tỉnh'),
(12, 'Lai Châu', 'Lai-Chau', 8, 0, 'Tỉnh'),
(14, 'Sơn La', 'Son-La', 9, 0, 'Tỉnh'),
(15, 'Yên Bái', 'Yen-Bai', 10, 0, 'Tỉnh'),
(17, 'Hòa Bình', 'Hoa-Binh', 11, 0, 'Tỉnh'),
(19, 'Thái Nguyên', 'Thai-Nguyen', 12, 0, 'Tỉnh'),
(20, 'Lạng Sơn', 'Lang-Son', 13, 0, 'Tỉnh'),
(22, 'Quảng Ninh', 'Quang-Ninh', 14, 0, 'Tỉnh'),
(24, 'Bắc Giang', 'Bac-Giang', 15, 0, 'Tỉnh'),
(25, 'Phú Thọ', 'Phu-Tho', 16, 0, 'Tỉnh'),
(26, 'Vĩnh Phúc', 'Vinh-Phuc', 17, 0, 'Tỉnh'),
(27, 'Bắc Ninh', 'Bac-Ninh', 18, 0, 'Tỉnh'),
(30, 'Hải Dương', 'Hai-Duong', 19, 0, 'Tỉnh'),
(31, 'Hải Phòng', 'Hai-Phong', 20, 0, 'Thành Phố'),
(33, 'Hưng Yên', 'Hung-Yen', 21, 0, 'Tỉnh'),
(34, 'Thái Bình', 'Thai-Binh', 22, 0, 'Tỉnh'),
(35, 'Hà Nam', 'Ha-Nam', 23, 0, 'Tỉnh'),
(36, 'Nam Định', 'Nam-Dinh', 24, 0, 'Tỉnh'),
(37, 'Ninh Bình', 'Ninh-Binh', 25, 0, 'Tỉnh'),
(38, 'Thanh Hóa', 'Thanh-Hoa', 26, 0, 'Tỉnh'),
(40, 'Nghệ An', 'Nghe-An', 27, 0, 'Tỉnh'),
(42, 'Hà Tĩnh', 'Ha-Tinh', 28, 0, 'Tỉnh'),
(44, 'Quảng Bình', 'Quang-Binh', 29, 0, 'Tỉnh'),
(45, 'Quảng Trị', 'Quan-Tri', 30, 0, 'Tỉnh'),
(46, 'Thừa Thiên Huế', 'Thu-Thien-Hue', 31, 0, 'Tỉnh'),
(48, 'Đà Nẵng', 'Da-Nang', 32, 0, 'Thành Phố'),
(49, 'Quảng Nam', 'Quang-Nam', 33, 0, 'Tỉnh'),
(51, 'Quảng Ngãi', 'Quang-Ngai', 34, 0, 'Tỉnh'),
(52, 'Bình Định', 'Binh-Dinh', 35, 0, 'Tỉnh'),
(54, 'Phú Yên', 'Phu-Yen', 36, 0, 'Tỉnh'),
(56, 'Khánh Hòa', 'Khanh-Hoa', 37, 0, 'Tỉnh'),
(58, 'Ninh Thuận', 'Ninh-Thuan', 38, 0, 'Tỉnh'),
(60, 'Bình Thuận', 'Binh-Thuan', 39, 0, 'Tỉnh'),
(62, 'Kon Tum', 'Kon-Tum', 40, 0, 'Tỉnh'),
(64, 'Gia Lai', 'Gia-Lai', 41, 0, 'Tỉnh'),
(66, 'Đắk Lắk', 'Dak-Lak', 42, 0, 'Tỉnh'),
(67, 'Đắk Nông', 'Dak-Nong', 43, 0, 'Tỉnh'),
(68, 'Lâm Đồng', 'Lam-Dong', 44, 0, 'Tỉnh'),
(70, 'Bình Phước', 'Binh-Phuoc', 45, 0, 'Tỉnh'),
(72, 'Tây Ninh', 'Tay-Ninh', 46, 0, 'Tỉnh'),
(74, 'Bình Dương', 'Binh-Duong', 47, 0, 'Tỉnh'),
(75, 'Đồng Nai', 'Dong-Nai', 48, 0, 'Tỉnh'),
(77, 'Bà Rịa - Vũng Tàu', 'Ba-Ria-Vung-Tau', 49, 0, 'Tỉnh'),
(79, 'Hồ Chí Minh', 'Ho-Chi-Minh', 50, 0, 'Thành Phố'),
(80, 'Long An', 'Long-An', 51, 0, 'Tỉnh'),
(82, 'Tiền Giang', 'Tien-Giang', 52, 0, 'Tỉnh'),
(83, 'Bến Tre', 'Ben-Tre', 53, 0, 'Tỉnh'),
(84, 'Trà Vinh', 'Tra-Vinh', 54, 0, 'Tỉnh'),
(86, 'Vĩnh Long', 'Vinh-Long', 55, 0, 'Tỉnh'),
(87, 'Đồng Tháp', 'Dong-Thap', 56, 0, 'Tỉnh'),
(89, 'An Giang', 'An-Giang', 57, 0, 'Tỉnh'),
(91, 'Kiên Giang', 'Kien-Giang', 58, 0, 'Tỉnh'),
(92, 'Cần Thơ', 'Can-Tho', 59, 0, 'Thành Phố'),
(93, 'Hậu Giang', 'Hau-Giang', 60, 0, 'Tỉnh'),
(94, 'Sóc Trăng', 'Soc-Trang', 61, 0, 'Tỉnh'),
(95, 'Bạc Liêu', 'Bac-Lieu', 62, 0, 'Tỉnh'),
(96, 'Cà Mau', 'Ca-Mau', 63, 0, 'Tỉnh')";