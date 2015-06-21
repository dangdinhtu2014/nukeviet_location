<!-- BEGIN: main -->
<div id="content"> 
	<!-- BEGIN: success -->
		<div class="alert alert-success">
			<i class="fa fa-check-circle"></i> {SUCCESS}
		</div>
	<!-- END: success -->

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title" style="float:left"><i class="fa fa-list"></i> {LANG.ward_list}</h3> 
			 <div class="pull-right">
				<a href="{ADD_NEW}" data-toggle="tooltip" data-placement="top" title="{LANG.add}" class="btn btn-success"><i class="fa fa-plus"></i></a>
				<button type="button" data-toggle="tooltip" data-placement="top" title="{LANG.delete}" class="btn btn-danger" id="button-delete">
					<i class="fa fa-trash-o"></i>
				</button>
			</div>
			<div style="clear:both"></div>
		</div>
		<div class="panel-body">
			<form class="form-inline" name="block_list" action="">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<td class="text-center" width="10">
								<input name="check_all[]" type="checkbox" value="yes" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" >
							</td>
							<!-- BEGIN: weightshowlang -->
								<td class="text-center" width="80">{LANG.weight}</td>
							<!-- END: weightshowlang -->
							<td align="left">{LANG.ward_name}</td>
							<td align="left">{LANG.district_name}</td>
							<td align="left">{LANG.city_name}</td>
							<td class="text-center"width="120">{LANG.action}</td>
						</tr>
					</thead>
					
					<tbody>
					<!-- BEGIN: loop -->
						<tr class="text-center" id="group_{LOOP.ward_id}">
							<td class="text-center">
								<input type="checkbox" name="selected[]" value="{LOOP.ward_id}" >
							</td>
							<!-- BEGIN: weightshow -->
								<td class="text-center">
									<select id="change_weight_{LOOP.ward_id}" onchange="nv_change_ward( '{LOOP.ward_id}','weight','{LOOP.district_id}','{LOOP.city_id}');" class="form-control">
										<!-- BEGIN: weight -->
										<option value="{WEIGHT.w}"{WEIGHT.selected}>{WEIGHT.w}</option>
										<!-- END: weight -->
									</select>
								</td>
							<!-- END: weightshow -->
							<td align="left">{LOOP.title}</td>
							<td align="left"><a href="{LOOP.district_link}">{LOOP.district}</a></td>
							<td align="left"> <a href="{LOOP.city_link}">{LOOP.city}</a> </td>
							<td class="text-right">
								<a href="{LOOP.edit}" data-toggle="tooltip" title="{LANG.edit}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
								<a href="javascript:void(0);" onclick="delete_ward('{LOOP.ward_id}', '{LOOP.token}')" data-toggle="tooltip" title="{LANG.delete}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
							</td>
						</tr>
					<!-- END: loop -->
					<tbody>
					
					 
				</table>
			</form>
			<!-- BEGIN: generate_page -->
			<div class="row">
				<div class="col-sm-24 text-left">
				<div style="clear:both"></div>
				{GENERATE_PAGE}	
				</div>
				 
			</div>
			<!-- END: generate_page -->
		</div>
	</div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/js/footer.js"></script>
<script type="text/javascript">
function nv_change_ward(ward_id, mod, district_id, city_id ) {
    var nv_timer = nv_settimeout_disable('change_' + mod + '_' + ward_id, 5000);
    var new_vid = $('#change_' + mod + '_' + ward_id).val();
 
	$.ajax({
		url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ward&action='+ mod +'&nocache=' + new Date().getTime(),
		type: 'post',
		dataType: 'json',
		data: 'ward_id=' + ward_id + '&new_vid=' + new_vid + '&district_id=' + district_id + '&city_id' + city_id,
		success: function(json) 
		{	 
			$('.alert').remove(); 
			
			if ( json['error'] ) 
			{
				alert(json['error']);
				clearTimeout(nv_timer);
			}
				
			if (json['success']) 
			{
				 window.location.href = window.location.href; 
			}		
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
 
    return;
}
function delete_ward(ward_id, token) {
	if( confirm( '{LANG.confirm}' )) 
	{
		$.ajax({
			url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ward&action=delete&nocache=' + new Date().getTime(),
			type: 'post',
			dataType: 'json',
			data: 'ward_id=' + ward_id + '&token=' + token,
			success: function(json) {
				
				$('.alert').remove(); 
				
				if (json['error']) {
					$('#content').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				}
				
				if (json['success']) {
					$('#content').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
					 $.each(json['id'], function(i, id) {
						$('#group_' + id ).remove();
					});
				}		
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
$('#button-delete').on('click', function() {
	if(confirm('{LANG.confirm}')) 
	{
		var listid = [];
		$("input[name=\"selected[]\"]:checked").each(function() {
			listid.push($(this).val());
		});
		if (listid.length < 1) {
			alert("{LANG.select_one}");
			return false;
		}
	 
		$.ajax({
			url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ward&action=delete&nocache=' + new Date().getTime(),
			type: 'post',
			dataType: 'json',
			data: 'listid=' + listid + '&token={TOKEN}',
			success: function(json) {
			
				$('.alert').remove(); 
				 
				if (json['error']) {
					$('#content').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				}
 
				if (json['success']) {
					$('#content').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
					 $.each(json['id'], function(i, id) {
						$('#group_' + id ).remove();
					});
				}		
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}	
});
</script>
<!-- END: main -->