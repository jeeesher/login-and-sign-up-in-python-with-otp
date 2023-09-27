<?php

    @include 'php/config.php';
    use PHPMailer\PHPMailer\PHPMailer;

    session_start();

    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($con,$_POST['email']);
        $password = mysqli_real_escape_string($con,$_POST['password']);

        $result = mysqli_query($con,"SELECT * FROM users WHERE Email='$email' AND Password='$password'");
        $row = mysqli_fetch_assoc($result);

        // Function to generate a random OTP
        function generateOTP() {
            return rand(1000, 9999);
        }

        if(is_array($row) && !empty($row)){
            $_SESSION['valid'] = $row['Email'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['id'] = $row['Id'];

            // Generate a random OTP
            $otp = generateOTP();
            $_SESSION['otp'] = $otp;

            // Store the OTP in the database
            $updateOtpQuery = "UPDATE users SET otp = $otp WHERE Email = '$email'";
            mysqli_query($con, $updateOtpQuery);

            // Send OTP via email
            require "vendor/autoload.php";
            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';

            $mail->Username = 'email@gmail.com'; // Replace with your email
            $mail->Password = 'password'; // Replace with your email password

            $mail->setFrom('email@gmail.com', 'OTP Verification');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Your verification code";
            $mail->Body = "<p>Dear user, </p> <h3>Your verification OTP code is $otp <br></h3>
            <br><br>
            <p>With regards,</p>
            <b>Admin</b>
            Login_Signup";

            if ($mail->send()) {
                // Email sent successfully, proceed to OTP verification
                header('location: verify.php'); // Redirect to OTP verification page
                exit;
            } else {
                // Email sending failed
                $error[] = 'Failed to send OTP via email. Please try again.';
            }
        } else{
            $error[] = 'Invalid Email or Password';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="script.js" defer></script>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="" method="post">
                <?php
                    if(isset($error)){
                        foreach($error as $error){
                            echo '<span class="error-msg" style="color: red; background-color: #fde8ec; padding: 10px; display: block; transform: translateY(-20px); 
                                border: 1px solid #af4242; margin-top: 20px; margin-bottom: 5px; font-size: 14px; text-align: center;">'
                                .$error.'</span>';
                        }
                    }
                ?>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="pass-field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
