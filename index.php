
<?php 
require "_dbconnect.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration-Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h2>SAMPLE_REGISTRATION_And_OTP</h2>
        <nav>
            <a href="#">HOME</a>
        <a href="#">BLOG</a>
        <a href="#">ABOUT</a>
        <a href="#">CONTACT</a>
        </nav>
        <?php
        if(isset($_SESSION['logged_in'])&& $_SESSION['logged_in']==true)
        {
            echo
            "<div class='user'>". $_SESSION['username']." - <a href='logout.php'>LOGOUT</a>
            </div>";
        }
        else{
echo  "<div class='sign-in-up'>
<button type='button' onclick=\"popup('login-popup')\">LOGIN</button>
<button  type='button' onclick=\"popup('register-popup')\">REGISTER</button>
</div>";
        }
        ?>
      
    </header>
    <div class="popup-container" id="login-popup">
        <div class=" popup">
            <form action="login_register.php" method="POST">
                <h2><span>USER LOGIN</span>
                <button type="reset" onclick="popup('login-popup')">X</button>
                </h2>
                <input type="text" placeholder="Email or Username" name="email_username">
                <input type="password" placeholder="Password" name="password">
                <button class="login-btn" type="submit" name="login">LOGIN</button>
            </form>
        </div>
    </div>
    <div class="popup-container" id="register-popup">
        <div class="register popup">
        <form action="login_register.php" method="POST">
                <h2><span>USER REGISTER</span>
                <button type="reset" onclick="popup('register-popup')">X</button>
                </h2>
                <input type="text" placeholder="Full Name" name="fullname">
                <input type="text" placeholder="Username(Must be Unique)" name="username">
                <input type="email" placeholder="Email" name="email">
                <input type="password" placeholder="Password" name="password">
                <button class="register-btn" type="submit" name="register">REGISTER</button>
            </form>
        </div>
    </div>

<?php
if(isset($_SESSION['logged_in'])&& $_SESSION['logged_in']==true)
{
echo "<h1 style='text-align:center; margin-top:200px'>Welcome To this Website - ".$_SESSION['username']."</h1>";
}

?>


    <script>
        function popup(popup_name)
        {
          get_popup=document.getElementById(popup_name);
          if(get_popup.style.display=="flex")
          {
            get_popup.style.display="none";
            
          }
          else
          {
            get_popup.style.display="flex";
          }
        }
      </script>
</body>

</html>