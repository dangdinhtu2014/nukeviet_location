<?php

/**
 * @Project NUKEVIET 4.x
 * @Author DANG DINH TU (dlinhvan@gmail.com)
 * @Copyright (C) 2014 webdep24.com All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 19 Jan 2015 11:09:15 GMT 
 */
if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['ward'];

$getCity = getCity();
$getDistrict = getDistrict();
$getWard = getWard();

if( ACTION_METHOD == 'district' )
{
	$info = array();
	$city_id = $nv_Request->get_int( 'city_id', 'get', 0 );
 
	$sql = 'SELECT district_id, title FROM ' . TABLE_LOCALION_NAME . '_district WHERE city_id=' . $city_id;
	$result = $db->query( $sql );

	while( list( $district_id, $title ) = $result->fetch( 3 ) )
	{
		$info['district'][] = array(
			'city_id' => $city_id,
			'name' => nv_htmlspecialchars( $title ),
			'district_id' => $district_id );

	}

	header( 'Content-Type: application/json' );
	echo json_encode( $info );
	exit();
}

if( ACTION_METHOD == 'weight' )
{
	$info = array();

	$ward_id = $nv_Request->get_int( 'ward_id', 'get,post', 0 );

	$token = $nv_Request->get_title( 'token', 'post', '', 1 );

	$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );

	if( ! isset( $getWard[$ward_id] ) )
	{
		$info['error'] = $lang_module['ward_error_security'];
	}

	if( ! isset( $info['error'] ) )
	{
		if( $new_vid > 0 )
		{
			$sql = 'SELECT ward_id FROM ' . TABLE_LOCALION_NAME . '_ward WHERE ward_id != ' . $ward_id . ' ORDER BY weight ASC';

			$result = $db->query( $sql );

			$weight = 0;

			while( $row = $result->fetch() )
			{
				$weight++;

				if( $weight == $new_vid ) $weight++;

				$query = 'UPDATE ' . TABLE_LOCALION_NAME . '_ward SET weight=' . $weight . " WHERE ward_id=" . $row['ward_id'];
				$db->query( $query );
			}

			$query = 'UPDATE ' . TABLE_LOCALION_NAME . '_ward SET weight=' . $new_vid . ' WHERE ward_id=' . $ward_id;

			$db->query( $query );

			nv_del_moduleCache( $module_name );

			nv_insert_logs( NV_LANG_DATA, $module_name, 'Change Weight ward', "ward_id: " . $ward_id, $admin_info['userid'] );

			$info['success'] = $lang_module['ward_update_success'];
		}
	}

	echo json_encode( $info );
	exit();

}

if( ACTION_METHOD == 'delete' )
{
	$info = array();

	$ward_id = $nv_Request->get_int( 'ward_id', 'post', 0 );

	$token = $nv_Request->get_title( 'token', 'post', '', 1 );

	$listid = $nv_Request->get_string( 'listid', 'post', '' );

	if( $listid != '' and md5( $global_config['sitekey'] . session_id() ) == $token )
	{
		$del_array = array_map( 'intval', explode( ',', $listid ) );
	}
	elseif( $token == md5( $global_config['sitekey'] . session_id() . $ward_id ) )
	{
		$del_array = array( $ward_id );
	}

	if( ! empty( $del_array ) )
	{

		$_del_array = array();

		$a = 0;
		foreach( $del_array as $ward_id )
		{

			$db->query( 'DELETE FROM ' . TABLE_LOCALION_NAME . '_ward WHERE ward_id = ' . ( int )$ward_id );

			$info['id'][$a] = $ward_id;

			$_del_array[] = $ward_id;

			++$a;
		}

		$count = sizeof( $_del_array );

		if( $count )
		{
			fixWeightWard();

			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_del_ward', implode( ', ', $_del_array ), $admin_info['userid'] );

			nv_del_moduleCache( $module_name );

			$info['success'] = $lang_module['ward_delete_success'];
		}
		else
		{
			$info['error'] = $lang_module['ward_error_delete'];
		}

	}
	else
	{
		$info['error'] = $lang_module['ward_error_security'];
	}

	echo json_encode( $info );
	exit();

}

if( ACTION_METHOD == 'add' || ACTION_METHOD == 'edit' )
{
	$data = array(
		'ward_id' => 0,
		'district_id' => 0,
		'city_id' => 0,
		'title' => '',
		'alias' => '',
		'weight' => 0,
		'status' => 0,
		);
	$error = array();

	$data['district_id'] = $nv_Request->get_int( 'district_id', 'get,post', 0 );
	$data['city_id'] = $nv_Request->get_int( 'city_id', 'get,post', 0 );
	$data['ward_id'] = $nv_Request->get_int( 'ward_id', 'get,post', 0 );

	if( $data['ward_id'] > 0 )
	{
		$data = $db->query( 'SELECT * FROM ' . TABLE_LOCALION_NAME . '_ward WHERE ward_id=' . $data['ward_id'] )->fetch();

		$caption = $lang_module['ward_edit'];

	}
	else
	{
		$caption = $lang_module['ward_add'];
	}

	if( $nv_Request->get_int( 'save', 'post' ) == 1 )
	{

		$data['ward_id'] = $nv_Request->get_int( 'ward_id', 'post', 0 );
		$data['city_id'] = $nv_Request->get_int( 'city_id', 'post', 0 );
		$data['district_id'] = $nv_Request->get_int( 'district_id', 'post', 0 );
		$data['title'] = $nv_Request->get_title( 'title', 'post', '', 1 );

		if( empty( $data['title'] ) )
		{
			$error['title'] = $lang_module['ward_error_title'];
		}
		if( empty( $data['city_id'] ) )
		{
			$error['city'] = $lang_module['ward_error_city'];
		}
		if( empty( $data['district_id'] ) )
		{
			$error['district'] = $lang_module['ward_error_district'];
		}
		if( empty( $error ) )
		{
			$data['alias'] = change_alias( $data['title'] );

			if( $data['ward_id'] == 0 )
			{

				$weight = $db->query( 'SELECT max(weight) FROM ' . TABLE_LOCALION_NAME . '_ward' )->fetchColumn();
				$weight = intval( $weight ) + 1;

				$query = 'INSERT INTO ' . TABLE_LOCALION_NAME . '_ward VALUES(  
					NULL,  
					' . intval( $data['district_id'] ) . ', 
					' . intval( $data['city_id'] ) . ', 
					' . $db->quote( $data['title'] ) . ', 
					' . $db->quote( $data['alias'] ) . ', 
					' . intval( $weight ) . ', 1 )';

				$data['ward_id'] = ( int )$db->insert_id( $query );

				if( $data['ward_id'] > 0 )
				{

					$nv_Request->set_Session( $module_data . '_success', $lang_module['ward_insert_success'] );

					nv_insert_logs( NV_LANG_DATA, $module_name, 'Add A ward', 'ward_id: ' . $data['ward_id'], $admin_info['userid'] );

				}
				else
				{
					$error['warning'] = $lang_module['ward_error_save'];

				}

			}
			else
			{
				$sql = 'UPDATE ' . TABLE_LOCALION_NAME . '_ward SET 
					district_id = ' . intval( $data['district_id'] ) . ', 
					city_id = ' . intval( $data['city_id'] ) . ', 
					title = ' . $db->quote( $data['title'] ) . ', 
					alias = ' . $db->quote( $data['alias'] ) . ' 
					WHERE ward_id=' . $data['ward_id'];
 
				if( $db->query( $sql ) )
				{
					$nv_Request->set_Session( $module_data . '_success', $lang_module['ward_update_success'] );

					nv_insert_logs( NV_LANG_DATA, $module_name, 'Edit A ward', 'ward_id: ' . $data['ward_id'], $admin_info['userid'] );
				}
				else
				{
					$error['warning'] = $lang_module['ward_error_save'];

				}

			}

			if( empty( $error ) )
			{
				nv_del_moduleCache( $module_name );
				Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&city_id='. $data['city_id'] . '&district_id='. $data['district_id'] );
				die();
			}

		}

	}
	$xtpl = new XTemplate( "ward_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'MODULE_FILE', $module_file );
	$xtpl->assign( 'CAPTION', $caption );
	$xtpl->assign( 'CANCEL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
	$xtpl->assign( 'GET_DISTRICT', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
	
	$xtpl->assign( 'DATA', $data );

	foreach( $getCity as $key => $city )
	{
		$xtpl->assign( 'CITY', array(
			'key' => $key,
			'name' => $city['title'],
			'selected' => ( $key == $data['city_id'] ) ? 'selected="selected"' : '' ) );
		$xtpl->parse( 'main.city' );
	}

	foreach( $getDistrict as $key => $district )
	{
		$xtpl->assign( 'DISTRICT', array(
			'key' => $key,
			'name' => $district['title'],
			'selected' => ( $key == $data['district_id'] ) ? 'selected="selected"' : '' ) );
		$xtpl->parse( 'main.district' );
	}

	if( isset( $error['title'] ) )
	{
		$xtpl->assign( 'error_title', $error['title'] );
		$xtpl->parse( 'main.error_title' );
	}

	if( isset( $error['city'] ) )
	{
		$xtpl->assign( 'error_city', $error['city'] );
		$xtpl->parse( 'main.error_city' );
	}
	
	if( isset( $error['district'] ) )
	{
		$xtpl->assign( 'error_district', $error['district'] );
		$xtpl->parse( 'main.error_district' );
	}
	
	if( isset( $error['warning'] ) )
	{
		$xtpl->assign( 'error_warning', $error['warning'] );
		$xtpl->parse( 'main.error_warning' );
	}

	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';

	exit();
}

/* Hiện danh sách quốc gia*/

$per_page = 50;

$page = $nv_Request->get_int( 'page', 'get', 0 );

$district_id = $nv_Request->get_int( 'district_id', 'get', 0 );
$city_id = $nv_Request->get_int( 'city_id', 'get', 0 );

$sql = TABLE_LOCALION_NAME . '_ward WHERE 1';

if( $district_id > 0 )
{
	$sql .= ' AND district_id = ' . $district_id;
}

if( $city_id > 0 )
{
	$sql .= ' AND city_id = ' . $city_id;
}

$num_items = $db->query( 'SELECT COUNT(*) FROM ' . $sql )->fetchColumn();

$sort = $nv_Request->get_string( 'sort', 'get', '' );

$order = $nv_Request->get_string( 'order', 'get' ) == 'desc' ? 'desc' : 'asc';

$sort_data = array( 'title', 'weight' );

if( isset( $sort ) && in_array( $sort, $sort_data ) )
{

	$sql .= " ORDER BY " . $sort;
}
else
{
	$sql .= " ORDER BY weight";
}

if( isset( $order ) && ( $order == 'desc' ) )
{
	$sql .= " DESC";
}
else
{
	$sql .= " ASC";
}

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sort=' . $sort . '&amp;order=' . $order . '&amp;per_page=' . $per_page;
 
$result = $db->query( 'SELECT * FROM ' . $sql . ' LIMIT ' . $page . ',' . $per_page );

$array = array();

while( $rows = $result->fetch() )
{
	$array[] = $rows;
}

$xtpl = new XTemplate( "ward.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
$xtpl->assign( 'MODULE_FILE', $module_file );
$xtpl->assign( 'TOKEN', md5( $global_config['sitekey'] . session_id() ) );
$xtpl->assign( 'ADD_NEW', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;action=add&amp;district_id=' . $district_id . '&amp;city_id=' . $city_id );

if( $nv_Request->get_string( $module_data . '_success', 'session' ) )
{
	$xtpl->assign( 'SUCCESS', $nv_Request->get_string( $module_data . '_success', 'session' ) );

	$xtpl->parse( 'main.success' );

	$nv_Request->unset_request( $module_data . '_success', 'session' );

}

if( ! empty( $array ) )
{
	$a = 1;
	foreach( $array as $item )
	{

		$item['class'] = ( $a % 2 ) ? 'class="second"' : '';

		$item['token'] = md5( $global_config['sitekey'] . session_id() . $item['ward_id'] );

		$item['city'] = isset( $getCity[$item['city_id']] ) ? $getCity[$item['city_id']]['title'] : '';
		
		$item['district'] = isset( $getDistrict[$item['district_id']] ) ? $getDistrict[$item['district_id']]['title'] : '';

		$item['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=ward&action=edit&token=" . $item['token'] . "&ward_id=" . $item['ward_id'];

		$item['district_link'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=ward&district_id=" . $item['district_id'];

		$item['city_link'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=district&city_id=" . $item['city_id'];

 
		$xtpl->assign( 'LOOP', $item );

		for( $i = 1; $i <= $num_items; ++$i )
		{
			$xtpl->assign( 'WEIGHT', array( 'w' => $i, 'selected' => ( $i == $item['weight'] ) ? ' selected="selected"' : '' ) );

			$xtpl->parse( 'main.loop.weight' );
		}

		$xtpl->parse( 'main.loop' );
		++$a;
	}

}

$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );

if( ! empty( $generate_page ) )
{

	$xtpl->assign( 'GENERATE_PAGE', $generate_page );
	$xtpl->parse( 'main.generate_page' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
