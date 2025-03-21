<?php
    require("../connection2.php");
    $connection = new db();
    $data=$connection->getCategory();
    $categories = $data->fetchAll(PDO::FETCH_ASSOC);
    $dataPro = $connection->getOneProduct($_GET['id']);
    $product = $dataPro->fetch(PDO::FETCH_ASSOC);
    // echo "<pre>";
    // var_dump($product['name']);
    // echo "</pre>";
    // var_dump($categories[0]['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Document</title>
</head>

<?php include 'header.php'; ?>

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
        text-align: center;
        margin-bottom: 20px;
    }

    .admin-section img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        margin-bottom: 10px;
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

    .cart-section {
        margin-top: auto;
        text-align: center;
        padding-bottom: 20px;
    }

    .cart-icon {
        font-size: 24px;
        cursor: pointer;
        position: relative;
    }

    .cart-counter {
        position: absolute;
        top: -5px;
        right: -10px;
        background: red;
        color: white;
        font-size: 14px;
        border-radius: 50%;
        padding: 2px 6px;
    }

    #logout-btn {
        width: 100%;
        margin-top: 10px;
        background: #dc3545;
        color: white;
        border: none;
    }

    #logout-btn:hover {
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

        <!-- <div class="cart-section">
            <div class="cart-icon" id="cart-icon">
                🛒
                <span class="cart-counter" id="cart-counter">0</span>
            </div>
        </div> -->

        <button id="logout-btn" class="btn">Logout</button>
    </div>
    <h1 class="h1 text-center pt-5">Edit Product</h1>
    <div class="form container py-5 d-flex justify-content-center ">
        <form action="update.php" method="post" enctype="multipart/form-data" class="w-75">
            <input required type="hidden" name="id" value="<?=$product['id']?>">
            <div class="mb-3">
                <label style="color:white" for="name" class="form-label">Product</label>
                <input required type="text" class="form-control" name="name" value="<?=$product['name']?>"
                    placeholder="Prodact Name">
            </div>
            <div class="mb-3">
                <label style="color:white" for="description" class="form-label">Description</label>
                <input required type="text" class="form-control" name="description" value="<?=$product['description']?>"
                    placeholder="Prodact Name">
            </div>
            <div class="mb-3">
                <label style="color:white" for="price" class="form-label">Price</label>
                <input required type="number" class="form-control" name="price" value="<?=$product['price']?>"
                    placeholder="Prodact Name">
            </div>

            <div class="mb-3">
                <label style="color:white" for="category_id" class="form-label">Category</label>
                <select class="form-select" aria-label="Default select example" name="category_id">
                    <option disabled>Select Category</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']); ?>"
                        <?= ($category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($category['name']); ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if ($product['image_url']): ?>
            <div class="mb-2">
                <img src="../assets/images/<?= $product['image_url']; ?>" alt="Product Image" width="150">
            </div>
            <?php endif; ?>

            <div class="mb-3">
                <label style="color:white" for="image_url" class="form-label">Product picture</label>
                <input required class="form-control" type="file" name="image_url" value="<?=$product['image_url']?>">
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <!-- <button type="reset" class="btn btn-danger">Cancel</button> -->
        </form>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
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
    <script src="../scripts/script.js"></script>
</body>

</html>