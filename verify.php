<?php
require "_dbconnect.php";
if(isset($_GET['email'])&&($_GET['vcode']))
{
    $email=$_GET['email'];
    $vcode=$_GET['vcode'];
    $query="SELECT * FROM `register_user`  WHERE email ='$email' AND verifi_code='$vcode'";
    $result=mysqli_query($con,$query);
    if($result)
    {
if(mysqli_num_rows($result)==1)
{
    $result_fetch=mysqli_fetch_assoc($result);
    {
        if($result_fetch['is_verifi']==0)
        {
            $res_email=$result_fetch['email'];
            $update="UPDATE `register_user` SET is_verifi='1' WHERE email='$res_email'";
            if(mysqli_query($con,$update))
            {
                echo '<script>
                alert("Email Successfully Verified!!");
                window.location.href="/reg_otp/index.php";
                </script>';
            }
            else
            {
                echo '<script>
                alert("Cannot Run Query");
                window.location.href="/reg_otp/index.php";
                </script>';
            }
        }
        else{
            echo '<script>
        alert("User Alreay Registered");
        window.location.href="/reg_otp/index.php";
        </script>';  
        }
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