<?php include('dbcon.php');

if (isset($_POST['add_new_fund'])) {
    $fund_name = $_POST['add_fund_name'];
    $insert = "INSERT INTO fund_db (fund_name,isActive) VALUES ('$fund_name','TRUE')";
    $run = SQLSRV_QUERY($Con, $insert);
    if ($run) {
        header('Location: ../pages/fund.php');
    }
}
if (isset($_POST['update_fund'])) {
    $fund_name = $_POST['update_fund_name'];
    $id = $_POST['id'];
    $update = "UPDATE fund_db SET fund_name='$fund_name' WHERE id=$id";
    $run = SQLSRV_QUERY($Con, $update);
    if ($run) {
        header('Location: ../pages/fund.php');
    }
}
if (isset($_POST['delete_fund'])) {
    $id = $_POST['delete_fund'];
    $delete = "UPDATE fund_db SET isActive='FALSE' WHERE id='$id'";
    $run = SQLSRV_QUERY($Con, $delete);
    if ($run) {
        echo "Data Successfully Deleted";
        // header('Location:../pages/fund.php');
    }
}
