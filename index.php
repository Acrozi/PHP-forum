<?php
include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Category.php';
include_once 'class/Topic.php';
include('inc/header.php');

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$categories = new Category($db);
$topics = new Topic($db);

?>
<div class="jumbotron text-center p-0 mb-0">
		<div class="bg-div px-5 d-flex align-items-center">
				<div class="text-left w-50">
						<h1 class="display-4 text-white">Slutprojekt - Forum</h1>
				</div>
</div>
</div>

<title>Slutprojekt - Forum</title>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="css/style.css">

<?php include('inc/container.php'); ?>
<div class="container">
	<div class="row">
		<?php include("top_menus.php"); ?>

		<?php if(empty($_GET['category_id'])) { ?>
			<div class="single category">
				<ul class="list-unstyled">
					<li><span style="font-size:25px;font-weight:bold;">Kategorier</span> <span class="pull-right"><span style="font-size:20px;font-weight:bold;">Trådar / Svar</span></span></li>
					<?php
					$result = $categories->getCategoryList();
					while ($category = $result->fetch_assoc()) {
						$categories->category_id = $category['category_id'];
						$totalTopic = $categories->getCategoryTopicsCount();
						$totalPosts = $categories->getCategoryPostsCount();
					?>
						<li><a href="index.php?category_id=<?php echo $category['category_id'];?>" title=""><?php echo $category['name']; ?> <span class="pull-right"><?php echo $totalTopic; ?> / <?php echo $totalPosts; ?></span></a></li>
					<?php } ?>
				</ul>
		   </div>
	   <?php } else if(!empty($_GET['category_id'])) { ?>
		   <div class="single category">
				<?php
				$categories->category_id = $_GET['category_id'];
				$categoryDetails = $categories->getCategory();
				?>
				<span style="font-size:20px;"><a href="index.php"><< <?php echo $categoryDetails['name']; ?></a></span>
				<br>	<br>
				<ul class="list-unstyled">
					<li class="text-right">
					<a type="button" class="btn btn-primary" href="compose.php?category_id=<?php echo $_GET['category_id'];?>"><span style="font-size:20px;font-weight:bold;color:white;">Skapa ett nytt tråd</span></a>
					</li><br>
					<li><span style="font-size:20px;font-weight:bold;">Trådar</span> <span class="pull-right"><span style="font-size:15px;font-weight:bold;">Svar</span></span></li>
					<?php
					$topics->category_id = $_GET['category_id'];
					$result = $topics->getTopicList();
					while ($topic = $result->fetch_assoc()) {
						$topics->topic_id = $topic['topic_id'];
						$totalTopicPosts = $topics->getTopicPostCount();
					?>
						<li><a href="post.php?topic_id=<?php echo $topic['topic_id'];?>" title=""><?php echo $topic['subject']; ?> <span class="pull-right"><?php echo $totalTopicPosts; ?></span></a></li>
					<?php } ?>
				</ul>
		   </div>
	   <?php } ?>
	</div>
</div>
<?php include("inc/footer.php"); ?>


<style>

.bg-div {
		background: linear-gradient(rgba(0, 0, 0, 0.5),
		rgba(0, 0, 0, 0.5)), url("./images/pexels-marc-mueller.jpg");
		height: 680px;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
}

.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 2200px;
}

.navbar-expand-lg .navbar-nav {
    -ms-flex-direction: row;
    flex-direction: row;
}

.navbar {
    position: relative;
    min-height: 50px;
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

.navbar {
		position: relative;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-wrap: wrap;
		flex-wrap: wrap;
		-ms-flex-align: center;
		align-items: center;
		-ms-flex-pack: justify;
		justify-content: space-between;
		padding: 0px;
}

</style>
