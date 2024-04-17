<?php include('dbcon.php');
session_start();
if (isset($_POST['btn_login'])) {

    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $sql = "SELECT user_id, password FROM user_db where user_id='$user_id' AND password='$password'";
    $run = sqlsrv_query($Con, $sql);
    $query = sqlsrv_query($Con, $sql, array(), array("Scrollable" => 'static'));
    $count = sqlsrv_num_rows($query);
    echo $select;
    echo $count;

    if ($count == '1') {
        $run1 = sqlsrv_query($Con, $sql);
        $row = SQLSRV_FETCH_ARRAY($run1, SQLSRV_FETCH_ASSOC);

        echo "User Login Successfully";
        $_SESSION['user_id'] = $row['user_id'];
        header('location:../pages/home.php');
    }
}
if (isset($_GET['action']) == 'logout') {
    session_unset();
    session_destroy();
    header('location:../pages/login.php');
}
