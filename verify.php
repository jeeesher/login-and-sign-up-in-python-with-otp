<?php 
    @include 'php/config.php';

    session_start();

    if(isset($_POST["submit"])){
        $otp = $_SESSION['otp'];
        $email = $_SESSION['valid'];
        $otp_code = $_POST['otp_code'];

        if($otp != $otp_code){
            $error[] = 'Invalid OTP code. Try again.';
        }else{
            mysqli_query($con, "UPDATE users SET status = 1 WHERE Email = '$email'");
            
            header('location: home.php');
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
        <title>Verify</title>
    </head>
    <body>
        <div class="container">
            <div class="box form-box">
                <header>Verify Your Account</header>
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
                        <label for="otp" style="text-align: center;">Enter the four digit code we sent to your email.</label>
                        <input type="text" name="otp_code" id="otp" autocomplete="off" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Verify Now" required>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>