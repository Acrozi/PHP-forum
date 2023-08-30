<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once ('db.php');

function validateData($data)
{
    $resultData = htmlspecialchars(stripslashes(trim($data)));
    return $resultData;
}

if (isset($_POST['action']) && $_POST['action'] == 'registration') {
    $first_name = validateData($_POST['firstName']);
    $email_id = validateData($_POST['emailId']);
    $password = validateData($_POST['password']);
    $confirm_password = validateData($_POST['confirmPassword']);
    $profilepic = './UserProfilePic/user-avatar.png';
    $user_group = '2';

    $error_message = '';
    $checkEmailQuery = $conn->prepare("select * from forum_users where email = ?");
    $checkEmailQuery->bind_param("s", $email_id);
    $checkEmailQuery->execute();


    $result = $checkEmailQuery->get_result();
    if ($result->num_rows > 0) {

        $error_message = "Email adress är upptagen!";
        echo $error_message;
    } else {
        $insertQuery = $conn->prepare("insert into forum_users(name,email,password,profilepic,usergroup) values(?,?,?,?,?)");
        $password = md5($password);
        $insertQuery->bind_param("sssss", $first_name, $email_id, $password, $profilepic, $user_group);

        if ($insertQuery->execute()) {
            echo "Du har skapat ett konto. Du kommer att skicas till login sidan om 3 sekunder";
            exit();
        } else {
            $error_message = "error";
        }
        $insertQuery->close();
        $conn->close();

        echo $error_message;
    }
}

// if (isset($_POST['action']) && $_POST['action'] == 'login') {
//     $emailId = validateData($_POST['emailId']);
//     $password = validateData($_POST['password']);
//     $password = md5($password);
//     $error_message = '';
//
//     $selectQuery = $conn->prepare("select * from forum_users where email = ? and password = ?");
//     $selectQuery->bind_param("ss", $emailId, $password);
//     $selectQuery->execute();
//
//     $result = $selectQuery->get_result();
//
//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $_SESSION['username'] = $row['first_name'] . " " . $row['last_name'];
//             require_once "dashboard.php";
//             exit();
//         } // endwhile
//     } // endif
// else {
//         $error_message = "error";
//     } // endElse
//     $conn->close();
//
//     echo $error_message;
// }
?>
