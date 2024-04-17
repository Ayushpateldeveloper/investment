<?php
include('../includes/dbcon.php');
$script_id_fetch = $_POST['selectedScriptId'];

// $calculate = "SELECT SUM(entry_price) as entry_price,SUM(exit_price) as exit_price FROM sell_db";
// $calculate_run = SQLSRV_QUERY($Con, $calculate);
// $calculate_result = SQLSRV_FETCH_ARRAY($calculate_run, SQLSRV_FETCH_ASSOC);
// $Sum = $calculate_result['exit_price'] - $calculate_result['entry_price'];
// echo $Sum;

$select = "SELECT DISTINCT buy_id as buy_id FROM sell_db WHERE script_id ='$script_id_fetch'";
// echo $select;
$select_run = SQLSRV_QUERY($Con, $select);
// $sum = 0;
while ($select_result = SQLSRV_FETCH_ARRAY($select_run, SQLSRV_FETCH_ASSOC)) {
    $buyID = $select_result['buy_id'];
    $display_outer = "SELECT b.initial_buy,b.amount as b_amount ,b.total_amount as b_total_amount,s.* FROM sell_db AS s FULL JOIN buy_db AS b ON s.buy_id = b.id Where s.buy_id='$buyID'";
    $run_outer = SQLSRV_QUERY($Con, $display_outer);
    if ($row_outer = SQLSRV_FETCH_ARRAY($run_outer, SQLSRV_FETCH_ASSOC)) {
        $result = $row_outer['buy_id'];

?>
        <tr>
            <td><?= $row_outer['script_name'] ?></td>
            <td><?= $row_outer['sector'] ?></td>
            <td style="width: 190px;"><?= $row_outer['entry_date']->format('Y-m-d') ?></td>
            <td><?= $row_outer['initial_buy'] ?></td>
            <td><?= $row_outer['entry_price'] ?></td>
            <td><?= $row_outer['b_amount'] ?></td>
            <td><?= $row_outer['b_total_amount'] ?></td>
            <!-- <td><?= $result ?></td> -->
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php

        $display_inner = "SELECT s.* FROM sell_db AS s FULL JOIN buy_db AS b ON s.buy_id = b.id WHERE b.id = '$result'";
        $run_inner = SQLSRV_QUERY($Con, $display_inner);
        while ($row_inner = SQLSRV_FETCH_ARRAY($run_inner, SQLSRV_FETCH_ASSOC)) {
            // $profit_loss = ;

            // $sum += $profit_loss;
            $profit_loss = $row_inner['profit_loss'];

        ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $row_inner['sell_qty'] ?></td>
                <td><?= $row_inner['exit_price'] ?></td>
                <td><?= $row_inner['total_amount'] ?></td>
                <td style="color: <?php echo ($profit_loss > 0) ? 'green' : (($profit_loss < 0) ? 'red' : 'black'); ?>; font-weight:600; "><?= $profit_loss ?></td>
            </tr>
        <?php } ?>
        <tr>
            <?php
            $display_sum = "SELECT SUM(profit_loss) as total_profit_loss FROM sell_db WHERE buy_id='$buyID'";
            $sum_run = sqlsrv_query($Con, $display_sum);
            $sum_result = SQLSRV_FETCH_ARRAY($sum_run, SQLSRV_FETCH_ASSOC);
            $sum_row = $sum_result['total_profit_loss']
            ?>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="color: <?php echo ($sum_row > 0) ? 'green' : (($sum_row < 0) ? 'red' : 'black'); ?>; font-weight:700; ">Total : ₹<?= $sum_row ?></td>
        </tr>
    <?php } ?>
<?php
} ?>