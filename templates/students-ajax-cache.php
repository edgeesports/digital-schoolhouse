<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'students';

		/* data for selected record, or defaults if none is selected */
		var data = {
			school: <?php echo json_encode(array('id' => $rdata['school'], 'value' => $rdata['school'], 'text' => $jdata['school'])); ?>,
			role_type: <?php echo json_encode(array('id' => $rdata['role_type'], 'value' => $rdata['role_type'], 'text' => $jdata['role_type'])); ?>,
			role: <?php echo json_encode(array('id' => $rdata['role'], 'value' => $rdata['role'], 'text' => $jdata['role'])); ?>,
			team: <?php echo json_encode(array('id' => $rdata['team'], 'value' => $rdata['team'], 'text' => $jdata['team'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for school */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'school' && d.id == data.school.id)
				return { results: [ data.school ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for role_type */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'role_type' && d.id == data.role_type.id)
				return { results: [ data.role_type ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for role */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'role' && d.id == data.role.id)
				return { results: [ data.role ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for team */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'team' && d.id == data.team.id)
				return { results: [ data.team ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

