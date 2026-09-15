<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: auth/login.php");
    exit();
}
   require 'config/database.php';
   if($_SERVER['REQUEST_METHOD']=== 'POST')
    {

       $amount=$_POST['amount'];
        $income_date=$_POST['income_date'];
        $income_category=$_POST['income_category'];
        $description=$_POST['description'];
        $user_id=$_SESSION['user_id'];

      $sql_query = "INSERT INTO income
                  (user_id, amount, income_date, income_category, description)
                  VALUES (?, ?, ?, ?, ?)";

    $prepared_statement = $mysqli->prepare($sql_query);

    $prepared_statement->bind_param(
        "idsss",
        $user_id,
        $amount,
        $income_date,
        $income_category,
        $description
    );
    

    if($prepared_statement->execute())
    {
        echo "Income added successfully!";
    }
    else
    {
        echo "Error adding income.";
    }
}
?>
<div class="form-container">
<h1>Add Income</h1>
<form method="POST">
    Amount:<input type="number" name="amount"><br><br>
    Income Date:<input type="date" name="income_date"><br><br>
    Income Category:<input type="text" name="income_category"><br><br>
    Description:<input type="text" name="description"><br><br>
    <input type="submit" value="Add Income">
    <hr><hr>

</form>
</div>
<br>
<a href="dashboard.php">Back to Dashboard</a>
<link rel="stylesheet" href="assets/style.css">

 