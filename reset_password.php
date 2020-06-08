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

<form action= "password_reset_db.php" method="post">
  New Password:<br>
  <input type="password" name="Password_New1" placeholder="new password"> <br>
  Confirm Password:<br>
  <input type="password" name="Password_New2" placeholder="confirm password">
  <br><br>
  <input type="submit" value="Submit">
</form>
<p class="error"> <?php echo $_SESSION["error"]; ?> </p>

</body>
</html>
