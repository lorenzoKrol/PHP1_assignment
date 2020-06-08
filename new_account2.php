<?php
require_once "connect.php";
// show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Define variables and initialize with empty values
$email = $password1 = $password2 = "";
$email_err = $password1_err = $password2_err = "";
session_start();
// Processing form data when form is submitted
try{
  if($_SERVER["REQUEST_METHOD"] == "POST"){

      // Validate username
      if(empty(trim($_POST["Email"]))){
          $_SESSION["error"] = "Please enter a email.";
          header("location: new_account1.php");
          exit;
      } else{
          // Prepare a select statement
          $sql = "SELECT email FROM Account WHERE email = ?";

          if($stmt = $mysqli->prepare($sql)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("s", $param_email);

              // Set parameters
              $param_email = trim($_POST["Email"]);

              // Attempt to execute the prepared statement
              if($stmt->execute()){
                  // store result
                  $stmt->store_result();

                  if($stmt->num_rows == 1){
                      $_SESSION["error"] = "This email already has an account.";
                      header("location: new_account1.php");
                      exit;
                  } else{
                      $email = trim($_POST["Email"]);
                  }
              } else{
                  $_SESSION["error"] = "Oops! Something went wrong. Please try again later.";
                  header("location: new_account1.php");
                  exit;
              }
          }

          // Close statement
          $stmt->close();
      }

      // Validate password
      if(empty(trim($_POST["Password1"]))){
          $_SESSION["error"] = "Please enter a password.";
          header("location: new_account1.php");
          exit;
      } elseif(strlen(trim($_POST["Password1"])) < 6){
          $_SESSION["error"] = "Password must have atleast 6 characters.";
          header("location: new_account1.php");
          exit;
      } else{
          $password1 = trim($_POST["Password1"]);
      }

      // Validate confirm password
      if(empty(trim($_POST["Password2"]))){
          $_SESSION["error"] = "Please confirm password.";
          header("location: new_account1.php");
          exit;
      } else{
          $password2 = trim($_POST["Password2"]);
          if(empty($password1_err) && ($password1 != $password2)){
              $_SESSION["error"] = "Password did not match.";
              header("location: new_account1.php");
              exit;
          }
      }

      // Check input errors before inserting in database
      if(empty($email_err) && empty($password1_err) && empty($password2_err)){

          // Prepare an insert statement
          $sql = "INSERT INTO Account (email, password) VALUES (?, ?)";

          if($stmt = $mysqli->prepare($sql)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("ss", $param_email, $param_password);

              // Set parameters
              $param_email = $email;
              $param_password = password_hash($password1, PASSWORD_DEFAULT); // Creates a password hash

              // Attempt to execute the prepared statement
              if($stmt->execute()){
                  // Redirect to login page
                  header("location: log_in1.php");
              } else{
                  $_SESSION["error"] = "Something went wrong. Please try again later.";
                  header("location: new_account1.php");
                  exit;
              }
          }

          // Close statement
          $stmt->close();
      }

      // Close connection
      $mysqli->close();

      //no errors
      $_SESSION["error"] = "";
  }
}
catch(Exception $e){
  $_SESSION["error"] = "Something went wrong. Please try again later.";
  header("location: new_account1.php");
  exit;
}
?>
