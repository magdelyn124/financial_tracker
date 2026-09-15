<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: auth/login.php");
    exit();
}

require 'config/database.php';

$user_id = $_SESSION['user_id'];

$sql_query = "
    SELECT income_date AS transaction_date,
           'Income' AS transaction_type,
           income_category AS category,
           amount,
           description
    FROM income
    WHERE user_id = ?

    UNION ALL

    SELECT expense_date AS transaction_date,
           'Expense' AS transaction_type,
           expense_category AS category,
           amount,
           description
    FROM expenses
    WHERE user_id = ?

    ORDER BY transaction_date DESC
";

$statement = $mysqli->prepare($sql_query);

$statement->bind_param("ii", $user_id, $user_id);

$statement->execute();

$result = $statement->get_result();
?>
<link rel="stylesheet" href="assets/style.css">
<div class="container">
<h1>Transaction History</h1>

<table border="1" cellpadding="8">

<tr>
    <th>Date</th>
    <th>Type</th>
    <th>Category</th>
    <th>Amount</th>
    <th>Description</th>
</tr>

<?php
while($row = $result->fetch_assoc())
{
?>

<tr>
    <td><?php echo $row['transaction_date']; ?></td>
    <td><?php echo $row['transaction_type']; ?></td>
    <td><?php echo $row['category']; ?></td>
    <td>₹<?php echo $row['amount']; ?></td>
    <td><?php echo $row['description']; ?></td>
</tr>

<?php
}
?>

</table>
</div>
<br>

<a href="dashboard.php">Back to Dashboard</a>