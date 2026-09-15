<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: auth/login.php");
    exit();
}

require 'config/database.php';

$user_id = $_SESSION['user_id'];

$income_query = "SELECT COALESCE(SUM(amount), 0) AS total_income
                 FROM income
                 WHERE user_id = ?";

$income_statement = $mysqli->prepare($income_query);
$income_statement->bind_param("i", $user_id);
$income_statement->execute();

$income_result = $income_statement->get_result();
$income_data = $income_result->fetch_assoc();

$total_income = $income_data['total_income'];


$expense_query = "SELECT COALESCE(SUM(amount), 0) AS total_expenses
                  FROM expenses
                  WHERE user_id = ?";

$expense_statement = $mysqli->prepare($expense_query);
$expense_statement->bind_param("i", $user_id);
$expense_statement->execute();

$expense_result = $expense_statement->get_result();
$expense_data = $expense_result->fetch_assoc();

$total_expenses = $expense_data['total_expenses'];


$balance = $total_income - $total_expenses;
?>
<link rel="stylesheet" href="assets/style.css">
<div class="container">
<h1>Financial Tracker Dashboard</h1>
<h2>Welcome to your Financial Tracker</h2>

<div class="card-container">
     <div class="card">
     <h3>Total Income: </h3>
     <p>₹<?php echo $total_income; ?></p>
        </div>
        <div class="card">
      
         <h3>Total Expenses:</h3>
            <p>₹<?php echo $total_expenses; ?></p>
        </div>
         <div class="card">
        <h3>Current Balance:</h3>
            <p>₹<?php echo $balance; ?></p>
        </div>
  </div>

<br>
 <div class="nav">

<a href="income.php">Add Income</a>

<br><br>

<a href="expense.php">Add Expense</a>

<br><br>

<a href="transactions.php">Transaction History</a>

 <a href="logout.php">Logout</a>
 </div>

</div>
