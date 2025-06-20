<?php 
session_start();
include_once("connection.php");
include_once("functions.php");

if (isset($_GET['page']) && $_GET['page'] == 'scoreboard') {
    $score_query = "SELECT user_name, wins, score FROM users ORDER BY score DESC";

    $score_result = mysqli_query($con, $score_query);
}

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html>

<head>
     <script>
    if (localStorage.getItem('dark-mode') === 'true') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>
  <title>My Website</title>

    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: white;
    color: black;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
}

table th, table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}

table th {
    background-color: #333;
    color: white;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}


th a {
    color: white;
    text-decoration: none;
    display: inline-block;
    padding: 8px 12px;
    background-color: #444;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}
th a:hover {
    background-color: #666;
}


.dark-mode body {
    background-color: #121212;
    color: #ffffff;
}

.dark-mode table {
    background-color: #1e1e1e;
    color: #ffffff;
}

.dark-mode table th {
    background-color: #333;
    color: white;
}

.dark-mode table td {
    color: #eee;
}

.dark-mode table tr:nth-child(even) {
    background-color: #2a2a2a;
}
h1, h2 {
    text-align: center;
}

.dark-mode table tr:nth-child(odd) {
    background-color: #1e1e1e;
}

.dark-mode th a {
    background-color: #444;
    color: white;
}
.dark-mode th a:hover {
    background-color: #666;
}

</style>

</head>
<body>
    

<?php include("navbar.php"); ?>

<div style="padding: 20px;">
    <div class="content">
<?php
$page = $_GET['page'] ?? '';

if ($page == 'play') {
    echo "<h1>Game is under construction</h1>";

}   elseif ($page == 'scoreboard') {
    echo "<h1>Scoreboard</h1>";


$query = "SELECT user_name, wins, score FROM users";


    $result = mysqli_query($con, $query);

    $users_raw = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users_raw[$row['user_name']] = $row; 
    }


    $users_for_placing = array_values($users_raw); 
    usort($users_for_placing, fn($a, $b) => $b['score'] <=> $a['score']);
    foreach ($users_for_placing as $index => &$user) {
        $user['placing'] = $index + 1;
    }


    $final_users = [];
    foreach ($users_for_placing as $user) {
        $final_users[$user['user_name']] = $user;
    }


    $users_sorted = array_values($final_users);
    $sort = $_GET['sort'] ?? 'score';

    if ($sort === 'username') {
        usort($users_sorted, fn($a, $b) => strcmp($a['user_name'], $b['user_name']));
    } elseif ($sort === 'wins') {
        usort($users_sorted, fn($a, $b) => $b['wins'] <=> $a['wins']);
    } elseif ($sort === 'score') {
        usort($users_sorted, fn($a, $b) => $b['score'] <=> $a['score']);
    }


    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>Placing</th>
<th><a href='?page=scoreboard&sort=username'>Username</a></th>
<th><a href='?page=scoreboard&sort=wins'>Wins</a></th>
<th><a href='?page=scoreboard&sort=score'>Score</a></th>

            </tr>";

    foreach ($users_sorted as $user) {
        echo "<tr>
                <td>{$user['placing']}</td>
                <td>" . htmlspecialchars($user['user_name']) . "</td>
                <td>{$user['wins']}</td>
                <td>{$user['score']}</td>
              </tr>";
    }

    echo "</table>";









} elseif ($page == 'profiles') {
    include("profiles.php");

} elseif ($page == 'contact') {
    echo "<h1>Contact</h1>";
    echo "<h3>+371 28334617</h3>";
    echo "<h3>RVT_Dzins@gmail.com</h3>";

} elseif ($page == 'users' && $user_data['is_admin'] == 1) {
    include("admin.php");

} elseif ($page == 'edit_user' && $user_data['is_admin'] == 1) {
    include("edit_user.php");

} else {
    echo "<h1>Welcome, " . htmlspecialchars($user_data['user_name']) . "</h1>";
}
?>
</div>

</body>
</html>
