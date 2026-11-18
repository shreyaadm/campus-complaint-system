<?php include "db.php"; ?>
<h2>Register</h2>
<form method="POST">
  Name: <input type="text" name="name" required><br><br>
  Email: <input type="email" name="email" required><br><br>
  Password: <input type="password" name="password" required><br><br>
  <button type="submit" name="register">Register</button>
</form>

<?php
if(isset($_POST['register'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $sql = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$pass')";
  if(mysqli_query($conn, $sql)){
    echo "Register Success!";
  } else {
    echo "Error!";
  }
}
?>
<a href="login.php">Already have account? Login</a>