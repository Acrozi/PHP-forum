<?php
include 'config.php';
session_start();
$user_id = $_SESSION['userid'];

if(empty($_SESSION['userid']) ) {
  header('Location:../login.php');
}

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('Location:../login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Profil</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="container">
   <div class="profile">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `forum_users` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['profilepic'] == ''){
            echo '<img src="default-avatar.png">';
         }else{
            echo '<img src="'.$fetch['profilepic'].'">';
         }

      ?>
      <h3><?php echo $fetch['name']; ?></h3>
      <a href="update_profile.php" class="btn">uppdatera profil</a>
      <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a>
   </div>
</div>

</body>
</html>
