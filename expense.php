<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: auth/login.php");
    exit();
}

require 'config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
   $amount = $_POST['amount'] ?? null;
$expense_date = $_POST['expense_date'] ?? null;
$expense_category = $_POST['expense_category'] ?? null;
$description = $_POST['description'] ?? '';

$user_id = $_SESSION['user_id'];

    $sql_query = "INSERT INTO expenses
                  (user_id, amount, expense_date, expense_category, description)
                  VALUES (?, ?, ?, ?, ?)";

    $prepared_statement = $mysqli->prepare($sql_query);

    $prepared_statement->bind_param(
        "idsss",
        $user_id,
        $amount,
        $expense_date,
        $expense_category,
        $description
    );

    if($prepared_statement->execute())
    {
        echo "Expense added successfully!";
    }
    else
    {
        echo "Error adding expense.";
    }
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="form-container">

<h1>Add Expense</h1>

<form method="POST">

Amount:
<input type="number" step="0.01" name="amount" required>
<br><br>

Expense Date:
<input type="date" name="expense_date" required>
<br><br>

Expense Category:
<select name="expense_category" required>
<option value="Food">Food</option>
<option value="Transportation">Transportation</option>
<option value="Rent">Rent</option>
<option value="Personal">Personal</option>
<option value="Entertainment">Entertainment</option>
<option value="Other">Other</option>
</select>
<br><br>

Description:
<input type="text" name="description">
<br><br>

<input type="submit" value="Add Expense">

</form>

<br>

<a href="dashboard.php">Back to Dashboard</a>

</div>