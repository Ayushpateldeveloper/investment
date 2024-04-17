<?php include('../includes/header.php');
include('../includes/dbcon.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="../includes/buy-sell_db.php" method="POST" id="buy-entry">
                <div class="row">
                    <div class="col-md-3 ">
                        <div class="mb-3 w-full">
                            <label for="Script" class="w-100"> Script Name
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
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="Script" class="w-100"> Sector
                                <input type="text" class="form-control mt-1" name="sector" id="sector" readonly>
                                <input type="hidden" name="script_id" id="script_id_val">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="Script" class="w-100"> Entry Date
                                <input type="date" class="form-control mt-1" name="entry_date" id="entry_date">

                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="quantity" class="w-100"> Quantity
                                <input type="number" class="form-control mt-1" min="1" name="quantity" id="quantity">

                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="entry_price" class="w-100"> Entry Price
                                <input type="text" class="form-control mt-1" min="1" name="entry_price" id="entry_price">
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
                            </label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary mt-3" type="submit" form="buy-entry" name="add_buy">Submit</button>
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
                        <th scope="col">Quantity</th>
                        <th scope="col">Entry Price</th>
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
                        <th scope="col">Quantity</th>
                        <th scope="col">Entry Price</th>
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



        // Event listener for the keydown event on #script_name input
        $('#script_name').on('input', function() {
            // var script_id = $('#script_name').val(); // Get the value of the input field
            // Only trigger AJAX request if input field is not empty
            var selectedOption = $(this).find('option:selected');

            // Retrieve the value of the 'data-script_name' attribute using .data() method
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

                    var script_id_table = selectedOption.data('script_id');
                    $.ajax({
                        url: '../includes/buy-sell_db.php',
                        method: 'POST',
                        data: {
                            script_id_table: script_id_table
                        },
                        success: function(data) {
                            var data = JSON.parse(data);

                            // Iterate over the data array and generate HTML for each row
                            var html = '';
                            $.each(data, function(index, row) {
                                html += '<tr>';

                                html += '<td>' + row.script_name + '</td>';
                                html += '<td>' + row.sector + '</td>';
                                html += '<td>' + row.entry_date + '</td>';
                                html += '<td>' + row.initial_buy + '</td>';
                                html += '<td>' + row.entry_price + '</td>';
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
                    // $('#buy_data').html(responseData.table_display);

                },
                error: function(data) {
                    $('.script_result').html(data);
                }
            });

        });

        // Event listener for clicking on an option in the result list
        $(document).on('click', '.script_result li', function() {
            var selectedScript = $(this).text(); // Get the text of the clicked option
            $('#script_name').val(selectedScript); // Set the value of the input field to the selected script name
            $('.script_result').empty(); // Clear the result list
        });

        // Create a new Date object
        var currentDate = new Date();

        // Get the current date components
        var year = currentDate.getFullYear(); // Get the current year
        var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Get the current month (Note: January is 0)
        var day = currentDate.getDate().toString().padStart(2, '0'); // Get the current day of the month
        // var hours = currentDate.getHours().toString().padStart(2, '0'); // Get the current hour
        // var minutes = currentDate.getMinutes().toString().padStart(2, '0'); // Get the current minute
        // var seconds = currentDate.getSeconds().toString().padStart(2, '0'); // Get the current second

        // Format the date and time
        var formattedDateTime = year + '-' + month + '-' + day;
        $('#entry_date').val(formattedDateTime);


        $('#entry_price , #quantity,#brokerage').on('input', function() {
            var qty = $('#quantity').val();
            var entry_price = $('#entry_price').val();
            var amount = qty * parseFloat(entry_price);
            $('#amount').val(amount);
            var brokerage_percentage = parseFloat($('#brokerage').val());
            var brokerage = (brokerage_percentage / 100);
            var total_brokerage = amount * brokerage;
            $('#total_brokerage').val(total_brokerage);
            var total_amount = parseFloat(total_brokerage) + parseFloat(amount);
            $('#total_amount').val((total_amount).toFixed(2));
        });


    });
</script>