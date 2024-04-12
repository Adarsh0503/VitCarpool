<?php
session_start();
require_once "db_config.php";

$fullname = $email = $password = $confirm_password = "";
$fullname_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["fullname"]))) {
        $fullname_err = "Please enter your full name.";
    } else {
        $fullname = trim($_POST["fullname"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        } else {
            $email = trim($_POST["email"]);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
            echo 'Password did not match.';
        }
    }

    if (empty($fullname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {

            $stmt->bind_param("sss", $param_fullname, $param_email, $param_password);
            $param_fullname = $fullname;
            $param_email = $email;
            $param_password = $password; // Store the plaintext password

            if ($stmt->execute()) {
                header("location: login.html");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }   
            $stmt->close();
        }
    }
    $mysqli->close();
}
?>
