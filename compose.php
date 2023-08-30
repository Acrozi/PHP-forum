<?php
require_once('captcha.php');
$site_key = $_ENV['SITE_KEY'];
$secret_key = $_ENV['SECRET_KEY'];

include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Category.php';
include_once 'class/Topic.php';
include_once 'class/Post.php';
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$topics = new Topic($db);
$categories = new Category($db);
// echo $user->loggedIn();
if(!$user->loggedIn()) {
	header("Location: login.php");
}
$categories->category_id = $_GET['category_id'];
$categoryDetails = $categories->getCategory();
if(!empty($_POST['saveTopic']) && $_POST['saveTopic'] && $_POST['message']) {
	$topics->save();
}
include('inc/header.php');
?>
<title>Discussion Forum with PHP and MySQL</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.tiny.cloud/1/0hleeho0j3ps1ynyzbkp1tv3hweqlvap2dmrc5g6smll3rle/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>


<script src="js/tinymce_editor.js"></script>
<script src="js/topics.js"></script>
<script type="text/javascript"></script>
<script>
 tinymce.init({
	 selector: '#editor',
	 height: 300,
	  max_chars: 10,
	 plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker wordcount',
	 toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
	 toolbar_mode: 'floating',
	 statusbar: false,
	 menubar:false,
	 tinycomments_mode: 'embedded',
	 tinycomments_author: 'Author name',
 });
</script>

<script>
	// Verification callback function
	function captchaVerified() {
		var submitBtn = document.getElementById('saveTopic');
		submitBtn.removeAttribute('disabled');
		submitBtn.removeAttribute('aria-disabled');
		submitBtn.classList.remove('btn-outline-info', 'disabled');
		submitBtn.classList.add('btn-info');

	}
	// Expiration callback function
	function captchaExpired() {
		grecaptcha.reset();
	}
</script>

<link rel="stylesheet" href="css/style.css">
<?php include('inc/container.php'); ?>
<div class="container">
	<div class="row">
		<h2>Discussion Forum with PHP and MySQL</h2>
		<br>
		<span style="font-size:20px;"><a href="index.php"><< <?php echo $categoryDetails['name']; ?></a></span>
		<br><br>
		<div id="createNewtopic">
			<form id="topicForm" name="topicForm" method="post">
				<div class="form-group">
					<label for="email">Topic Name:</label>
					<input type="text" maxlength="250" name="topicName" id="topicName" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">Message:</label>
					<textarea name="message" id="editor"></textarea>
				</div>

				<div class="form-group text-center">
	        <div class="g-recaptcha" data-theme="light" data-size="normal" data-callback="captchaVerified"
	          data-expired-callback="captchaExpired" data-sitekey=<?php echo $site_key; ?>></div>
	      </div>

				       <div id="g-recaptcha-error"></div>


				<input type="hidden" name="action" value="createTopic">
				<input type="hidden" name="categoryId" value="<?php echo $_GET['category_id']; ?>">
				<button type="submit" id="saveTopic" name="saveTopic" disabled aria-disabled="true" class="btn btn-info saveButton shadow-sm disabled" >Skapa tråd</button>
			</form>
		</div>
	</div>
</div>
<?php include("inc/footer.php"); ?>
