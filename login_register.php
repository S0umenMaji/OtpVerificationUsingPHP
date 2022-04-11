<?php 
require '_dbconnect.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($e_mail,$vcode)
{
    require "PHPMailer/PHPMailer.php";
    require "PHPMailer/Exception.php";
    require "PHPMailer/SMTP.php";
    $mail = new PHPMailer(true);
    try {
        //Server settings
   
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'samplemail808080@gmail.com';                     //SMTP username
        $mail->Password   = 'Password Here';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('samplemail808080@gmail.com', 'Coding Buddy');
        $mail->addAddress($e_mail);     //Add a recipient
       
    
      
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email Verification || Coding Buddy';
        $mail->Body    = "Thanks For Registration!!!
        Please Verify Your Email Address by clicking <a href='http://localhost/reg_otp/verify.php?email=$e_mail&vcode=$vcode'>Verify</a>";
 
    
        $mail->send();
       return true;
    } catch (Exception $e) {
        return false;
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }



}

// for login
if(isset($_POST["login"]))
{
    $emai_user=$_POST['email_username'];
    $log_password=$_POST['password'];
    $query = "SELECT * FROM `register_user`  WHERE username='$emai_user' OR email='$emai_user'";
    $result=mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['is_verifi']==1)
            {
                if(password_verify($log_password,$result_fetch['password']))
                {
                    $_SESSION['logged_in']=true;
                    $_SESSION['username']=$result_fetch['username'];
                    header("Location: /reg_otp/index.php");
                }
                else
                {
        echo '<script>
                alert("Incorrect Password");
                window.location.href="/reg_otp/index.php";
                </script>';
                }
    
            }
            else{
                echo '<script>
                alert("Email Not Verified");
                window.location.href="/reg_otp/index.php";
                </script>';
            }
            
        }
        else
        {
            echo '<script>
            alert("Email or Username not Registered");
            window.location.href="/reg_otp/index.php";
            </script>';
        }
    }
    else
    {
        echo '<script>
        alert("Cannot  run query");
        window.location.href="/reg_otp/index.php";
        </script>';
    }
}

// for registration
if(isset($_POST['register']))
{
    $fullname=$_POST['fullname'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $pass=$_POST['password'];
    $user_exists_query = "SELECT * FROM `register_user`  WHERE username='$username' OR email='$email'";
    $result=mysqli_query($con,$user_exists_query);
    if($result)
    {

    if(mysqli_num_rows($result)>0)
    {
    $result_fetch = mysqli_fetch_assoc($result);
    if($result_fetch['username']==$_POST['username'])
    {
        echo '<script>
        alert("Username '.$result_fetch['username'] .  ' already Taken");
        window.location.href="/reg_otp/index.php";
        </script>' ;
    }else
    {
        echo '<script>
        alert("Email '.$result_fetch['email'] .  ' already registered");
        window.location.href="/reg_otp/index.php";
        </script>';
    }

    }
    else{
        $password=password_hash($pass,PASSWORD_BCRYPT);
        $v_code=bin2hex(random_bytes(16));
    $query="INSERT INTO `register_user`(`full_name`, `username`, `email`, `password`, `verifi_code`, `is_verifi`) VALUES ('$fullname','$username','$email','$password','$v_code','0')";
    if(mysqli_query($con,$query) && sendMail($email,$v_code))
    {

        echo "<script>
        alert('Registration Successfull!!!');
        window.location.href='/reg_otp/index.php';
    
        </script>";

    }
    else
    {
        echo '<script>
        alert("SERVER DOWN");
        window.location.href="/reg_otp/index.php";
        
        </script>';
    }

    }



    }
    else
    {
        echo '<script>
        alert("Cannot  run query");
        window.location.href="/reg_otp/index.php";
        </script>';
    }
}

?>