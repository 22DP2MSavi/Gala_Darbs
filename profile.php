<?php
session_start();
include_once("connection.php");
include_once("functions.php");

$user_data = check_login($con);
$user_id = $user_data['user_id'];


$query = "SELECT users.user_name, profiles.age, profiles.country 
          FROM users 
          LEFT JOIN profiles ON users.user_id = profiles.user_id 
          WHERE users.user_id = '$user_id' 
          LIMIT 1";

$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $profile = mysqli_fetch_assoc($result);
} else {
    $profile = ['user_name' => $user_data['user_name'], 'age' => 'N/A', 'country' => 'N/A'];
}


$success_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_name'])) {
    $new_name = trim($_POST['new_name']);
    if (!empty($new_name)) {
        $query = "UPDATE users SET user_name = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "si", $new_name, $user_id);
        mysqli_stmt_execute($stmt);

        $success_message = "Name updated successfully!";
        $profile['user_name'] = $new_name;
        $user_data['user_name'] = $new_name;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
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

  .profile-info {
      text-align: left;
      font-size: 17px;
      margin-top: 20px;
  }

  .profile-info p {
      margin: 8px 0;
  }

  .profile-info strong {
      width: 100px;
      display: inline-block;
  }

  input[type="text"] {
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
      width: 60%;
  }

  .dark-mode input[type="text"] {
      background-color: #2a2a2a;
      color: white;
      border: 1px solid #666;
  }

  button {
      margin-top: 25px;
      padding: 10px 18px;
      font-size: 16px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
  }

  button:hover {
      background-color: #45a049;
  }

  .success {
      margin-top: 15px;
      color: green;
  }

  .dark-mode .success {
      color: #66ff66;
  }
</style>

</head>
<body>
    <?php include("navbar.php"); ?>

    <div class="container">
        <h1>Your Profile</h1>

        <div class="profile-info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($profile['user_name']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($profile['age']); ?></p>
            <p><strong>Country:</strong> <?php echo htmlspecialchars($profile['country']); ?></p>
        </div>

        <a href="edit_account.php">
            <button>Edit Account</button>
        </a>
    </div>
</body>
</html>
