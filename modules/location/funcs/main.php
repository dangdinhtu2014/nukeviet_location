<?php

/**
 * @Project NUKEVIET 4.x
 * @Author DANG DINH TU (dlinhvan@gmail.com)
 * @Copyright (C) 2014 webdep24.com All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 19 Jan 2015 11:09:15 GMT 
 */

if ( ! defined( 'NV_IS_MOD_LOCATION' ) ) die( 'Stop!!' );
$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$array_data = "";

$contents = nv_theme_samples_main( $array_data );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';