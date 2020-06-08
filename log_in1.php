<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>PHP assignment</h2>

<form action= "log_in2.php" method="post">
  Email:<br>
  <input type="email" name="Email" placeholder="email">
  <br>
  Password:<br>
  <input type="password" name="Password" placeholder="password">
  <br><br>
  <input type="submit" value="Submit">
</form>
<p class="error"> <?php echo $_SESSION["error"]; ?> </p>
<p>Want to make an account? click <a href="new_account1.php">here</a></p>

</body>
</html>
