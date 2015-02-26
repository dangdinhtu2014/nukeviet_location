<!-- BEGIN: main -->
<div id="content">
    <!-- BEGIN: error_warning -->
    <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle"></i> {error_warning}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <br>
    </div>
    <!-- END: error_warning -->
    <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title" style="float:left"><i class="fa fa-pencil"></i> {CAPTION}</h3>
			<div class="pull-right">
				<button type="submit" data-toggle="tooltip" class="btn btn-primary" title="{LANG.save}"><i class="fa fa-save"></i></button> 
				<a href="{CANCEL}" data-toggle="tooltip" class="btn btn-default" title="{LANG.cancel}"><i class="fa fa-reply"></i></a>
			</div>
			<div style="clear:both"></div>
		</div>
		<div class="panel-body">
			<form action="" method="post"  enctype="multipart/form-data" id="form-district" class="form-horizontal">
				<input type="hidden" name="district_id" value="{DATA.district_id}">
				<input type="hidden" name="save" value="1">
				
				<div class="form-group required">
					<label class="col-sm-4 control-label" for="input-title">{LANG.district_name}</label>
					<div class="col-sm-20">
						<input type="text" name="title" value="{DATA.title}" placeholder="{LANG.district_name}" id="input-title" class="form-control" />
						<!-- BEGIN: error_title --><div class="text-danger">{error_title}</div><!-- END: error_title -->
					</div>
				</div>				
			
				<div class="form-group required">
					<label class="col-sm-4 control-label" for="input-title">{LANG.city}</label>
					<div class="col-sm-20">
						<select class="form-control" name="city_id" style="width:100%">
							<option value="0" >{LANG.district_select_city}</option>
							<!-- BEGIN: city -->
							<option value="{CITY.key}" {CITY.selected}>{CITY.name}</option>
							<!-- END: city -->
						 </select>
						<!-- BEGIN: error_city --><div class="clear"></div><div class="text-danger">{error_city}</div><!-- END: error_city -->
					</div>
				</div>
				
			</form>
		</div>	
	</div>	
</div>	
<script type="text/javascript" src="{NV_BASE_SITEURL}modules/{MODULE_FILE}/js/footer.js"></script>
<!-- END: main -->