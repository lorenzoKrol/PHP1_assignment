<?php
// cookies
$cookie_name = "user";
$cookie_value = "A person";
setcookie($cookie_name, $cookie_value, time() + (86400), "/");
//session
session_start();
$_SESSION["error"]="";
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>PHP assignment</h2>
  <a href="log_out.php" class="btn">Sign Out of Your Account</a>
  <a href="reset_password.php" class="btn">reset password</a>
<br>
<?php
try{
  $imagesDir = 'images/';

  $images = glob($imagesDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

  $randomImage = $images[array_rand($images)];
}
catch(Exception $e){
   echo "oops, something went wrong with finding a picture. Please try again later.";
}

?>
<img class="center" src="<?php echo $randomImage; ?>">
<form>
  <button class="button" onClick="refreshPage()">New Picture</button>
</form>
</body>
</html>
