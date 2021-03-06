<?php

// Data functions (insert, update, delete, form) for table games

// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

function games_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('games');
	if(!$arrPerm[1]){
		return false;
	}

	$data['game_title'] = makeSafe($_REQUEST['game_title']);
		if($data['game_title'] == empty_lookup_value){ $data['game_title'] = ''; }
	$data['created_by'] = parseCode('<%%creatorUsername%%>', true);
	$data['game_logo'] = PrepareUploadedFile('game_logo', 102400,'jpg|jpeg|gif|png', false, '');
	if($data['game_logo']) createThumbnail($data['game_logo'], getThumbnailSpecs('games', 'game_logo', 'tv'));
	if($data['game_logo']) createThumbnail($data['game_logo'], getThumbnailSpecs('games', 'game_logo', 'dv'));
	$data['pegi_rating'] = PrepareUploadedFile('pegi_rating', 102400,'jpg|jpeg|gif|png', false, '');
	if($data['pegi_rating']) createThumbnail($data['pegi_rating'], getThumbnailSpecs('games', 'pegi_rating', 'tv'));
	if($data['pegi_rating']) createThumbnail($data['pegi_rating'], getThumbnailSpecs('games', 'pegi_rating', 'dv'));
	if($data['game_title']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Game': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	/* for empty upload fields, when saving a copy of an existing record, copy the original upload field */
	if($_REQUEST['SelectedID']){
		$res = sql("select * from games where id='" . makeSafe($_REQUEST['SelectedID']) . "'", $eo);
		if($row = db_fetch_assoc($res)){
			if(!$data['game_logo']) $data['game_logo'] = makeSafe($row['game_logo']);
			if(!$data['pegi_rating']) $data['pegi_rating'] = makeSafe($row['pegi_rating']);
		}
	}

	// hook: games_before_insert
	if(function_exists('games_before_insert')){
		$args=array();
		if(!games_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `games` set       ' . ($data['game_logo'] != '' ? "`game_logo`='{$data['game_logo']}'" : '`game_logo`=NULL') . ', `game_title`=' . (($data['game_title'] !== '' && $data['game_title'] !== NULL) ? "'{$data['game_title']}'" : 'NULL') . ', ' . ($data['pegi_rating'] != '' ? "`pegi_rating`='{$data['pegi_rating']}'" : '`pegi_rating`=NULL') . ', `created_by`=' . "'{$data['created_by']}'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"games_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: games_after_insert
	if(function_exists('games_after_insert')){
		$res = sql("select * from `games` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!games_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('games', $recID, getLoggedMemberID());

	return $recID;
}

function games_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('games');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='games' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='games' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: games_before_delete
	if(function_exists('games_before_delete')){
		$args=array();
		if(!games_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `games` where `id`='$selected_id'", $eo);

	// hook: games_after_delete
	if(function_exists('games_after_delete')){
		$args=array();
		games_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='games' and pkValue='$selected_id'", $eo);
}

function games_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('games');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='games' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='games' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['game_title'] = makeSafe($_REQUEST['game_title']);
		if($data['game_title'] == empty_lookup_value){ $data['game_title'] = ''; }
	if($data['game_title']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Game': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['edited_by'] = parseCode('<%%editorUsername%%>', false);
	$data['selectedID']=makeSafe($selected_id);
	if($_REQUEST['game_logo_remove'] == 1){
		$data['game_logo'] = '';
	}else{
		$data['game_logo'] = PrepareUploadedFile('game_logo', 102400, 'jpg|jpeg|gif|png', false, "");
		if($data['game_logo']) createThumbnail($data['game_logo'], getThumbnailSpecs('games', 'game_logo', 'tv'));
		if($data['game_logo']) createThumbnail($data['game_logo'], getThumbnailSpecs('games', 'game_logo', 'dv'));
	}
	if($_REQUEST['pegi_rating_remove'] == 1){
		$data['pegi_rating'] = '';
	}else{
		$data['pegi_rating'] = PrepareUploadedFile('pegi_rating', 102400, 'jpg|jpeg|gif|png', false, "");
		if($data['pegi_rating']) createThumbnail($data['pegi_rating'], getThumbnailSpecs('games', 'pegi_rating', 'tv'));
		if($data['pegi_rating']) createThumbnail($data['pegi_rating'], getThumbnailSpecs('games', 'pegi_rating', 'dv'));
	}

	// hook: games_before_update
	if(function_exists('games_before_update')){
		$args=array();
		if(!games_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `games` set       ' . ($data['game_logo']!='' ? "`game_logo`='{$data['game_logo']}'" : ($_REQUEST['game_logo_remove'] != 1 ? '`game_logo`=`game_logo`' : '`game_logo`=NULL')) . ', `game_title`=' . (($data['game_title'] !== '' && $data['game_title'] !== NULL) ? "'{$data['game_title']}'" : 'NULL') . ', ' . ($data['pegi_rating']!='' ? "`pegi_rating`='{$data['pegi_rating']}'" : ($_REQUEST['pegi_rating_remove'] != 1 ? '`pegi_rating`=`pegi_rating`' : '`pegi_rating`=NULL')) . ', `edited_by`=' . "'{$data['edited_by']}'" . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="games_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: games_after_update
	if(function_exists('games_after_update')){
		$res = sql("SELECT * FROM `games` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!games_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='games' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function games_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('games');
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
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='games' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='games' and pkValue='".makeSafe($selected_id)."'");
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

		$res = sql("select * from `games` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'games_view.php', false);
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
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/games_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/games_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Game details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($arrPerm[1] && !$selected_id){ // allow insert and no record selected?
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return games_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return games_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
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
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return games_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
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
		$jsReadOnly .= "\tjQuery('#game_logo').replaceWith('<div class=\"form-control-static\" id=\"game_logo\">' + (jQuery('#game_logo').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#game_title').replaceWith('<div class=\"form-control-static\" id=\"game_title\">' + (jQuery('#game_title').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#pegi_rating').replaceWith('<div class=\"form-control-static\" id=\"pegi_rating\">' + (jQuery('#pegi_rating').val() || '') + '</div>');\n";
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
	$templateCode = str_replace('<%%UPLOADFILE(game_logo)%%>', ($noUploads ? '' : '<input type=hidden name=MAX_FILE_SIZE value=102400>'.$Translation['upload image'].' <input type="file" name="game_logo" id="game_logo">'), $templateCode);
	if($AllowUpdate && $row['game_logo'] != ''){
		$templateCode = str_replace('<%%REMOVEFILE(game_logo)%%>', '<br><input type="checkbox" name="game_logo_remove" id="game_logo_remove" value="1"> <label for="game_logo_remove" style="color: red; font-weight: bold;">'.$Translation['remove image'].'</label>', $templateCode);
	}else{
		$templateCode = str_replace('<%%REMOVEFILE(game_logo)%%>', '', $templateCode);
	}
	$templateCode = str_replace('<%%UPLOADFILE(game_title)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(pegi_rating)%%>', ($noUploads ? '' : '<input type=hidden name=MAX_FILE_SIZE value=102400>'.$Translation['upload image'].' <input type="file" name="pegi_rating" id="pegi_rating">'), $templateCode);
	if($AllowUpdate && $row['pegi_rating'] != ''){
		$templateCode = str_replace('<%%REMOVEFILE(pegi_rating)%%>', '<br><input type="checkbox" name="pegi_rating_remove" id="pegi_rating_remove" value="1"> <label for="pegi_rating_remove" style="color: red; font-weight: bold;">'.$Translation['remove image'].'</label>', $templateCode);
	}else{
		$templateCode = str_replace('<%%REMOVEFILE(pegi_rating)%%>', '', $templateCode);
	}
	$templateCode = str_replace('<%%UPLOADFILE(created_by)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(edited_by)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		$row['game_logo'] = ($row['game_logo'] != '' ? $row['game_logo'] : 'blank.gif');
		if( $dvprint) $templateCode = str_replace('<%%VALUE(game_logo)%%>', safe_html($urow['game_logo']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(game_logo)%%>', html_attr($row['game_logo']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(game_logo)%%>', urlencode($urow['game_logo']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(game_title)%%>', safe_html($urow['game_title']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(game_title)%%>', html_attr($row['game_title']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(game_title)%%>', urlencode($urow['game_title']), $templateCode);
		$row['pegi_rating'] = ($row['pegi_rating'] != '' ? $row['pegi_rating'] : 'blank.gif');
		if( $dvprint) $templateCode = str_replace('<%%VALUE(pegi_rating)%%>', safe_html($urow['pegi_rating']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(pegi_rating)%%>', html_attr($row['pegi_rating']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(pegi_rating)%%>', urlencode($urow['pegi_rating']), $templateCode);
		$templateCode = str_replace('<%%VALUE(created_by)%%>', safe_html($urow['created_by']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(created_by)%%>', urlencode($urow['created_by']), $templateCode);
		$templateCode = str_replace('<%%VALUE(edited_by)%%>', safe_html($urow['edited_by']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(edited_by)%%>', urlencode($urow['edited_by']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(game_logo)%%>', 'blank.gif', $templateCode);
		$templateCode = str_replace('<%%VALUE(game_title)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(game_title)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(pegi_rating)%%>', 'blank.gif', $templateCode);
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
	$rdata = $jdata = get_defaults('games');
	if($selected_id){
		$jdata = get_joined_record('games', $selected_id);
		if($jdata === false) $jdata = get_defaults('games');
		$rdata = $row;
	}
	$templateCode .= loadView('games-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: games_dv
	if(function_exists('games_dv')){
		$args=array();
		games_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>