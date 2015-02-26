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
	PRIMARY KEY (city_id),
	UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district (
	district_id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	city_id mediumint(8) unsigned NOT NULL DEFAULT '0',
	title varchar(255) NOT NULL DEFAULT '',
	alias varchar(255) NOT NULL DEFAULT '',
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
	weight mediumint(8) unsigned NOT NULL DEFAULT '0',
	status tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (ward_id),
	UNIQUE KEY alias_district_id_city_id (alias)
) ENGINE=MyISAM";