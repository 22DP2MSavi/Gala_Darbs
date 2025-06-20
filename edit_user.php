<?php
if (!isset($_GET['id'])) {
    echo "<p>User ID not provided.</p>";
    return;
}

$user_id = $_GET['id'];


$query = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>User not found.</p>";
    return;
}

$user = mysqli_fetch_assoc($result);


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['delete'])) {
  
        $delete_query = "DELETE FROM users WHERE user_id = '$user_id'";
        mysqli_query($con, $delete_query);
        echo "<script>window.location.href='?page=users';</script>";
        exit;
    } else {

        $wins = intval($_POST['wins']);
        $score = intval($_POST['score']);

        $update_query = "UPDATE users SET wins = '$wins', score = '$score' WHERE user_id = '$user_id'";
        mysqli_query($con, $update_query);

        echo "<script>window.location.href='?page=users';</script>";
        exit;
    }
}
?>

<style>
    .edit-form-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 25px;
        background-color:rgb(233, 233, 233);
        border-radius: 10px;
        color: black;
        font-family: Arial, sans-serif;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
    }
    .dark-mode .edit-form-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 25px;
        background-color:rgb(39, 39, 39);
        border-radius: 10px;
        color: white;
        font-family: Arial, sans-serif;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
    }

    .edit-form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .edit-form-container label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    .edit-form-container input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: none;
        background: white;
        color: black;
    }
     .dark-mode .edit-form-container input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: none;
        background: gray;
        color: white;
    }

    .edit-form-container .button-row {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .edit-form-container button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .edit-form-container .save-btn {
        background-color: #4CAF50;
        color: white;
    }

    .edit-form-container .save-btn:hover {
        background-color: #45a049;
    }

    .edit-form-container .delete-btn {
        background-color: crimson;
        color: white;
    }

    .edit-form-container .delete-btn:hover {
        background-color: darkred;
    }
</style>

<div class="edit-form-container">
    <h2>Edit User</h2>
    <form method="post">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['user_name']); ?></p>

        <label for="wins">Wins:</label>
        <input type="number" name="wins" id="wins" value="<?php echo $user['wins']; ?>" required>

        <label for="score">Score:</label>
        <input type="number" name="score" id="score" value="<?php echo $user['score']; ?>" required>

        <div class="button-row">
            <button type="submit" class="save-btn">Save</button>
            <button type="submit" name="delete" class="delete-btn"
                onclick="return confirm('Are you sure you want to delete this user?')">
                Delete
            </button>
        </div>
    </form>
</div>
