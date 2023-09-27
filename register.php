<?php

    @include 'php/config.php';

    session_start();

    $passwordErrorMsg = '';

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
                    
        //verify the unique email
        $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email = '$email'");
        if(mysqli_num_rows($verify_query) !=0){
            $error[] = 'This email is used. Please try another email.';
        } else{
            // Client-side password validation
            $isValidPassword = true;
            $requirements = [
                '/.{8,}/' => 'At least 8 characters length',
                '/[0-9]/' => 'At least 1 number (0...9)',
                '/[a-z]/' => 'At least 1 lowercase letter (a...z)',
                '/[A-Z]/' => 'At least 1 uppercase letter (A...Z)',
            ];

            foreach ($requirements as $regex => $message) {
                if (!preg_match($regex, $password)) {
                    $isValidPassword = false;
                    $passwordErrorMsg .= $message . '<br>';
                }
            }

            if ($isValidPassword) {
                // Insert the user data into the database
                mysqli_query($con, "INSERT INTO users(Username, Email, Password) VALUES('$username', '$email', '$password')") or die("Error Occured");
                header('location:index.php');
            }
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
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>
            <form action="" method="post" onsubmit="return validateForm()">
                <?php
                    if(isset($error)){
                        foreach($error as $error){
                            echo '<span class="error-msg" style="color: red; background-color: #fde8ec; padding: 10px; display: block; transform: translateY(-20px); 
                                border: 1px solid #af4242; margin-top: 20px; margin-bottom: 5px; font-size: 14px; text-align: center;">'
                                .$error.'</span>';
                        }
                    } else if (!empty($passwordErrorMsg)) {
                        echo '<span class="error-msg" style="color: red; background-color: #fde8ec; padding: 10px; display: block; transform: translateY(-20px); 
                            border: 1px solid #af4242; margin-top: 20px; margin-bottom: 5px; font-size: 14px; text-align: center;">'
                            .$passwordErrorMsg.'</span>';
                    }
                ?>
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="pass-field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div class="content">
                    <p>Password must contain:</p>
                    <ul class="requirement-list">
                        <li>
                            <i class="fa-solid fa-circle"></i>
                            <span>At least 8 characters length</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle"></i>
                            <span>At least 1 number (0...9)</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle"></i>
                            <span>At least 1 lowercase letter (a...z)</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle"></i>
                            <span>At least 1 uppercase letter (A...Z)</span>
                        </li>
                    </ul>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Sign Up" required>
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Login Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>