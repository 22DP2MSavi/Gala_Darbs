<?php
if (!isset($user_data)) {
    session_start();
    include_once("connection.php");
    include_once("functions.php");
    $user_data = check_login($con);
}
?>

<style>
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
}


.navbar {
    background-color:rgb(228, 228, 228);
    padding: 12px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.dark-mode .navbar {
    background-color: #1e1e1e;
}


.navbar a, .dropbtn {
    color: #333;
    padding: 16px 20px;
    text-decoration: none;
    font-weight: 500;
    border-radius: 6px;
    transition: background-color 0.3s ease;
    border: none;
    background: none;
    font-size: 22px;
    font-weight: bold;
}

.navbar a:hover, .dropbtn:hover {
    background-color:rgb(168, 168, 168);
}

.dark-mode .navbar a, 
.dark-mode .dropbtn {
    color: #f0f0f0;
}

.dark-mode .navbar a:hover, 
.dark-mode .dropbtn:hover {
    background-color: #2a2a2a;
}


.navbar-left, .navbar-right {
    display: flex;
    align-items: center;
    gap: 10px;
}


.dropdown {
    position: relative;
    display: inline-block;
}
.dropdown:hover .dropdown-content,
.dropdown:focus-within .dropdown-content {
    display: block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%; 
    background-color: #ffffff;
    min-width: 160px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
    z-index: 1001;
    transition: opacity 0.2s ease;
}

.dark-mode .dropdown-content {
    background-color: #1e1e1e;
}

.dropdown-content a {
    color: #333;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    transition: background-color 0.3s;
}

.dropdown-content a:hover {
    background-color: #f5f5f5;
}

.dark-mode .dropdown-content a {
    color: #f0f0f0;
}

.dark-mode .dropdown-content a:hover {
    background-color: #2a2a2a;
}

.dropdown:hover .dropdown-content {
    display: block;
}


#darkModeBtn {
    margin-left: 15px;
    padding: 10px 14px;
    font-size: 14px;
    background-color: #eee;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

#darkModeBtn:hover {
    background-color: #ddd;
}

.dark-mode #darkModeBtn {
    background-color: #333;
    color: #f0f0f0;
}

.dark-mode #darkModeBtn:hover {
    background-color: #444;
}
</style>


<div class="navbar">
    <div class="navbar-left">
        <a href="/login/index.php?page=play">Play</a>
        <a href="/login/index.php?page=scoreboard">Scoreboard</a>
        <a href="/login/index.php?page=contact">Contact</a>
        <?php if ($user_data['is_admin'] == 1): ?>
            <a href="/login/index.php?page=users">Users</a>
        <?php endif; ?>
    </div>
    <div class="navbar-right">
        <div class="dropdown">
            <button class="dropbtn">Profile ▼</button>
            <div class="dropdown-content">
                <a href="/login/profile.php">Profile</a>
                <a href="/login/logout.php">Log out</a>
            </div>
        </div>
        <button onclick="toggleDarkMode()" id="darkModeBtn">Dark Mode</button>
    </div>
</div>

<script>
function toggleDarkMode() {
    const isDark = document.documentElement.classList.toggle('dark-mode');
    localStorage.setItem('dark-mode', isDark);
}

(function() {
    if (localStorage.getItem('dark-mode') === 'true') {
        document.documentElement.classList.add('dark-mode');
    }
})();
</script>
