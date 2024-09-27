<?php
include_once '../components/connection.php';
include_once '../components/function.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: login.php');
    exit; // Çıkış yapın, böylece başka bir kod çalışmaz
}

// Ürün silme işlemi
if (isset($_POST['delete'])) {
    $p_id = $_POST['product_id'];

    // Veritabanında silme işlemi
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    if ($delete_product->execute([$p_id])) {
        $success_msg[] = "Product deleted successfully";
    } else {
        $error_msg[] = "Error deleting product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Medicinal Plants Admin Panel - All Products Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>All Products</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span>All Products</span>
        </div>
        <section class="show-post">
            <h1 class="heading">All Products</h1>
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();

                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">

                        <?php if ($fetch_products['image'] != '') { ?>
                            <img src="../image/<?= htmlspecialchars($fetch_products['image']); ?>" class="image">
                        <?php } ?> 

                        <div class="status" style="color: <?= $fetch_products['status'] === 'active' ? 'green' : 'red'; ?>;">
                            <?= htmlspecialchars($fetch_products['status']); ?>
                        </div> 

                        <div class="price"><?= htmlspecialchars($fetch_products['price']); ?>/-</div>
                        <div class="title"><?= htmlspecialchars($fetch_products['name']); ?></div>

                        <div class="flex-btn">
                            <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">Edit</a>
                            <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                            <a href="read_product.php?post_id=<?= $fetch_products['id']; ?>" class="btn">View</a>
                        </div>
                    </form>
                <?php
                    }
                } else {
                    echo '<div class="empty"><p>No product added yet! <br> <a href="add_products.php" class="btn">Add Product</a></p></div>';
                }
                ?>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
