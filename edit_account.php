<?php
session_start();
include_once("connection.php");
include_once("functions.php");

$user_data = check_login($con);
$user_id = $user_data['user_id'];

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['username']);
    

    if (!empty($new_username)) {
        $stmt = mysqli_prepare($con, "UPDATE users SET user_name = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $new_username, $user_id);
        mysqli_stmt_execute($stmt);
        $success_message = "Username updated successfully.";
        $_SESSION['user_name'] = $new_username;
    }

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($con, "UPDATE users SET password = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $hashed_password, $user_id);
        mysqli_stmt_execute($stmt);
        $success_message .= " Password updated successfully.";
    }

    if (empty($new_username) && empty($new_password)) {
        $error_message = "Please fill in at least one field.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Account</title>
    <script>
      if (localStorage.getItem('dark-mode') === 'true') {
          document.documentElement.classList.add('dark-mode');
      }
    </script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: white;
            color: black;
        }

        .dark-mode html, .dark-mode body {
            background-color: #121212;
            color: #f0f0f0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #f4f4f4;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        .dark-mode .container {
            background-color: #1e1e1e;
            color: #f0f0f0;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            width: 80%;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .dark-mode input[type="text"],
        .dark-mode input[type="password"] {
            background-color: #2a2a2a;
            color: white;
            border: 1px solid #666;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 15px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .dark-mode .success {
            color: #66ff66;
        }

        .dark-mode .error {
            color: #ff6666;
        }
    </style>
</head>
<body>
    <?php include("navbar.php"); ?>

    <div class="container">
        <h1>Edit Your Account</h1>

        <?php if ($success_message): ?>
            <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="New Username">
          
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
