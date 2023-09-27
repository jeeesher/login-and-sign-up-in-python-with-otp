<?php
    session_start();

    include("php/config.php");
?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script
            src="https://kit.fontawesome.com/64d58efce2.js"
            crossorigin="anonymous"
        ></script>
        <title>Home</title>
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="center-container">
            <div class="nav">
                <div class="right-links">
                    <a href="php/logout.php"> <button class="btn nav">Log Out</button></a>
                </div>
            </div>
        </div>
        
        <main>
            <section id="banner">
                <div class="section">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="welcome">Hello <b class="name"><span><?php echo $_SESSION['username']; ?></span></b>, Welcome!</p>
                            <p class="quote">"If you're on a rocky wave, just feel the breeze and let your body go with the flow. When the wind dies and the waves calm down one day you'll be standing on the sea."</p>
                            <p class="author"><b>~ SEVENTEEN, Vernon</b></p>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="img/welcome.svg" class="img-fluid">
                        </div>
                    </div>
                </div>
                <img src="img/wave1.png" class="bottom-img">
            </section>
        </main>

    </body>
</html>