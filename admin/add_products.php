<?php
      include '../components/connection.php';

      session_start();

      $admin_id = $_SESSION['admin_id'];

      if (!isset($admin_id)) {
            header('location: login.php');
      }

      //add product in database

      if (isset($_POST['publish'])) {
            $id = unique_id();

            $name = $_POST['name'];
            $name = trim($name);            
            
            $price = $_POST['price'];
            $price = trim($price);
            
            $content = $_POST['content'];
            $content = trim($content);

            $status = 'active';

            $image = $_FILES['image']['name'];
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = '../image/'.$image;

            $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
            $select_image->execute([$image]);

            if (isset($image)) {
                  if ($select_image->rowCount() > 0) {
                        $warning_msg[] = "Image name repeated";
                  }elseif ($image_size > 2000000) {
                        $warning_msg[] = "Image size is too large";
                  }else{
                        move_uploaded_file($image_tmp_name, $image_folder);
                  }
            }else{
                  $image ='';
            }
            if ($select_image->rowCount() > 0 AND $image != '') {
                  $warning_msg[] = "please rename your image";
            }else{
                  $insert_product = $conn->prepare("INSERT INTO `products`(id, name, price, image, product_detail, status) VALUES(?,?,?,?,?,?)");
                  $insert_product->execute([$id, $name, $price, $image, $content, $status]);
                  $success_msg[] = 'product inserted successfully!';
            }
      }

      //sava product in database as draft

      if (isset($_POST['draft'])) {
            $id = unique_id();

            $name = $_POST['name'];
            $name = trim($name);            
            
            $price = $_POST['price'];
            $price = trim($price);
            
            $content = $_POST['content'];
            $content = trim($content);

            $status = 'active';

            $image = $_FILES['image']['name'];
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = '../image/'.$image;

            $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
            $select_image->execute([$image]);

            if (isset($image)) {
                  if ($select_image->rowCount() > 0) {
                        $warning_msg[] = "Image name repeated";
                  }elseif ($image_size > 2000000) {
                        $warning_msg[] = "Image size is too large";
                  }else{
                        move_uploaded_file($image_tmp_name, $image_folder);
                  }
            }else{
                  $image ='';
            }
            if ($select_image->rowCount() > 0 AND $image != '') {
                  $warning_msg[] = "please rename your image";
            }else{
                  $insert_product = $conn->prepare("INSERT INTO `products`(id, name, price, image, product_detail, status) VALUES(?,?,?,?,?,?)");
                  $insert_product->execute([$id, $name, $price, $image, $content, $status]);
                  $success_msg[] = 'product saved as draft successfully!';
            }
      }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- boxicon cdn links -->
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
      <title>medicinal plants admin panel - add products page</title>
</head>
<body>
      <?php include '../components/admin_header.php'; ?>
      <div class="main">
            <div class="banner">
                  <h1>add products</h1>
            </div>
            <div class="title2">
                  <a href="dashboard.php">dashboard</a><span>add products</span>
            </div>
            <section class="form-container">
                  <h1 class="heading">add products</h1>
                  <form action="" method="post" enctype="multipart/form-data">
                        <div class="input-field">
                              <label>product name <sup>*</sup></label>
                              <input type="text" name="name" maxlength="100" required placeholder="add product name">
                        </div>
                        <div class="input-field">
                              <label>product price <sup>*</sup></label>
                              <input type="number" name="price" maxlength="100" required placeholder="add product name">
                        </div>
                        <div class="input-field">
                              <label>product detail <sup>*</sup></label>
                              <textarea name="content" required maxlength="10000" required placeholder="write product descpription"></textarea>
                        </div>
                        <div class="input-field">
                              <label>product image <sup>*</sup></label>
                              <input type="file" name="image" accept="image/*" required> 
                        </div>
                        <div class="flex-btn">
                              <button type="submit" name="publish" class="btn">publish product</button>
                              <button type="submit" name="draft" class="btn">save as draft</button>
                        </div>

                  </form>
            </section>

            
      </div>

      <!-- sweetalert cdn links -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
      <!-- custom js links -->
      <script type="text/javascript" src="script.js"></script>
      <!-- alert -->
      <?php include '../components/alert.php'; ?>
</body>
</html>