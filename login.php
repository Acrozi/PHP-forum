<?php
include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Category.php';
include_once 'class/Topic.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$categories = new Category($db);
$topics = new Topic($db);

if($user->loggedIn()) {
	header("Location: index.php");
}

$loginMessage = '';
if(!empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
	$user->email = $_POST["email"];
	$user->password = $_POST["password"];
	if($user->login()) {
		if($_POST["referal_url"]) {
			// header("Location: ".$_POST["referal_url"]);
						header("Location:index.php");
		} else {
			header("Location: index.php");
		}
	} else {
		$loginMessage = 'Invalid login! Please try again.';
	}
} else if (empty($_POST["login"]) || empty($_POST["email"]) || empty($_POST["password"])){
	$loginMessage = 'Enter email and pasword to login.';
}

include('inc/header.php');
?>
<title>Discussion Forum with PHP and MySQL</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/register.css">
<?php include('inc/container.php'); ?>
<div class="container">
	<div class="row">
		<!-- <h2 class="text-center">Slutprojekt - forum baserad på PHP och AJAX</h2> -->
		<div class="imgcontainer">
	    <img src="images/img_avatar2.png" alt="Avatar" class="avatar">
			<br><br><br><br>
	  </div>
		<?php include("top_menus.php"); ?>

		<body class="text-center">
		<main class="form-signin">

		<!-- <div class="single category"> -->
			<!-- <div style="padding-top:30px;width:400px;" class="panel-body" > -->
				<?php if ($loginMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $loginMessage; ?></div>
				<?php } ?>
				<form id="loginform" class="form-horizontal" role="form" method="POST" action="">
					    <div class="form-floating mb-3">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" class="form-control" id="email" name="email" value="<?php if(!empty($_POST["email"])) { echo $_POST["email"]; } ?>" placeholder="email" style="background:white;" required>
            <label for="floatingEmail">Email address</label>
					</div>
					<div class="form-floating  mb-3">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" id="password" name="password" value="<?php if(!empty($_POST["password"])) { echo $_POST["password"]; } ?>" placeholder="password" required>
            <label for="floatingPhone">Password</label>
					</div>
					<div class="form-floating  mb-3">
						<input type="hidden" name="referal_url" value="<?php if(!empty($_SERVER['HTTP_REFERER'])) { echo $_SERVER['HTTP_REFERER']; } ?>">
						<div class="form-floating  mb-3">
						  <input type="submit" name="login" value="Login" class="w-100 btn btn-lg btn-primary">
						</div>
					</div>
				</form>
			</div>

	<style>
	.navbar {
padding: 0px;
	}
	.navbar-brand {
			float: left;
			height: 50px;
			padding: 15px 15px;
			line-height: 20px;
	}
	img.avatar {
	  width: 15%;
	  border-radius: 50%;
	}

	.imgcontainer {
	  text-align: center;
	  margin: 24px 0 12px 0;
	}

	</style>
