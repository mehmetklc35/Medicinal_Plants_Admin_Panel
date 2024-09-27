<?php
      include '../components/connection.php';

      session_start();

      $admin_id = $_SESSION['admin_id'];

      if (!isset($admin_id)) {
            header('location: login.php');
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
      <title>medicinal plants admin panel - register user's page</title>
</head>
<body>
      <?php include '../components/admin_header.php'; ?>
      <div class="main">
            <div class="banner">
                  <h1>register user's</h1>
            </div>
            <div class="title2">
                  <a href="dashboard.php">dashboard</a><span> / register user's</span>
            </div>
            <section class="accounts">
                  <h1 class="heading">register user's</h1>
                  <div class="box-container">
                        <?php 
                              $select_users = $conn->prepare("SELECT * FROM `users`");
                              $select_users->execute();

                              if ($select_users->rowCount() > 0) {
                                    while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
                                          $user_id = $fetch_users['id'];

                        ?>
                        <div class="box">
                              <p>user id : <span><?= $user_id; ?></span></p>
                              <p>user name : <span><?= isset($fetch_users['name']) ? $fetch_users['name'] : 'Tanımsız'; ?></span></p>
                              <p>user email : <span><?= isset($fetch_users['email']) ? $fetch_users['email'] : 'Tanımsız'; ?></span></p>
                        </div>
                        <?php 
                                    }
                              }else{
                                    echo '
                                          <div class="empty">
                                                <p>no user registered yet! </p>
                                          </div>   
                                    ';         
                              }              
                        ?>                        

                  </div>
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