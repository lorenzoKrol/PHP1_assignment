<?php
//show errors

session_start();
// Include config file
require_once "connect.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
try{
  if($_SERVER["REQUEST_METHOD"] == "POST"){
      session_start();
      // Check if username is empty
      if(empty(trim($_POST["Email"]))){
          $_SESSION["error"] = "Please enter username.";
          header("location: log_in1.php");
          exit;
      } else{
          $email = trim($_POST["Email"]);
      }

      // Check if password is empty
      if(empty(trim($_POST["Password"]))){
          $_SESSION["error"] = "Please enter your password.";
          header("location: log_in1.php");
          exit;
      } else{
          $password = trim($_POST["Password"]);
      }

      // Validate credentials
      if(empty($email_err) && empty($password_err)){
          // Prepare a select statement
          $sql = "SELECT email, password FROM Account WHERE email = ?";

          if($stmt = $mysqli->prepare($sql)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("s", $param_email);

              // Set parameters
              $param_email = $email;

              // Attempt to execute the prepared statement
              if($stmt->execute()){
                  // Store result
                  $stmt->store_result();

                  // Check if username exists, if yes then verify password
                  if($stmt->num_rows == 1){
                      // Bind result variables
                      $stmt->bind_result($email, $hashed_password);
                      if($stmt->fetch()){
                          if(password_verify($password, $hashed_password)){



                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $email;

                              // Redirect user to welcome page
                              header("location: index.php");
                          } else{
                              // Display an error message if password is not valid
                              $_SESSION["error"] = "The password you entered was not valid.";
                              header("location: log_in1.php");
                              exit;
                          }
                      }
                  } else{
                      // Display an error message if username doesn't exist
                      $_SESSION["error"] = "No account found with that username.";
                      header("location: log_in1.php");
                      exit;
                  }
              } else{
                  $_SESSION["error"] = "Oops! Something went wrong. Please try again later.";
                  header("location: log_in1.php");
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
  $_SESSION["error"] = "Oops! Something went wrong. Please try again later.";
  header("location: log_in1.php");
  exit;
}
?>
