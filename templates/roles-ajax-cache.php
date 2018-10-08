<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'roles';

		/* data for selected record, or defaults if none is selected */
		var data = {
			role_type: <?php echo json_encode(array('id' => $rdata['role_type'], 'value' => $rdata['role_type'], 'text' => $jdata['role_type'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for role_type */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'role_type' && d.id == data.role_type.id)
				return { results: [ data.role_type ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

