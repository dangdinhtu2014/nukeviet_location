<?php

/**
 * @Project NUKEVIET 4.x
 * @Author DANG DINH TU (dlinhvan@gmail.com)
 * @Copyright (C) 2014 webdep24.com All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 19 Jan 2015 11:09:15 GMT 
 */

if( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$allow_func = array( 'main', 'config', 'city', 'district', 'ward' );
 
define( 'ACTION_METHOD', $nv_Request->get_string( 'action', 'get,post', '' ) ); 	
	
define( 'TABLE_LOCALION_NAME', NV_PREFIXLANG . '_' . $module_data ); 
function getCity()
{
	global $nv_Cache,$module_name;

	$sql = 'SELECT city_id, title FROM ' . TABLE_LOCALION_NAME . '_city WHERE status=1 ORDER BY weight ASC';
	
	return $nv_Cache->db( $sql, 'city_id', $module_name );
}

function getDistrict()
{
	global $nv_Cache,$module_name;

	$sql = 'SELECT district_id, city_id, title FROM ' . TABLE_LOCALION_NAME . '_district WHERE status=1 ORDER BY weight ASC';

	return $nv_Cache->db( $sql, 'district_id', $module_name );
}

function getWard()
{
	global $nv_Cache,$module_name;

	$sql = 'SELECT ward_id, district_id, city_id, title FROM ' . TABLE_LOCALION_NAME . '_ward WHERE status=1 ORDER BY weight ASC';
	
	return $nv_Cache->db( $sql, 'ward_id', $module_name );
}


function fixWeightCity()
{
	global $db, $module_data;

	$sql = 'SELECT city_id FROM ' . TABLE_LOCALION_NAME . '_city ORDER BY weight ASC';
	$result = $db->query( $sql );
	$weight = 0;
	while( $row = $result->fetch() )
	{
		$weight++;
		$query = 'UPDATE ' . TABLE_LOCALION_NAME . '_city SET weight=' . $weight . ' WHERE city_id=' . $row['city_id'];
		$db->query( $query );
	}
}

function fixWeightDistrict()
{
	global $db, $module_data;
	$sql = 'SELECT city_id FROM ' . TABLE_LOCALION_NAME . '_city ORDER BY weight ASC';
	$result = $db->query( $sql );
	while( $row = $result->fetch() )
	{
	
		$sql = 'SELECT district_id FROM ' . TABLE_LOCALION_NAME . '_district WHERE city_id=' . $row['city_id'] . ' ORDER BY weight ASC';
		$resultd = $db->query( $sql );
		$weight = 0;
		while( $rowd = $resultd->fetch() )
		{
			$weight++;
			$query = 'UPDATE ' . TABLE_LOCALION_NAME . '_district SET weight=' . $weight . ' WHERE district_id=' . $rowd['district_id'];
			$db->query( $query );
		}
	
	
	
	
		$query = 'UPDATE ' . TABLE_LOCALION_NAME . '_city SET weight=' . $weight . ' WHERE city_id=' . $row['city_id'];
		$db->query( $query );
	}

}
 
function fixWeightWard()
{
	global $db, $module_data;
	$sql = 'SELECT district_id FROM ' . TABLE_LOCALION_NAME . '_district ORDER BY weight ASC';
	$result = $db->query( $sql );
	while( $row = $result->fetch() )
	{
		$sql = 'SELECT ward_id FROM ' . TABLE_LOCALION_NAME . '_ward WHERE district_id=' . $row['district_id'] . ' ORDER BY weight ASC';
		$resultw = $db->query( $sql );
		$weight = 0;
		while( $roww = $resultw->fetch() )
		{
			$weight++;
			$query = 'UPDATE ' . TABLE_LOCALION_NAME . '_ward SET weight=' . $weight . ' WHERE ward_id=' . $roww['ward_id'];
			$db->query( $query );
		}
		
	}
	
}

define( 'NV_IS_FILE_ADMIN', true );