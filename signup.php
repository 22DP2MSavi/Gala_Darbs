<?php 
session_start();
include_once("connection.php");
include_once("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $country = $_POST['country'];

    if (
        !empty($user_name) && !empty($password) && !is_numeric($user_name) &&
        !empty($age) && !empty($country)
    ) {
        $user_id = random_num(20);

        $query = "INSERT INTO users (user_id, user_name, password, wins, score) 
                  VALUES ('$user_id', '$user_name', '$password', 0, 0)";
        mysqli_query($con, $query);

        $profile_query = "INSERT INTO profiles (user_id, age, country) 
                          VALUES ('$user_id', '$age', '$country')";
        mysqli_query($con, $profile_query);

        header("Location: login.php");
        die;
    } else {
        $error = "Please enter some valid information!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
<style>
* {
    box-sizing: border-box;
}

html, body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    height: 100%;
    width: 100%;
    background-color: #f4f4f4;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s, color 0.3s;
}


html.dark-mode, html.dark-mode body {
    background-color: #1a1a1a;
    color: #f0f0f0;
}

.container {
    width: 100%;
    max-width: 400px;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    text-align: center;
}

html.dark-mode .container {
    background-color: #2a2a2a;
}

h2 {
    margin-bottom: 20px;
    color: #333;
}

html.dark-mode h2 {
    color: #ffffff;
}

input[type="text"], input[type="password"], input[type="number"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    color: #000;
}

html.dark-mode input {
    background-color: #3a3a3a;
    border: 1px solid #555;
    color: #f0f0f0;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #555;
}

.link {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    color: #666;
}

html.dark-mode .link {
    color: #aaa;
}

.link a {
    color: #007BFF;
    text-decoration: none;
}

html.dark-mode .link a {
    color: #66b2ff;
}

.error {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
</style>


</head>
<body>

<div class="container">
    <h2>Sign Up</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <input type="text" name="user_name" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="text" name="country" placeholder="Country" required>
        <button type="submit">Sign Up</button>
    </form>
    <div class="link">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

<script>
    (function() {
        if (localStorage.getItem('dark-mode') === 'true') {
            document.documentElement.classList.add('dark-mode');
        }
    })();
</script>

</body>
</html>
