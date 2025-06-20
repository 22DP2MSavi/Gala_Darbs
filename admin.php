<?php

$query = "SELECT users.user_id, users.user_name, users.wins, users.score, users.password,
                 profiles.country, profiles.age
          FROM users
          LEFT JOIN profiles ON users.user_id = profiles.user_id
          WHERE users.user_id != '" . $user_data['user_id'] . "'";

$result = mysqli_query($con, $query);
?>

<h1 style="text-align: center;">Manage Users</h1>

<style>
    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #333;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .edit-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .edit-btn:hover {
        background-color: #45a049;
    }
</style>

<table>
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Wins</th>
        <th>Score</th>
        <th>Password</th>
        <th>Country</th>
        <th>Age</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
            <td><?php echo $row['wins']; ?></td>
            <td><?php echo $row['score']; ?></td>
            <td><?php echo htmlspecialchars($row['password']); ?></td>
            <td><?php echo htmlspecialchars($row['country']); ?></td>
            <td><?php echo $row['age']; ?></td>
            <td>
                <a href="?page=edit_user&id=<?php echo $row['user_id']; ?>">
                    <button class="edit-btn">Edit</button>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
