<?php      
      session_start();
      include 'components/connection.php';    

      if (isset($_POST['register'])) {

            $id = unique_id();

            $name = $_POST['name'];
            $name = trim($name); // Remove whitespace          
            
            $email = $_POST['email'];
            $email = trim($email); // Remove whitespace            
            
            $pass = sha1($_POST['password']);
            $pass = trim($pass); // Remove whitespace         

            $cpass = sha1($_POST['cpassword']);
            $cpass = trim($cpass); // Remove whitespace            

            $image = $_FILES['image']['name']; // Yüklenen dosyanın adı
            $image_tmp_name = $_FILES['image']['tmp_name']; // Geçici dosya adı
            $image_folder = '../image/' . basename($image); // Hedef dizin

            $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
            $select_admin->execute([$email]);

            if ($select_admin->rowCount() > 0) {
                  $warning_msg[] = 'User email already exists';            
            }else{                  
                  if ($pass !== $cpass) {
                      $warning_msg[] = 'Confirm password does not matched'; 
                  }else{
                      // Prepare the SQL statement
                      $insert_admin = $conn->prepare("INSERT INTO `admin` (id, name, email, 
                        password, profile) VALUES (?, ?, ?, ?, ?)");                      
                      // Execute the statement with the provided values
                      $insert_admin->execute([$id, $name, $email, $cpass, $image]);                      
                  }
                  if (move_uploaded_file($image_tmp_name, $image_folder)) {
                        $success_msg[] = 'User registered successfully';
                  } else {
                        $warning_msg[] = 'Failed to upload profile picture';
                  }    
                      
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
                              <h3>register now</h3>
                              <div class="input-field">
                                    <label>user name <sup>*</sup></label>
                                    <input type="text" name="name" maxlength="30" 
                                          required placeholder="Enter your username" 
                                          oninput="this.value = this.value.replace(/\//g, '')"> 
                              </div>

                              <div class="input-field">
                                    <label>user email <sup>*</sup></label>
                                    <input type="email" name="email" maxlength="30" 
                                          required placeholder="Enter your email" 
                                          oninput="this.value = this.value.replace(/\//g, '')"> 
                              </div>

                              <div class="input-field">
                                    <label>user password <sup>*</sup></label>
                                    <input type="password" name="password" maxlength="30" 
                                          required placeholder="Enter your password" 
                                          oninput="this.value = this.value.replace(/\s//g, '')"> 
                              </div>

                              <div class="input-field">
                                    <label>confirm password <sup>*</sup></label>
                                    <input type="password" name="cpassword" maxlength="30" 
                                          required placeholder="Enter your confirm password" 
                                          oninput="this.value = this.value.replace(/\s//g, '')"> 
                              </div>

                              <div class="input-field">
                                    <label>select profile <sup>*</sup></label>
                                    <input type="file" name="image" accept="image/*">                                     
                              </div>

                              <button type="submit" name="register" class="btn">register now</button>
                              <p>already have an account ? <a href="login.php">login now</a></p>

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