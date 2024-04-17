<?php include('../includes/header.php');
include('../includes/dbcon.php');


$id = $_GET['id'];

$display = "SELECT * FROM buy_db where id='$id'";
$run = SQLSRV_QUERY($Con, $display);
$row = SQLSRV_FETCH_ARRAY($run, SQLSRV_FETCH_ASSOC);
$script_selected = $row['script_name'];
$sector = $row['sector'];
$entry_price = $row['entry_price'];
$qty = $row['quantity'];
$script_id = $row['script_id'];
$script_name = $row['script_name'];


?>
<!-- <div class="d-block w-25 float-end position-fixed top-2 end-0">
    <div class="container bg-primary p-2  float-end">
        <h5 class="text-white">You Can't Sell More Than <b><?= $qty ?> Quantity</b></h5>
    </div>
</div> -->
<div class="row float-end">
    <div class="float-end">
        <h6 class="text-muted">Qty : <?= $qty ?></h6>

    </div>
</div>
<div class="container mt-3">
    <div class="row ">
        <div class="col-md-12">
            <form action="../includes/buy-sell_db.php" method="POST" id="sell-entry">
                <div class="row">
                    <div class="col-md-3 ">
                        <div class="mb-3 w-full">

                            <label for="Script" class="w-100"> Script Name
                                <select name="script_name" class="form-control" id="script_name" disabled>
                                    <?php
                                    $sql = "SELECT id, name FROM script_db WHERE IsActive='TRUE'";
                                    $run = SQLSRV_QUERY($Con, $sql);


                                    // Fetch the selected script name before entering the loop


                                    while ($row = SQLSRV_FETCH_ARRAY($run, SQLSRV_FETCH_ASSOC)) {
                                        $selected = ($row['name'] == $script_selected) ? 'selected' : ''; ?>
                                        <option value="<?= $row['name'] ?>" <?= $selected ?>><?= $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </label>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="Script" class="w-100"> Sector
                                <input type="text" class="form-control mt-1" name="sector" id="sector" value="<?= $sector ?>" readonly>
                                <input type="hidden" name="script_id" id="script_id_val" value="<?= $script_id ?>">
                                <input type="hidden" name="script_name_sell" id="script_name_sell" value="<?= $script_name ?>">
                                <input type="hidden" name="buy_initial_qty" id="buy_initial_qty" value="<?= $qty ?>">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="Script" class="w-100"> Entry Date
                                <input type="date" class="form-control mt-1" name="entry_date" id="entry_date" value="<?= $row['entry_date'] ?>">

                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="sell_qty" class="w-100"> Quantity
                                <input type="number" class="form-control mt-1" min="1" name="sell_qty" id="quantity">

                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="exit_price" class="w-100"> Exit Price
                                <input type="text" class="form-control mt-1" min="1" name="exit_price" id="exit_price">
                                <input type="hidden" min="1" name="entry_price" value="<?= $entry_price ?>" id="entry_price">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="amount" class="w-100"> Amount
                                <input type="number" class="form-control mt-1" name="amount" id="amount" readonly>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="brokerage" class="w-100"> Brokerage
                                <input type="text" class="form-control mt-1" name="brokerage" id="brokerage" placeholder="Enter in %..">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="total_brokerage" class="w-100">Total Brokerage
                                <input type="number" class="form-control mt-1" name="total_brokerage" id="total_brokerage" readonly>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="total_amount" class="w-100">Total Amount
                                <input type="number" class="form-control mt-1" name="total_amount" id="total_amount" readonly>
                                <input type="hidden" name="buy_id" id="buy_id" value="<?= $id ?>">
                            </label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-danger btn-md mt-3" type="submit" form="sell-entry" name="add_sell">Sell </button>
            </form>
        </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="border border-1 rounded rounded-1 p-2 text-center" style="font-weight:400 ;">
            <h4 class="">Previously Buy Order Details</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <table class="table pt-5 w-full float-start" id="dataTable">
                <thead>

                    <tr>

                        <th scope="col">Script Name</th>
                        <th scope="col">Sector</th>
                        <th scope="col">Entry Date</th>
                        <th scope="col">Available Quantity</th>
                        <th scope="col"> Sell Quantity</th>
                        <th scope="col">Entry Price</th>
                        <th scope="col">Exit Price</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Brokerage</th>
                        <th scope="col">Total Brokerage</th>
                        <th scope="col">Total Amount</th>
                    </tr>

                </thead>
                <tbody id="buy_data">

                </tbody>
                <tfoot>
                    <tr>

                        <th scope="col">Script Name</th>
                        <th scope="col">Sector</th>
                        <th scope="col">Entry Date</th>
                        <th scope="col">Available Quantity</th>
                        <th scope="col"> Sell Quantity</th>
                        <th scope="col">Entry Price</th>
                        <th scope="col">Exit Price</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Brokerage</th>
                        <th scope="col">Total Brokerage</th>
                        <th scope="col">Total Amount</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {
        $('#buy_sell').addClass('active');
        $('#script_name').on('input', function() {

            var selectedOption = $(this).find('option:selected');

            var script_id_fetch = selectedOption.data('script_id');
            $('#script_id_val').val(script_id_fetch);

            $.ajax({
                method: 'POST',
                url: '../includes/buy-sell_db.php',
                data: {
                    script_id_fetch: script_id_fetch
                },
                success: function(response) {
                    $('#sector').val(response);
                },
                error: function(data) {
                    $('.script_result').html(data);
                }
            });

        });

        $('#quantity').on('input', function() {
            var data_qty = <?= $qty ?>; // Embedding PHP variable directly

            var qty = $(this).val();
            if (qty > data_qty) {
                alert('You can\'t sell more than ' + data_qty + ' quantity');
                $(this).val(data_qty);
            }
        });


        $(document).on('click', '.script_result li', function() {
            var selectedScript = $(this).text();
            $('#script_name').val(selectedScript);
            $('.script_result').empty();
        });

        var currentDate = new Date();

        var year = currentDate.getFullYear(); // Get the current year
        var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        var day = currentDate.getDate().toString().padStart(2, '0');

        // Format the date and time
        var formattedDateTime = year + '-' + month + '-' + day;
        $('#entry_date').val(formattedDateTime);

        $('#exit_price , #quantity,#brokerage').on('input', function() {
            var qty = $('#quantity').val();
            var exit_price = $('#exit_price').val();
            var amount = qty * parseFloat(exit_price);
            $('#amount').val(amount);
            var brokerage_percentage = parseFloat($('#brokerage').val());
            var brokerage = (brokerage_percentage / 100);
            var total_brokerage = amount * brokerage;
            $('#total_brokerage').val(total_brokerage);
            var total_amount = parseFloat(total_brokerage) + parseFloat(amount);
            $('#total_amount').val((total_amount).toFixed(2));
        });


        var buy_id = '<?= $id ?>';
        // alert(buy_id);
        $.ajax({
            url: '../includes/buy-sell_db.php',
            method: 'POST',
            data: {
                buy_id: buy_id
            },
            success: function(data) {
                var data = JSON.parse(data);
                console.log(data);

                // Iterate over the data array and generate HTML for each row
                var html = '';
                $.each(data, function(index, row) {
                    html += '<tr>';

                    html += '<td>' + row.script_name + '</td>';
                    html += '<td>' + row.sector + '</td>';
                    html += '<td>' + row.entry_date + '</td>';
                    html += '<td>' + row.buy_qty + '</td>';
                    html += '<td>' + row.sell_qty + '</td>';
                    html += '<td>' + row.entry_price + '</td>';
                    html += '<td>' + row.exit_price + '</td>';
                    html += '<td>' + row.amount + '</td>';
                    html += '<td>' + row.brokerage + '</td>';
                    html += '<td>' + row.total_brokerage + '</td>';
                    html += '<td>' + row.total_amount + '</td>';
                    html += '</tr>';
                });

                // Append the generated HTML to the table body
                $('#buy_data').html(html);
                // $('#buy_data').html(data);
            },
            error: function(data) {
                $('.script_result').html(data);
            }
        });

    });
</script>