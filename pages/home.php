<?php
include('../includes/header.php');
include('../includes/dbcon.php');
// Check if $sum is empty or not
if (empty($sum)) {
    // If $sum is empty, display "Profit/Loss" without any specific value
    $displayText = "Profit / Loss";
} else {
    // If $sum is not empty, calculate whether it's a profit or loss
    $displayText = ($sum > 0) ? 'Profit : ' . "$Sum" : 'Loss : ' . "$Sum";
    $displayText .= " Total Sum: $sum";
}
?>

<div class="container-fluid">
    <div class="col-md-3 float-end d-flex ">
        <label for="Script" class="w-50"> Script Name </label>
        <select name="script_name" class="form-control" id="script_name">
            <option value="">Select option</option>
            <!-- PHP code to fetch options from database and generate options dynamically -->
            <?php

            $sql = "SELECT id, name FROM script_db WHERE IsActive='TRUE'";
            $run = SQLSRV_QUERY($Con, $sql);

            while ($row = SQLSRV_FETCH_ARRAY($run, SQLSRV_FETCH_ASSOC)) {
                echo "<option data-script_id='" . $row['id'] . "' value='" . $row['name'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select>

    </div>
</div>

<table class="table table-hover border-1 pt-5 w-full float-start" id="dataTable">
    <thead>
        <tr>
            <th scope="col">Script Name</th>
            <th scope="col">Sector</th>
            <th style="width: 190px;" scope="col">Entry Date</th>
            <th scope="col">Quantity</th>
            <th scope="col">Entry Price</th>
            <th scope="col">Amount</th>
            <th scope="col">Total Amount</th>
            <th scope="col">Sell QTY</th>
            <th scope="col">Exit Price</th>
            <th scope="col">Total Amount</th>
            <th scope="col">Profit / Loss</th>
        </tr>
    </thead>
    <tbody id="buy_data">

    </tbody>
    <tfoot>
        <tr>
            <th scope="col">Script Name</th>
            <th scope="col">Sector</th>
            <th style="width: 190px;" scope="col">Entry Date</th>
            <th scope="col">Quantity</th>
            <th scope="col">Entry Price</th>
            <th scope="col">Amount</th>
            <th scope="col">Total Amount</th>
            <th scope="col">Sell QTY</th>
            <th scope="col">Exit Price</th>
            <th scope="col">Total Amount</th>
            <th colspan="1" scope="col" style="color: <?php echo ($sum > 0) ? 'green' : 'red'; ?>; font-weight:700; ">
                <?= $displayText  ?>
            </th>

        </tr>
    </tfoot>
</table>

<?php include('../includes/footer.php'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->

<script>
    $(document).ready(function() {
        $('#dashboard').addClass('active');

        $('#script_name').change(function() {
            // var selectedValue = $(this).val(); // Get the selected value
            // console.log(selectedValue); // Log the selected value to the console
            // You can use the selected value as needed, for example:
            var selectedScriptId = $(this).find(':selected').data('script_id');
            // alert(selectedScriptId);
            $.ajax({
                method: 'POST',
                url: 'dynamicdataload.php',
                data: {
                    selectedScriptId: selectedScriptId
                },
                success: function(data) {
                    $('#buy_data').html(data);
                    var selectedScriptId = $(this).find(':selected').data('script_id');
                    $.ajax({
                        method: 'POST',
                        url: '../includes/buy-sell_db.php',
                        data: {
                            selectedScriptId: selectedScriptId
                        },
                        success: function(response) {
                            console.log(response); // Log the response to see its content
                            // var sum = response.sum; // Accessing the 'sum' property directly
                            // console.log(sum);
                            var sum = parseFloat(response); // Convert response to a number (if needed)
                            console.log(sum);
                            var sum = parseFloat(response.trim());


                        },
                        error: function(data) {
                            $('.script_result').html(data);
                        }
                    });
                },
                error: function(data) {
                    console.log(data);
                }
            });

        });
    });
</script>