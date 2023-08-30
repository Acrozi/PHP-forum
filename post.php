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
   $categories = new Category($db);
   $topics = new Topic($db);
   include('inc/header.php');
   ?>
<title>Forum baserad på PHP och AJAX</title>
<script src="https://cdn.tiny.cloud/1/0hleeho0j3ps1ynyzbkp1tv3hweqlvap2dmrc5g6smll3rle/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- <script src="tinymce/tinymce.min.js"></script> -->
<script src="js/tinymce_editor.js"></script>
<?php
   // // Server side validation
   // if (isset($_POST['submit'])) {
   //     // reCAPTCHA response on submitting the form
   //     $response = $_POST['g-recaptcha-response'];
   //     // remoteip param is optional
   //     $payload = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$response);
   //     // Decoding JSON response from Google. TRUE param for assoc. array
   //     $res = json_decode($payload, true);
   //     // Checking payload response
   //     if ($res['success'] != 1):
   //       // Failure case
   //       $error = '✖ Oops! Missing reCAPTCHA validation.'; else:
   //       // Success case
   //       $success = '✔ Your message was sent successfully. Thank you!';
   //     endif;
   // }
   ?>
<!-- <script>
   var recaptcha_response = '';
   function submitUserForm() {
       if(recaptcha_response.length == 0) {
           document.getElementById('g-recaptcha-error').innerHTML = '<br><span style="color:red;">Lös captcha först.</span>';
           return false;
       }
       return true;
   }

   function verifyCaptcha(token) {
       recaptcha_response = token;
       document.getElementById('g-recaptcha-error').innerHTML = 'EY';
   }
   </script> -->
<script type="text/javascript">
   tinymce.init({
   	selector: '#editor',
      height: 300,
     	plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
    	toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
    	toolbar_mode: 'floating',
      statusbar: false,
      menubar:false,
   	tinycomments_mode: 'embedded',
   	tinycomments_author: 'Author name',
   });
</script>
<link rel="stylesheet" href="css/style.css">
<?php include('inc/container.php'); ?>
<div class="container">
   <div class="row">
      <?php
         $topics->topic_id = $_GET['topic_id'];
         $topicDetails = $topics->getTopic();
         ?>
      <h2 class="text-center"><?php echo $topicDetails['subject'];?></h2>
      <?php include("top_menus.php"); ?>
      <br>
      <div id="postLsit">
         <?php if(!empty($_GET['topic_id'])) { ?>
         <div class="posts list">
            <span style="font-size:20px;"><a href="index.php?category_id=<?php echo $topicDetails['category_id']; ?>"><< <?php echo $topicDetails['subject']; ?></a></span>
            <br><br>
            <?php
               $result = $topics->getPosts();
               ?>
         </div>
         <div class="col-md-10 col-sm-10">
            <?php include 'config.php'?>
            <?php
               while ($row = mysqli_fetch_assoc($result)) {
                   $noResult = false;
                   // $desc = $row['comment_desc'];
                   $content = $row['message'];
                   $comment_time = $row['created'];
                   $thread_user_id = $row['user_id'];
                   $sql2 = "SELECT * FROM `forum_users` WHERE user_id='$thread_user_id'";
                   $result2 = mysqli_query($conn, $sql2);
                   $row2 = mysqli_fetch_assoc($result2);

                   echo'
               <div class="panel-body">
                   <figure class="thumbnail">
                    <img  class="img-responsive" src="profile/'.$row2['profilepic'].'"/>
                    <figcaption class="text-center">'. $row2['name'] . '</figcaption>
                    </figure>';
                   echo'
                <div class="col-md-2 col-sm-2 hidden-xs">
                    <div class="panel panel-default arrow left">
                   <div style="padding: 2rem 1rem;
                     <div style="display:inline;">
                     <header class="text-left">
               	<div class="comment-user"><i class="fa fa-user"></i> By: '. $row2['name'] . ' / ' .$row2['email'] .'</div>
               	<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> '.$comment_time.'</time>
                 </header>
                        <br>
                <div class="comment-post">
               '.$content.'
               </div>
                </div>
                       </div>
                       <div class="col-md-10 col-sm-10">
                     </div>
               </div>
               </div>';
               }
               ?>
         </div>
      </div>
      </article>
      <?php } ?>
   </div>
</div>
<?php if($user->loggedIn()) { ?>
<form id="posts" name="posts" method="post" onsubmit="return submitUserForm();">
   <textarea name="message" id="editor"></textarea>
   <br>
   <!-- <textarea-1 id="default">Hello, World!</textarea-1> -->
   <input type="hidden" name="action" id="action" value="save" />
   <input type="hidden" name="topic_id" value="<?php echo $_GET['topic_id']; ?>">
   <div class="form-group text-center">
      <div class="g-recaptcha" data-theme="light" data-size="normal" data-callback="captchaVerified"
         data-expired-callback="captchaExpired" data-sitekey=<?php echo $site_key; ?>></div>
   </div>
   <div id="g-recaptcha-error"></div>
   <!-- Submit Btn -->
   <div class="text-center mt-3">
      <button class="btn btn-info saveButton shadow-sm disabled" id="save" type="submit" name="submit" disabled
         aria-disabled="true"><i class="fa fa-paper-plane"></i>Publicera</button>
      <!-- <div class="text-center mt-3">
         <button class="btn btn-lg btn-outline-info shadow-sm disabled" id="submit" type="submit" name="submit" disabled
           aria-disabled="true"><i class="fa fa-paper-plane"></i> &nbsp; Send</button>
         </div> -->
      <!-- <button type="submit" id="save" name="save" class="btn btn-info saveButton">Post</button> -->
   </div>
   <!-- <div class="g-recaptcha" data-sitekey="6Le2-yUfAAAAAHpzvLPUtq6_MffjUN4vLu96N-U-"></div>
      <input type="submit" name="submit" value="SUBMIT">

      <button type="submit" id="save" name="save" class="btn btn-info saveButton">Post</button> -->
</form>
<?php } else { ?>
<a href="login.php">Login to reply</a>
<?php } ?>
<div id="postHtml" class="hidden">
</div>
<script>
   // Verification callback function
   function captchaVerified() {
     var submitBtn = document.getElementById('save');
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
</div>
<?php include("inc/footer.php"); ?>
<style>
   .col-md-10 {
   width: 100%;
   padding: 0px;
   }
   .thumbnail {
   display: block;
   padding: 4px;
   margin-bottom: 20px;
   line-height: 1.42857143;
   background-color: #fff;
   border: 1px solid #ddd;
   border-radius: 4px;
   -webkit-transition: border .2s ease-in-out;
   -o-transition: border .2s ease-in-out;
   transition: border .2s ease-in-out;
   width: 150px;
   height: auto;
   float: left;
   }
   .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
   width: 84.3%;
   }
   .panel-body {
   padding: 0px;
   width: 125%;
   }
   .container {
   width: 1500px;
   }
   .navbar {
   font-size: 1.6rem;
   }
   .navbar-brand {
   float: left;
   height: 50px;
   padding: 15px 15px;
   font-size: 18px;
   line-height: 20px;
   font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
   }
</style>
