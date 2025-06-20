<?php
session_start();
include_once("connection.php");
include_once("functions.php");


$user_data = check_login($con);
if ($user_data['is_admin'] != 1) {
    die("Unauthorized access.");
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

 
    if ($user_id === $user_data['user_id']) {
        echo "You cannot delete yourself.";
        exit;
    }


    $stmt = $con->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();


    header("Location: index.php?page=users");
    exit;
} else {
    echo "Invalid user ID.";
}
?>
