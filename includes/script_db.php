<?php
include('dbcon.php');

if (isset($_POST['add_new_script'])) {

    $script_name = $_POST['script_name'];
    $fund_id = $_POST['fund_id'];
    $sector = $_POST['sector'];
    $sub_sector = $_POST['sub_sector'];
    $insert = "INSERT INTO script_db (name,fund_id,sector,sub_sector,isActive) VALUES('$script_name','$fund_id','$sector','$sub_sector','1')";
    $run = SQLSRV_QUERY($Con, $insert);
    if ($run) {
        header('Location:../pages/script.php');
    } else {
        echo "<script>alert('Script Not Added');</script>";
    }
}
if (isset($_POST['update_script'])) {
    date_default_timezone_set('Asia/Kolkata');
    $current_time = date('Y-m-d H:i:s');
    echo $current_time;
    $script_name = $_POST['script_name'];
    $id = $_POST['id'];
    $fund_id = $_POST['fund_id'];
    $sector = $_POST['sector'];
    $sub_sector = $_POST['sub_sector'];
    $update = "UPDATE script_db SET name='$script_name' , fund_id='$fund_id' , sector='$sector' , sub_sector='$sub_sector' , updatedAt='$current_time'  WHERE id=$id";
    $run = SQLSRV_QUERY($Con, $update);
    if ($run) {
        echo "<script>alert('Script Updated Successfully');</script>";
        header('Location:../pages/script.php');
    }
}
if (isset($_POST['delete_script'])) {
    $id = $_POST['delete_script'];
    $delete = "UPDATE script_db SET isActive='FALSE' WHERE id='$id'";
    $run = SQLSRV_QUERY($Con, $delete);
    if ($run) {
        echo "Data Successfully Deleted";
        // header('Location:../pages/script.php');
    }
}
