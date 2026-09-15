<?php
require '../config/database.php';
if($_SERVER['REQUEST_METHOD']=== 'POST')
    {
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $hash_password=password_hash($password, PASSWORD_DEFAULT);
        //echo "process registration";
    
    if (empty($full_name) || empty($username) || empty($email) || empty($password))
        {
            echo "error";
        }
        else {
            //echo "successful";        
            
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    echo "error";
                }
                else
                    {
                        $sql_query='SELECT user_id FROM users WHERE username=? OR email=?';
                       //echo  "continue";
                       $prepared_statement=$mysqli->prepare($sql_query);
                       $prepared_statement->bind_param("ss", $username, $email);
                       $prepared_statement->execute();
                       $result= $prepared_statement->get_result();
                    
                    if($result->num_rows >0)
                        {
                            echo "username || email already exist";
                        }
                        else{
                            echo "No duplicate";
                        }
                        $insert_query='INSERT INTO users(email, username,password,full_name,registration_date,updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())';
                        $insert_statement=$mysqli->prepare($insert_query);
                        $insert_statement->bind_param("ssss", $email, $username, $hash_password, $full_name);
                        //$insert_statement->execute();
                        if($insert_statement->execute())
                            {
                                echo "success messages";
                            }
                            else{
                                echo "error message";
                            }        }
    }
    }
    ?>
    <link rel="stylesheet" href="../assets/style.css">
<div class="form-container">
    <h1>Create Account</h1>

    <form method="POST">

        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Register">

    </form>

    <p>
        Already have an account?
        <a href="login.php">Login</a>
    </p>
</div>

 
