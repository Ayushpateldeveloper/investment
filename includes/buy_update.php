<?php
include('dbcon.php');

if (isset($_POST['add_buy_update'])) {
    $buy_id = $_POST['buy_id'];
    $script_name = $_POST['script_name'];
    $script_id = $_POST['script_id'];
    $sector = $_POST['sector'];
    $entryDate = $_POST['entry_date'];
    $initial_buy = $_POST['quantity'];
    $quantity = $_POST['quantity'];
    $entryPrice = $_POST['entry_price'];
    $amount = $_POST['amount'];
    $brokerage = $_POST['brokerage'];
    $totalBrokerage = $_POST['total_brokerage'];
    $totalAmount = $_POST['total_amount'];

    date_default_timezone_set('Asia/Kolkata');
    $updatedAt = date('Y-m-d H:i:s');

    // Prepare the SQL update query
    $update_query = "UPDATE buy_db SET script_name=?, script_id=?, sector=?, entry_date=?, initial_buy=?, quantity=?, entry_price=?, amount=?, brokerage=?, total_brokerage=?, total_amount=?, updatedAt=? WHERE id=?";
    $params = array($script_name, $script_id, $sector, $entryDate, $initial_buy, $quantity, $entryPrice, $amount, $brokerage, $totalBrokerage, $totalAmount, $updatedAt, $buy_id);

    // Execute the SQL update query
    $stmt = sqlsrv_prepare($Con, $update_query, $params);
    if ($stmt === false) {
        // Handle SQL error
        echo "SQL Error: " . sqlsrv_errors();
    } else {
        // Execute the prepared statement
        if (sqlsrv_execute($stmt)) {
            header('Location:../pages/buy-sell.php');
            exit; // Ensure script termination after redirection
        } else {
            // Handle execution error
            echo "Error executing query: " . print_r(sqlsrv_errors(), true);
        }
    }
}
