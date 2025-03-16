<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../connection.php';

$db = new Database();
$pdo = $db->getConnection();

  
$query = "SELECT id, username, email, role, room_id, image_url FROM users where role = 'user'";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link rel="stylesheet" href="../styles/allUsers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <style>
    body {
        position: relative;
        background: url("../assets/images/background.jpg") no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        height: 100vh;
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;

    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);

        z-index: 1;
    }

    body>* {
        position: relative;
        z-index: 2;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #343a40;
        color: white;
        padding: 20px;
        position: fixed;
        left: 0;
        top: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .admin-section {
        display: flex;
        align-items: center;
        margin-top: 20px;
    }

    .admin-section img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .admin-section span {
        color: #fff;
        font-size: 16px;
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
    }

    .nav-links ul {
        list-style: none;
        padding: 0;
        width: 100%;
    }

    .nav-links li {
        margin: 10px 0;
    }

    .nav-links a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: white;
        background: #495057;
        border-radius: 5px;
        text-align: center;
        transition: 0.3s;
    }

    .nav-links a:hover {
        background: #17a2b8;
    }




    .container {
        margin-left: 350px;
        margin-top: 100px;

        padding: 20px;
        max-width: 1000px;

        margin-right: auto;

    }

    table {
        width: 100%;
        max-width: 100%;

        table-layout: fixed;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;

    }

    th,
    td {
        padding: 8px;

        text-align: left;
        word-wrap: break-word;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #343a40;
        color: white;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    td img {
        max-width: 40px;

        height: auto;
        display: block;
        border-radius: 50%;
    }

    .actions {
        white-space: nowrap;
    }

    .actions a {
        margin: 0 5px;
        color: #343a40;
        transition: 0.3s;
    }

    .actions a:hover {
        color: #17a2b8;
    }

    .sidebar .brand {
        font-size: 24px;
        margin-bottom: 20px;
    }

    #logout-btn {
        width: 100%;
        height: 50px;
        margin-top: 10px;
        background: #dc3545;
        color: white;
        border: none;
        cursor: pointer;

        border-radius: 20px;
    }

    b #logout-btn:hover {
        background: #c82333;
    }
    </style>

    <div class="sidebar">
        <div class="admin-section">
            <?php if (isset($_SESSION['admin_photo']) && isset($_SESSION['admin_name'])): ?>
            <img src="../assets/images/<?php echo $_SESSION['admin_photo']; ?>" alt="Admin Photo">
            <span><?php echo $_SESSION['admin_name']; ?></span>
            <?php else: ?>
            <span>Admin</span>
            <?php endif; ?>
        </div>

        <nav class="nav-links">
            <ul>
                <li><a href="admin.php">Make Order</a></li>
                <li><a href="addproduct.php">Add Product</a></li>
                <li><a href="showproduct.php">Show Products</a></li>
                <li><a href="Allusers.php">Show Users</a></li>
                <li><a href="add-user.php">Add User</a></li>
                <li><a href="admin_orders.php">Show Orders</a></li>
            </ul>
        </nav>



        <button id="logout-btn" class="btn">Logout</button>
    </div>
    <?php
       $query = "SELECT id, name FROM rooms";
       $stmt = $pdo->prepare($query);
       $stmt->execute();
       $rooms = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);?>
    <div class="container">
        <h2>Users Management</h2>
        <div class="button-container">
            <button class="button" onclick="window.location.href='add-user.php'">Add User</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Room</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><?= htmlspecialchars($rooms[$user['room_id']] ?? '') ?></td>
                    <td>
                        <img src="../assets/images/<?= htmlspecialchars($user['image_url'] ?? 'default-avatar.png') ?>"
                            alt="User Image">
                    </td>
                    <td>
                        <a href="edit-user.php?id=<?= $user['id'] ?>" class="edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="#" class="delete" data-id="<?= $user['id'] ?>">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="../scripts/main.js">
    </script>
    <script>
    document.getElementById('logout-btn').addEventListener('click', () => {
        fetch('logout.php', {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.php';
                } else {
                    showAlert('Logout failed. Please try again.', 'danger');
                }
            })
            .catch(error => console.error('Error logging out:', error));
    });
    </script>
</body>

</html>