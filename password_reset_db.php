<?php
//show errors

// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: log_in1.php");
    exit;
}

// Include config file
require_once "connect.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
try{
  if($_SERVER["REQUEST_METHOD"] == "POST"){

      // Validate new password
      if(empty(trim($_POST["Password_New1"]))){
          $_SESSION["error"] = "Please enter the new password.";
      } elseif(strlen(trim($_POST["Password_New1"])) < 6){
          $_SESSION["error"] = "Password must have atleast 6 characters.";
          header("location: reset_password.php");
          exit;
      } else{
          $new_password = trim($_POST["Password_New1"]);
      }

      // Validate confirm password
      if(empty(trim($_POST["Password_New2"]))){
          $_SESSION["error"] = "Please confirm the password.";
          header("location: reset_password.php");
          exit;
      } else{
          $confirm_password = trim($_POST["Password_New2"]);
          if(empty($new_password_err) && ($new_password != $confirm_password)){
              $_SESSION["error"] = "Password did not match.";
              header("location: reset_password.php");
              exit;
          }
      }

      // Check input errors before updating the database
      if(empty($new_password_err) && empty($confirm_password_err)){
          // Prepare an update statement
          $sql = "UPDATE Account SET password = ? WHERE email = ?";

  //echo "Password set to database";

          if($stmt = mysqli_prepare($mysqli, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "si", $param_password, $param_email);

              // Set parameters
              $param_password = password_hash($new_password, PASSWORD_DEFAULT);
              $param_email = $_SESSION["id"];

              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt)){
                  // Password updated successfully. Destroy the session, and redirect to login page
                  session_destroy();
                  header("location: log_in1.php");
                  exit();
              } else{
                  $_SESSION["error"] = "Oops! Something went wrong. Please try again later.";
                  header("location: reset_password.php");
                  exit;
              }
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }

      // Close connection
      mysqli_close($mysqli);

      //no errors
      $_SESSION["error"] = "";
  }
}
catch(Exception $e){
  $_SESSION["error"] = "Oops! Something went wrong. Please try again later.";
  header("location: reset_password.php");
  exit;
}
?>
