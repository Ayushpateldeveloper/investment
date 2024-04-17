<?php
include('dbcon.php');

if (isset($_POST['script_id_fetch'])) {
    $script_id = $_POST['script_id_fetch'];

    $sql = "SELECT * FROM script_db WHERE id = '$script_id'";
    $run = sqlsrv_query($Con, $sql);
    $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

    $data = $row['sector'];

    echo $data;
}

if (isset($_POST['script_id_table'])) {
    $script_id = $_POST['script_id_table'];

    $table_display = "SELECT * FROM buy_db WHERE script_id = '$script_id'";
    $run = sqlsrv_query($Con, $table_display);
    // echo $table_display;
    $data = array();
    while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        $row['entry_date'] = $row['entry_date']->format('Y-m-d');

        $data[] = $row;
    }

    // print_r($data);
    // $run1 = sqlsrv_query($Con, $table_display);
    // echo $data;
    echo json_encode($data);
}

if (isset($_POST['add_buy'])) {
    // Retrieve form data
    $script_name = $_POST['script_name'];
    $script_id = $_POST['script_id'];
    $sector = $_POST['sector'];
    $entryDate = $_POST['entry_date'];
    $quantity = $_POST['quantity'];
    $entryPrice = $_POST['entry_price'];
    $amount = $_POST['amount'];
    $brokerage = $_POST['brokerage'];
    $totalBrokerage = $_POST['total_brokerage'];
    $totalAmount = $_POST['total_amount'];


    // Prepare SQL query
    $sql = "INSERT INTO buy_db ( initial_buy,script_name,script_id, sector, entry_date, quantity, entry_price, amount, brokerage, total_brokerage, total_amount,isSell)
            VALUES ('$quantity','$script_name','$script_id','$sector', '$entryDate', '$quantity', '$entryPrice', '$amount', '$brokerage', '$totalBrokerage', '$totalAmount','FALSE')";
    $stmt = sqlsrv_query($Con, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Display any errors if query execution fails
    } else {
        // $sql_fetch_id = "SELECT MAX(id) as buy_id FROM buy_db";
        // $run1 = SQLSRV_QUERY($Con, $sql_fetch_id);
        // $result = SQLSRV_FETCH_ARRAY($run1, SQLSRV_FETCH_ASSOC);
        // $buy_id = $result['buy_id'];
        // echo $buy_id;

        // $sql1 = "INSERT INTO sell_db (buy_id,buy_qty,script_name,script_id,sector,entry_price) VALUES ('$buy_id','$quantity','$script_name','$script_id','$sector','$entryPrice')";
        // echo $sql1;
        // $run = SQLSRV_QUERY($Con, $sql1);
        header('Location:../pages/buy-sell.php');
        echo "Record inserted successfully."; // Output success message
    }
}
if (isset($_POST['add_sell'])) {
    // Retrieve form data
    $script_name = $_POST['script_name_sell'];
    $script_id = $_POST['script_id'];
    $buy_initial_qty = $_POST['buy_initial_qty'];
    $sector = $_POST['sector'];
    $entryDate = $_POST['entry_date'];
    $sell_qty = $_POST['sell_qty'];
    $entryPrice = $_POST['entry_price'];
    $exitPrice = $_POST['exit_price'];
    $amount = $_POST['amount'];
    $brokerage = $_POST['brokerage'];
    $totalBrokerage = $_POST['total_brokerage'];
    $totalAmount = $_POST['total_amount'];
    $buy_id = $_POST['buy_id'];
    $buy_initial_qty = $_POST['buy_initial_qty'];
    $profit_loss = $totalAmount - $entryPrice * $sell_qty;

    //testing
    echo "0. Script Name :" . $script_name .
        "<br>" . "1. Script Id :" . $script_id .
        "<br>" . "2. Sector :" . $sector .
        "<br>" . "3. Entry Date : " . $entryDate .
        "<br>" . "4. Initial Quantity : " . $buy_initial_qty .
        "<br>" . "5. Quantity : " . $sell_qty .
        "<br>" . "6. Entry Price" . $entryPrice .
        "<br>" . "7. Exit Price" . $exitPrice .
        "<br>" . "8. Amount :" . $amount .
        "<br>" . "9. Brokerage" . $brokerage .
        "<br>" . "10. Total Brokerage : " . $totalBrokerage .
        "<br>" . "11. Total Amount :" . $totalAmount .
        "<br>" . "12. Buy Id :" . $buy_id .
        "<br>" . "13. Profit_loss :" . $profit_loss .
        "<br>";

    // Prepare SQL query
    $sql = "INSERT INTO sell_db (buy_id,exit_price, script_name,script_id, sector, entry_date,buy_qty, sell_qty, entry_price, amount, brokerage, total_brokerage, total_amount,profit_loss)
            VALUES ('$buy_id','$exitPrice','$script_name','$script_id','$sector', '$entryDate','$buy_initial_qty', '$sell_qty', '$entryPrice', '$amount', '$brokerage', '$totalBrokerage', '$totalAmount','$profit_loss')";

    $stmt = sqlsrv_query($Con, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Display any errors if query execution fails
    } else {
        $updated_quantity = $buy_initial_qty - $sell_qty;

        $update_buy_qty = "UPDATE buy_db set quantity='$updated_quantity', isSell='TRUE' WHERE id='$buy_id'";
        // echo $update_buy_qty;
        // die();
        // echo $update_buy_qty;
        $run2 = SQLSRV_QUERY($Con, $update_buy_qty);
        header('Location:../pages/buy-sell.php');
        echo "Record inserted successfully."; // Output success message
    }
}
if (isset($_POST['buy_id'])) {
    $buy_id = $_POST['buy_id'];

    $table_display = "SELECT * FROM sell_db WHERE buy_id = '$buy_id' AND sell_qty IS NOT NULL";

    $run = sqlsrv_query($Con, $table_display);

    if ($run === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $data = array();

    while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        // Convert datetime object to string
        $row['entry_date'] = $row['entry_date'] ? $row['entry_date']->format('Y-m-d') : null;

        // Add each row to the data array
        $data[] = $row;
    }

    // Encode the data array to JSON and send it as response
    echo json_encode($data);
}
