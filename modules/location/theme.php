<?php

/**
 * @Project NUKEVIET 4.x
 * @Author DANG DINH TU (dlinhvan@gmail.com)
 * @Copyright (C) 2014 webdep24.com All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 19 Jan 2015 11:09:15 GMT 
 */

if ( ! defined( 'NV_IS_MOD_LOCATION' ) ) die( 'Stop!' );

function nv_theme_samples_main ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info;
    $xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function nv_theme_samples_detail ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info;
    $xtpl = new XTemplate( "detail.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}