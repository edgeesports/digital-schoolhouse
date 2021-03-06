<?php

// Data functions (insert, update, delete, form) for table schools

// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

function schools_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('schools');
	if(!$arrPerm[1]){
		return false;
	}

	$data['school_name'] = makeSafe($_REQUEST['school_name']);
		if($data['school_name'] == empty_lookup_value){ $data['school_name'] = ''; }
	$data['school_address'] = br2nl(makeSafe($_REQUEST['school_address']));
	$data['school_postcode'] = makeSafe($_REQUEST['school_postcode']);
		if($data['school_postcode'] == empty_lookup_value){ $data['school_postcode'] = ''; }
	$data['contact_name'] = makeSafe($_REQUEST['contact_name']);
		if($data['contact_name'] == empty_lookup_value){ $data['contact_name'] = ''; }
	$data['contact_email'] = makeSafe($_REQUEST['contact_email']);
		if($data['contact_email'] == empty_lookup_value){ $data['contact_email'] = ''; }
	$data['contact_phone'] = makeSafe($_REQUEST['contact_phone']);
		if($data['contact_phone'] == empty_lookup_value){ $data['contact_phone'] = ''; }
	$data['esports_coach'] = makeSafe($_REQUEST['esports_coach']);
		if($data['esports_coach'] == empty_lookup_value){ $data['esports_coach'] = ''; }
	$data['created_by'] = parseCode('<%%creatorUsername%%>', true);
	$data['school_crest'] = PrepareUploadedFile('school_crest', 102400,'jpg|jpeg|gif|png', false, '');
	if($data['school_crest']) createThumbnail($data['school_crest'], getThumbnailSpecs('schools', 'school_crest', 'tv'));
	if($data['school_crest']) createThumbnail($data['school_crest'], getThumbnailSpecs('schools', 'school_crest', 'dv'));
	if($data['school_name']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'School Name': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['school_address']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Address': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['school_postcode']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Postcode': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	/* for empty upload fields, when saving a copy of an existing record, copy the original upload field */
	if($_REQUEST['SelectedID']){
		$res = sql("select * from schools where id='" . makeSafe($_REQUEST['SelectedID']) . "'", $eo);
		if($row = db_fetch_assoc($res)){
			if(!$data['school_crest']) $data['school_crest'] = makeSafe($row['school_crest']);
		}
	}

	// hook: schools_before_insert
	if(function_exists('schools_before_insert')){
		$args=array();
		if(!schools_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `schools` set       ' . ($data['school_crest'] != '' ? "`school_crest`='{$data['school_crest']}'" : '`school_crest`=NULL') . ', `school_name`=' . (($data['school_name'] !== '' && $data['school_name'] !== NULL) ? "'{$data['school_name']}'" : 'NULL') . ', `school_address`=' . (($data['school_address'] !== '' && $data['school_address'] !== NULL) ? "'{$data['school_address']}'" : 'NULL') . ', `school_postcode`=' . (($data['school_postcode'] !== '' && $data['school_postcode'] !== NULL) ? "'{$data['school_postcode']}'" : 'NULL') . ', `contact_name`=' . (($data['contact_name'] !== '' && $data['contact_name'] !== NULL) ? "'{$data['contact_name']}'" : 'NULL') . ', `contact_email`=' . (($data['contact_email'] !== '' && $data['contact_email'] !== NULL) ? "'{$data['contact_email']}'" : 'NULL') . ', `contact_phone`=' . (($data['contact_phone'] !== '' && $data['contact_phone'] !== NULL) ? "'{$data['contact_phone']}'" : 'NULL') . ', `esports_coach`=' . (($data['esports_coach'] !== '' && $data['esports_coach'] !== NULL) ? "'{$data['esports_coach']}'" : 'NULL') . ', `created_by`=' . "'{$data['created_by']}'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"schools_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: schools_after_insert
	if(function_exists('schools_after_insert')){
		$res = sql("select * from `schools` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!schools_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('schools', $recID, getLoggedMemberID());

	return $recID;
}

function schools_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('schools');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='schools' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='schools' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: schools_before_delete
	if(function_exists('schools_before_delete')){
		$args=array();
		if(!schools_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	// child table: students
	$res = sql("select `id` from `schools` where `id`='$selected_id'", $eo);
	$id = db_fetch_row($res);
	$rires = sql("select count(1) from `students` where `school`='".addslashes($id[0])."'", $eo);
	$rirow = db_fetch_row($rires);
	if($rirow[0] && !$AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["couldn't delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "students", $RetMsg);
		return $RetMsg;
	}elseif($rirow[0] && $AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["confirm delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "students", $RetMsg);
		$RetMsg = str_replace("<Delete>", "<input type=\"button\" class=\"button\" value=\"".$Translation['yes']."\" onClick=\"window.location='schools_view.php?SelectedID=".urlencode($selected_id)."&delete_x=1&confirmed=1';\">", $RetMsg);
		$RetMsg = str_replace("<Cancel>", "<input type=\"button\" class=\"button\" value=\"".$Translation['no']."\" onClick=\"window.location='schools_view.php?SelectedID=".urlencode($selected_id)."';\">", $RetMsg);
		return $RetMsg;
	}

	// child table: teams
	$res = sql("select `id` from `schools` where `id`='$selected_id'", $eo);
	$id = db_fetch_row($res);
	$rires = sql("select count(1) from `teams` where `school`='".addslashes($id[0])."'", $eo);
	$rirow = db_fetch_row($rires);
	if($rirow[0] && !$AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["couldn't delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "teams", $RetMsg);
		return $RetMsg;
	}elseif($rirow[0] && $AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["confirm delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "teams", $RetMsg);
		$RetMsg = str_replace("<Delete>", "<input type=\"button\" class=\"button\" value=\"".$Translation['yes']."\" onClick=\"window.location='schools_view.php?SelectedID=".urlencode($selected_id)."&delete_x=1&confirmed=1';\">", $RetMsg);
		$RetMsg = str_replace("<Cancel>", "<input type=\"button\" class=\"button\" value=\"".$Translation['no']."\" onClick=\"window.location='schools_view.php?SelectedID=".urlencode($selected_id)."';\">", $RetMsg);
		return $RetMsg;
	}

	sql("delete from `schools` where `id`='$selected_id'", $eo);

	// hook: schools_after_delete
	if(function_exists('schools_after_delete')){
		$args=array();
		schools_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='schools' and pkValue='$selected_id'", $eo);
}

function schools_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('schools');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='schools' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='schools' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['school_name'] = makeSafe($_REQUEST['school_name']);
		if($data['school_name'] == empty_lookup_value){ $data['school_name'] = ''; }
	if($data['school_name']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'School Name': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['school_address'] = br2nl(makeSafe($_REQUEST['school_address']));
	if($data['school_address']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Address': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['school_postcode'] = makeSafe($_REQUEST['school_postcode']);
		if($data['school_postcode'] == empty_lookup_value){ $data['school_postcode'] = ''; }
	if($data['school_postcode']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Postcode': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['contact_name'] = makeSafe($_REQUEST['contact_name']);
		if($data['contact_name'] == empty_lookup_value){ $data['contact_name'] = ''; }
	$data['contact_email'] = makeSafe($_REQUEST['contact_email']);
		if($data['contact_email'] == empty_lookup_value){ $data['contact_email'] = ''; }
	$data['contact_phone'] = makeSafe($_REQUEST['contact_phone']);
		if($data['contact_phone'] == empty_lookup_value){ $data['contact_phone'] = ''; }
	$data['esports_coach'] = makeSafe($_REQUEST['esports_coach']);
		if($data['esports_coach'] == empty_lookup_value){ $data['esports_coach'] = ''; }
	$data['edited_by'] = parseCode('<%%editorUsername%%>', false);
	$data['selectedID']=makeSafe($selected_id);
	if($_REQUEST['school_crest_remove'] == 1){
		$data['school_crest'] = '';
	}else{
		$data['school_crest'] = PrepareUploadedFile('school_crest', 102400, 'jpg|jpeg|gif|png', false, "");
		if($data['school_crest']) createThumbnail($data['school_crest'], getThumbnailSpecs('schools', 'school_crest', 'tv'));
		if($data['school_crest']) createThumbnail($data['school_crest'], getThumbnailSpecs('schools', 'school_crest', 'dv'));
	}

	// hook: schools_before_update
	if(function_exists('schools_before_update')){
		$args=array();
		if(!schools_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `schools` set       ' . ($data['school_crest']!='' ? "`school_crest`='{$data['school_crest']}'" : ($_REQUEST['school_crest_remove'] != 1 ? '`school_crest`=`school_crest`' : '`school_crest`=NULL')) . ', `school_name`=' . (($data['school_name'] !== '' && $data['school_name'] !== NULL) ? "'{$data['school_name']}'" : 'NULL') . ', `school_address`=' . (($data['school_address'] !== '' && $data['school_address'] !== NULL) ? "'{$data['school_address']}'" : 'NULL') . ', `school_postcode`=' . (($data['school_postcode'] !== '' && $data['school_postcode'] !== NULL) ? "'{$data['school_postcode']}'" : 'NULL') . ', `contact_name`=' . (($data['contact_name'] !== '' && $data['contact_name'] !== NULL) ? "'{$data['contact_name']}'" : 'NULL') . ', `contact_email`=' . (($data['contact_email'] !== '' && $data['contact_email'] !== NULL) ? "'{$data['contact_email']}'" : 'NULL') . ', `contact_phone`=' . (($data['contact_phone'] !== '' && $data['contact_phone'] !== NULL) ? "'{$data['contact_phone']}'" : 'NULL') . ', `esports_coach`=' . (($data['esports_coach'] !== '' && $data['esports_coach'] !== NULL) ? "'{$data['esports_coach']}'" : 'NULL') . ', `edited_by`=' . "'{$data['edited_by']}'" . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="schools_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: schools_after_update
	if(function_exists('schools_after_update')){
		$res = sql("SELECT * FROM `schools` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!schools_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='schools' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function schools_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('schools');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}


	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='schools' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='schools' and pkValue='".makeSafe($selected_id)."'");
		if($arrPerm[2]==1 && getLoggedMemberID()!=$ownerMemberID){
			return "";
		}
		if($arrPerm[2]==2 && getLoggedGroupID()!=$ownerGroupID){
			return "";
		}

		// can edit?
		if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){
			$AllowUpdate=1;
		}else{
			$AllowUpdate=0;
		}

		$res = sql("select * from `schools` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'schools_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
	}else{
	}

	ob_start();
	?>

	<script>
		// initial lookup values

		jQuery(function() {
			setTimeout(function(){
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_contents());
	ob_end_clean();


	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/schools_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/schools_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'School details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($arrPerm[1] && !$selected_id){ // allow insert and no record selected?
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return schools_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return schools_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if($_REQUEST['Embedded']){
		$backAction = 'AppGini.closeParentModal(); return false;';
	}else{
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id){
		if(!$_REQUEST['Embedded']) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$$(\'form\')[0].writeAttribute(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return schools_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" onclick="return confirm(\'' . $Translation['are you sure?'] . '\');" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', ($ShowCancel ? '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>' : ''), $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate) || (!$selected_id && !$AllowInsert)){
		$jsReadOnly .= "\tjQuery('#school_crest').replaceWith('<div class=\"form-control-static\" id=\"school_crest\">' + (jQuery('#school_crest').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#school_name').replaceWith('<div class=\"form-control-static\" id=\"school_name\">' + (jQuery('#school_name').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#school_address').replaceWith('<div class=\"form-control-static\" id=\"school_address\">' + (jQuery('#school_address').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#school_postcode').replaceWith('<div class=\"form-control-static\" id=\"school_postcode\">' + (jQuery('#school_postcode').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#contact_name').replaceWith('<div class=\"form-control-static\" id=\"contact_name\">' + (jQuery('#contact_name').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#contact_email').replaceWith('<div class=\"form-control-static\" id=\"contact_email\">' + (jQuery('#contact_email').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#contact_email, #contact_email-edit-link').hide();\n";
		$jsReadOnly .= "\tjQuery('#contact_phone').replaceWith('<div class=\"form-control-static\" id=\"contact_phone\">' + (jQuery('#contact_phone').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#esports_coach').prop('disabled', true);\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif(($AllowInsert && !$selected_id) || ($AllowUpdate && $selected_id)){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array();
	foreach($lookup_fields as $luf => $ptfc){
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']){
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent hspacer-md" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] && !$_REQUEST['Embedded']){
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-success add_new_parent hspacer-md" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus-sign"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(school_crest)%%>', ($noUploads ? '' : '<input type=hidden name=MAX_FILE_SIZE value=102400>'.$Translation['upload image'].' <input type="file" name="school_crest" id="school_crest">'), $templateCode);
	if($AllowUpdate && $row['school_crest'] != ''){
		$templateCode = str_replace('<%%REMOVEFILE(school_crest)%%>', '<br><input type="checkbox" name="school_crest_remove" id="school_crest_remove" value="1"> <label for="school_crest_remove" style="color: red; font-weight: bold;">'.$Translation['remove image'].'</label>', $templateCode);
	}else{
		$templateCode = str_replace('<%%REMOVEFILE(school_crest)%%>', '', $templateCode);
	}
	$templateCode = str_replace('<%%UPLOADFILE(school_name)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(school_address)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(school_postcode)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(contact_name)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(contact_email)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(contact_phone)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(esports_coach)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(created_by)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(edited_by)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		$row['school_crest'] = ($row['school_crest'] != '' ? $row['school_crest'] : 'blank.gif');
		if( $dvprint) $templateCode = str_replace('<%%VALUE(school_crest)%%>', safe_html($urow['school_crest']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(school_crest)%%>', html_attr($row['school_crest']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(school_crest)%%>', urlencode($urow['school_crest']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(school_name)%%>', safe_html($urow['school_name']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(school_name)%%>', html_attr($row['school_name']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(school_name)%%>', urlencode($urow['school_name']), $templateCode);
		if($dvprint || (!$AllowUpdate && !$AllowInsert)){
			$templateCode = str_replace('<%%VALUE(school_address)%%>', safe_html($urow['school_address']), $templateCode);
		}else{
			$templateCode = str_replace('<%%VALUE(school_address)%%>', html_attr($row['school_address']), $templateCode);
		}
		$templateCode = str_replace('<%%URLVALUE(school_address)%%>', urlencode($urow['school_address']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(school_postcode)%%>', safe_html($urow['school_postcode']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(school_postcode)%%>', html_attr($row['school_postcode']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(school_postcode)%%>', urlencode($urow['school_postcode']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(contact_name)%%>', safe_html($urow['contact_name']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(contact_name)%%>', html_attr($row['contact_name']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(contact_name)%%>', urlencode($urow['contact_name']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(contact_email)%%>', safe_html($urow['contact_email']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(contact_email)%%>', html_attr($row['contact_email']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(contact_email)%%>', urlencode($urow['contact_email']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(contact_phone)%%>', safe_html($urow['contact_phone']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(contact_phone)%%>', html_attr($row['contact_phone']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(contact_phone)%%>', urlencode($urow['contact_phone']), $templateCode);
		$templateCode = str_replace('<%%CHECKED(esports_coach)%%>', ($row['esports_coach'] ? "checked" : ""), $templateCode);
		$templateCode = str_replace('<%%VALUE(created_by)%%>', safe_html($urow['created_by']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(created_by)%%>', urlencode($urow['created_by']), $templateCode);
		$templateCode = str_replace('<%%VALUE(edited_by)%%>', safe_html($urow['edited_by']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(edited_by)%%>', urlencode($urow['edited_by']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(school_crest)%%>', 'blank.gif', $templateCode);
		$templateCode = str_replace('<%%VALUE(school_name)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(school_name)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(school_address)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(school_address)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(school_postcode)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(school_postcode)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(contact_name)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(contact_name)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(contact_email)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(contact_email)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(contact_phone)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(contact_phone)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%CHECKED(esports_coach)%%>', '', $templateCode);
		$templateCode = str_replace('<%%VALUE(created_by)%%>', '<%%creatorUsername%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(created_by)%%>', urlencode('<%%creatorUsername%%>'), $templateCode);
		$templateCode = str_replace('<%%VALUE(edited_by)%%>', '<%%editorUsername%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(edited_by)%%>', urlencode('<%%editorUsername%%>'), $templateCode);
	}

	// process translations
	foreach($Translation as $symbol=>$trans){
		$templateCode = str_replace("<%%TRANSLATION($symbol)%%>", $trans, $templateCode);
	}

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if($_REQUEST['dvprint_x'] == ''){
		$templateCode .= "\n\n<script>\$j(function(){\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption){
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id){
			$templateCode.="\n\tif(document.getElementById('contact_emailEdit')){ document.getElementById('contact_emailEdit').style.display='inline'; }";
			$templateCode.="\n\tif(document.getElementById('contact_emailEditLink')){ document.getElementById('contact_emailEditLink').style.display='none'; }";
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('schools');
	if($selected_id){
		$jdata = get_joined_record('schools', $selected_id);
		if($jdata === false) $jdata = get_defaults('schools');
		$rdata = $row;
	}
	$templateCode .= loadView('schools-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: schools_dv
	if(function_exists('schools_dv')){
		$args=array();
		schools_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>