<?php
      include '../components/connection.php';

      session_start();

      if (isset($_POST['login'])) {
            
            $email = $_POST['email'];
            $email = trim($email); // Remove whitespace            
            
            $pass = sha1($_POST['password']);
            $pass = trim($pass); // Remove whitespace 
            
            $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ? AND password =?");
            $select_admin->execute([$email, $pass]);

            if ($select_admin->rowCount() > 0) {
                  $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
                  $_SESSION['admin_id'] = $fetch_admin_id['id'];
                  header('location:dashboard.php');
            }else{
                  $warning_msg[] = 'incorrect username or password';
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
      <title>medicinal plants admin panel - register page</title>
</head>
<body>
      <div class="main">
            <section>
                  <div class="form-container" id="admin_login">
                        <form action="" method="post" enctype="multipart/form-data">
                              <h3>login now</h3>                           
                              <div class="input-field">
                                    <label>user email <sup>*</sup></label>
                                    <input type="email" name="email" maxlength="30" 
                                          required placeholder="Enter your email" 
                                          oninput="this.value = this.value.replace(/\s//g, '')"> 
                              </div>  
                              <div class="input-field">
                                    <label>user password <sup>*</sup></label>
                                    <input type="password" name="password" maxlength="30" 
                                          required placeholder="Enter your password"  
                                          oninput="this.value = this.value.replace(/\s//g, '')"> 
                              </div>                             
                              <button type="submit" name="login" class="btn">login now</button>
                              <p>do not have an account ? <a href="register.php">register now</a></p>
                        </form>
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