<?php

include 'config.php';
session_start();
$user_id = $_SESSION['userid'];
if(!isset($user_id)){
   header('Location:../login.php');
};

if(isset($_POST['update_profile'])){
   $filename = $_FILES['update_image']['name'];
   $update_image_sql = './UserProfilePic/'.$filename;
   $update_image = './UserProfilePic/'.$filename;
   // $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = ''.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'Bilden är för stor, max storlek är: 2MB';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `forum_users` SET profilepic = '$update_image_sql' WHERE user_id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'bilden uppdaterades!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profil</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `forum_users` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['profilepic'] == ''){
            echo '<img src="/default-avatar.png">';
         }else{
            echo '<img src="'.$fetch['profilepic'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>välj din bild: (format: jpg, jpeg, png)</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="home.php" class="delete-btn">gå tillbaka</a>
   </form>

</div>

</body>
</html>
