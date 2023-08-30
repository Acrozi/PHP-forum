<h2>Kontrollpanel</h2>
<?php if($_SESSION["ownerId"] !='') { ?>
<h3><?php echo "Logged in: ".$_SESSION["ownerUser"];  ?> | <a href="index.php" target="_blank">Forum</a> | <a href="cp_logout.php">Logga ut</a> </h3>
<?php } else {	?>
<h3><a href="index.php" target="_blank">Forum</a> | <a href="cp_login.php">Login</a> </h3>
<?php } ?>
<br>
<ul class="nav nav-tabs">
	<li id="dashboard" class="active"><a href="dashboard.php">Kontrollpanelen</a></li>
	<li id="users"><a href="users.php">Användare</a></li>
	<li id="category_manager"><a href="category_manager.php">Kategorier</a></li>
</ul>
