<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="./index.php" class="navbar-brand">PHP Forum</a>
    <ul class="navbar-nav mr-auto">
<?php if(!empty($_SESSION['userid']) && $_SESSION['userid']) { ?>
    <li class="nav-item"><a class="nav-link" href="index.php">Home | </a></li>  <li class="nav-item"><a class="nav-link"> Logged in: <?php echo ucfirst($_SESSION["name"]); ?> | <li class="nav-item"><a class="nav-link" href="logout.php">Logout | </a></li>
    <li class="nav-item"><a class="nav-link"   href="cp_login.php" target="_blank" >Control Panel</a></li>
</h3>
<?php } else { ?>
  <li class="nav-item"><a class="nav-link" href="index.php">Home | </a></li> <li class="nav-item"><a class="nav-link" href="login.php">Login | </a></li><li class="nav-item"><a class="nav-link"  href="cp_login.php">Control Panel</a></li> </ul>
<?php } ?>
</nav>
</head> -->


<style>


.navbar-expand-lg .navbar-nav {
    -ms-flex-direction: row;
    flex-direction: row;
}

.navbar {
    position: relative;
    min-height: 50px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    padding: 0.5rem 1rem;
}


.navbar-light .navbar-nav .nav-link {
    color: rgba(0,0,0,.5);
}


.navbar-expand-lg .navbar-nav .nav-link {
    padding-right: 0.5rem;
    padding-left: 0.5rem;
}


.navbar-nav>li>a {
    padding-top: 15px;
    padding-bottom: 15px;
}

.navbar-brand {
    float: left;
    height: 50px;
    padding: 15px 15px;
    font-size: 18px;
    line-height: 20px;
}

.navbar-light .navbar-brand {
    color: rgba(0,0,0,.9);
}


.nav-link {
    display: block;
    padding: 0.5rem 1rem;
}


.bg-light {
    background-color: #f8f9fa!important;
}

.navbar-nav {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}







</style>



<?php
include_once 'config/Database.php';
include_once 'class/Owner.php';

$database = new Database();
$db = $database->getConnection();

$owner = new Owner($db);
if(!$owner->loggedIn()) {
	header("Location: cp_login.php");
}
include('inc/header.php');
?>
<title>Kontrollpanelen</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<?php include('inc/container.php');?>
<div class="container">
	<?php include('menus.php'); ?>
	<h2>Vällkommen till kontrollpanelen, <?php echo "".$_SESSION["ownerUser"];  ?></h2>
</div>
<!-- <?php include('inc/footer.php');?> -->
