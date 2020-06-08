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

<form action= "new_account2.php" method="post">
  Email:<br>
  <input type="email" name="Email" placeholder="email">
  <br>
  Password:<br>
  <input type="password" name="Password1" placeholder="password">
  <br>
  Check password<br>
  <input type="password" name="Password2" placeholder="check password">
  <br><br>
  <input type="submit" value="Submit">

</form>
<p class="error"> <?php echo $_SESSION["error"]; ?> </p>
</body>
</html>
