<?php
	// check this file's MD5 to make sure it wasn't called before
	$prevMD5=@implode('', @file(dirname(__FILE__).'/setup.md5'));
	$thisMD5=md5(@implode('', @file("./updateDB.php")));
	if($thisMD5==$prevMD5){
		$setupAlreadyRun=true;
	}else{
		// set up tables
		if(!isset($silent)){
			$silent=true;
		}

		// set up tables
		setupTable('students', "create table if not exists `students` (   `id` INT unsigned not null auto_increment , primary key (`id`), `profile_pic` VARCHAR(80) , `first_name` VARCHAR(80) not null , `last_name` VARCHAR(80) not null , `gamertag` VARCHAR(80) , `gender` VARCHAR(80) not null , `school` INT unsigned not null , `year_group` VARCHAR(80) not null , `tutor_group` VARCHAR(80) not null , `role_type` INT unsigned not null , `role` INT unsigned not null , `team` INT unsigned , `email` VARCHAR(80) not null , unique `email_unique` (`email`), `profile_text` TEXT , `overwatch_stats` VARCHAR(80) , `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent, array( "ALTER TABLE `students` DROP INDEX `created_by`","ALTER TABLE `students` ADD UNIQUE `email_unique` (`email`)"));
		setupIndexes('students', array('school','role_type','role','team'));
		setupTable('teams', "create table if not exists `teams` (   `id` INT unsigned not null auto_increment , primary key (`id`), `team_logo` VARCHAR(80) , `team_name` VARCHAR(80) not null , unique `team_name_unique` (`team_name`), `school` INT unsigned not null , `matches` SMALLINT default '0' , `wins` SMALLINT default '0' , `losses` SMALLINT default '0' , `draws` SMALLINT default '0' , `points` SMALLINT default '0' , `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent);
		setupIndexes('teams', array('school'));
		setupTable('schools', "create table if not exists `schools` (   `id` INT unsigned not null auto_increment , primary key (`id`), `school_crest` VARCHAR(80) , `school_name` VARCHAR(80) not null , unique `school_name_unique` (`school_name`), `school_address` VARCHAR(80) not null , `school_postcode` VARCHAR(80) not null , `contact_name` VARCHAR(80) , `contact_email` VARCHAR(80) , `contact_phone` VARCHAR(80) , `esports_coach` VARCHAR(80) , `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent);
		setupTable('help', "create table if not exists `help` (   `id` INT unsigned not null auto_increment , primary key (`id`), `faq` TEXT not null ) CHARSET latin1", $silent);
		setupTable('role_types', "create table if not exists `role_types` (   `id` INT unsigned not null auto_increment , primary key (`id`), `role_type` VARCHAR(80) not null , unique `role_type_unique` (`role_type`), `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent);
		setupTable('roles', "create table if not exists `roles` (   `id` INT unsigned not null auto_increment , primary key (`id`), `role` VARCHAR(40) not null , unique `role_unique` (`role`), `role_type` INT unsigned , `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent);
		setupIndexes('roles', array('role_type'));
		setupTable('games', "create table if not exists `games` (   `id` INT unsigned not null auto_increment , primary key (`id`), `game_logo` VARCHAR(40) , `game_title` VARCHAR(40) not null , unique `game_title_unique` (`game_title`), `pegi_rating` VARCHAR(40) , `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent);
		setupTable('preliminaries', "create table if not exists `preliminaries` (   `id` INT unsigned not null auto_increment , primary key (`id`), `team` INT unsigned not null , `matches` SMALLINT default '0' , `wins` SMALLINT default '0' , `losses` SMALLINT default '0' , `draws` SMALLINT default '0' , `points` SMALLINT default '0' , `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent);
		setupTable('regional_finals', "create table if not exists `regional_finals` (   `id` INT unsigned not null auto_increment , primary key (`id`), `team` INT unsigned not null , `matches` SMALLINT default '0' , `wins` SMALLINT default '0' , `losses` SMALLINT default '0' , `draws` SMALLINT default '0' , `points` SMALLINT default '0' , `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent);
		setupTable('grand_final', "create table if not exists `grand_final` (   `id` INT unsigned not null auto_increment , primary key (`id`), `team` INT unsigned not null , `matches` SMALLINT default '0' , `wins` SMALLINT default '0' , `losses` SMALLINT default '0' , `draws` SMALLINT default '0' , `points` SMALLINT default '0' , `created_by` VARCHAR(80) , `edited_by` VARCHAR(80) ) CHARSET latin1", $silent);


		// save MD5
		if($fp=@fopen(dirname(__FILE__).'/setup.md5', 'w')){
			fwrite($fp, $thisMD5);
			fclose($fp);
		}
	}


	function setupIndexes($tableName, $arrFields){
		if(!is_array($arrFields)){
			return false;
		}

		foreach($arrFields as $fieldName){
			if(!$res=@db_query("SHOW COLUMNS FROM `$tableName` like '$fieldName'")){
				continue;
			}
			if(!$row=@db_fetch_assoc($res)){
				continue;
			}
			if($row['Key']==''){
				@db_query("ALTER TABLE `$tableName` ADD INDEX `$fieldName` (`$fieldName`)");
			}
		}
	}


	function setupTable($tableName, $createSQL='', $silent=true, $arrAlter=''){
		global $Translation;
		ob_start();

		echo '<div style="padding: 5px; border-bottom:solid 1px silver; font-family: verdana, arial; font-size: 10px;">';

		// is there a table rename query?
		if(is_array($arrAlter)){
			$matches=array();
			if(preg_match("/ALTER TABLE `(.*)` RENAME `$tableName`/", $arrAlter[0], $matches)){
				$oldTableName=$matches[1];
			}
		}

		if($res=@db_query("select count(1) from `$tableName`")){ // table already exists
			if($row = @db_fetch_array($res)){
				echo str_replace("<TableName>", $tableName, str_replace("<NumRecords>", $row[0],$Translation["table exists"]));
				if(is_array($arrAlter)){
					echo '<br>';
					foreach($arrAlter as $alter){
						if($alter!=''){
							echo "$alter ... ";
							if(!@db_query($alter)){
								echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
								echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
							}else{
								echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
							}
						}
					}
				}else{
					echo $Translation["table uptodate"];
				}
			}else{
				echo str_replace("<TableName>", $tableName, $Translation["couldnt count"]);
			}
		}else{ // given tableName doesn't exist

			if($oldTableName!=''){ // if we have a table rename query
				if($ro=@db_query("select count(1) from `$oldTableName`")){ // if old table exists, rename it.
					$renameQuery=array_shift($arrAlter); // get and remove rename query

					echo "$renameQuery ... ";
					if(!@db_query($renameQuery)){
						echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
						echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
					}else{
						echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
					}

					if(is_array($arrAlter)) setupTable($tableName, $createSQL, false, $arrAlter); // execute Alter queries on renamed table ...
				}else{ // if old tableName doesn't exist (nor the new one since we're here), then just create the table.
					setupTable($tableName, $createSQL, false); // no Alter queries passed ...
				}
			}else{ // tableName doesn't exist and no rename, so just create the table
				echo str_replace("<TableName>", $tableName, $Translation["creating table"]);
				if(!@db_query($createSQL)){
					echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
					echo '<div class="text-danger">' . $Translation['mysql said'] . db_error(db_link()) . '</div>';
				}else{
					echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
				}
			}
		}

		echo "</div>";

		$out=ob_get_contents();
		ob_end_clean();
		if(!$silent){
			echo $out;
		}
	}
?>