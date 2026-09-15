<?php
session_start();
require '../config/database.php';
if($_SERVER['REQUEST_METHOD']=== 'POST')
    {
$login_identifier=$_POST['login_identifier'];
$password=$_POST['password'];

$sql_query='SELECT user_id, password FROM users WHERE username=? OR email=?';
$prepared_statement=$mysqli->prepare($sql_query);
$prepared_statement->bind_param("ss", $login_identifier, $login_identifier);
$prepared_statement->execute();
$result= $prepared_statement->get_result();
 if($result->num_rows >0)
                        {
                            $user=$result->fetch_assoc();
                            if(password_verify($password, $user['password']))
                                {
                                    $_SESSION['user_id']=$user['user_id'];
                                    header("Location: ../dashboard.php");
                                     exit();
                                    //echo "Login successful";
                                }
                                else{
                                    echo "Invalid username/email or password";
                                }
                            //echo "continue with password verification";
                        }
                        else{
                            echo "Invalid username/email or password";
                        }    





}



?>
<link rel="stylesheet" href="../assets/style.css">
<div class="form-container">
    <h1>Login</h1>

    <form method="POST">
        <label>Username or Email:</label>
        <input type="text" name="login_identifier" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Login">
    </form>

    <p>
        Don't have an account?
        <a href="register.php">Register</a>
    </p>
</div>
