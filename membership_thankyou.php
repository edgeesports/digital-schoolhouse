<?php
	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	include_once("$currDir/header.php");

	if($_GET['redir']==1){
		echo '<META HTTP-EQUIV="Refresh" CONTENT="5;url=index.php?signIn=1">';
	}
?>

<center>
	<div style="width: 500px; text-align: left;">
		<h1 class="TableTitle"><?php echo $Translation['thanks']; ?></h1>

		<img src="images/dsh-logo-white-400x211.png"><br><br>
		<div class="navbar-brand" style="color:#ffffff;text-transform:none">
			<?php echo $Translation['sign in no approval']; ?>
			</div><br>
		<div class="navbar-brand" style="color:#ffffff;text-transform:none">
			<?php echo $Translation['sign in wait approval']; ?>
			</div>
		</div>
	</center>
<?php include_once("$currDir/footer.php"); ?>
