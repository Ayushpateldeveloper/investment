<?php include('../includes/header.php');
include('../includes/dbcon.php');
?>
<style>
    #dataTable_wrapper {
        width: 100%;
        margin-top: 50px !important;
    }

    table.dataTable {
        text-align: center;
    }

    table.dataTable tbody tr {
        background-color: #E6E6E6;
    }

    .container .box {
        background-color: #E6E6E6;
        border-radius: 25px !important;
    }

    .container .button {
        position: absolute;
        top: 120px;
        right: 180px;
    }
</style>
<div class="container-fluid">

    <div class="d-none" id="display_row">
        <div class="row">
            <div class="col-md-12">
                <form action="../includes/buy_update.php" method="POST" id="buy-entry-update">
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
                                    <input type="number" class="form-control mt-1" min="1" name="entry_price" id="entry_price">
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
                    <input type="hidden" name="buy_id" id="buy_id">
                    <button class="btn btn-primary mt-3" type="submit" form="buy-entry-update" name="add_buy_update">Update</button>
                </form>
            </div>
        </div>
        <hr>
    </div>
    <div class="row float-end button">
        <div>
            <a href="buy-add.php" class="btn btn-primary"><i class="bx bx-plus"></i>Add New Entry</a>
        </div>
    </div>
    <div class="row">
        <h4 class="text-center">Buy Entries</h4><br><br><br>

        <div class="container w-full">
            <div class="box p-3 rounded-2">

                <table class="table table-hover border-1 pt-5 w-full float-start" id="dataTable">
                    <thead>

                        <tr>

                            <th scope="col">Script Name</th>
                            <th scope="col">Sector</th>
                            <th style="width: 190px;" scope="col">Entry Date</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Entry Price</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Brokerage</th>
                            <th scope="col">Total Brokerage</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Actions</th>
                        </tr>

                    </thead>
                    <tbody id="buy_data">
                        <?php
                        $display = "SELECT * FROM buy_db";
                        $run = SQLSRV_QUERY($Con, $display);
                        while ($row = SQLSRV_FETCH_ARRAY($run, SQLSRV_FETCH_ASSOC)) {
                            $disabled = $row['isSell'];
                            if ($disabled == true) {
                                $disabled = 'disabled';
                            } else {
                                $disabled = '';
                            }
                        ?>
                            <tr>

                                <td class="script_name"><?= $row['script_name'] ?></td>
                                <td class="sector"><?= $row['sector'] ?></td>
                                <td class="entry_date" style="width: 190px;"><?= $row['entry_date']->format('Y-m-d') ?></td>
                                <td class="quantity"><?= $row['initial_buy'] ?></td>
                                <td class="entry_price"><?= $row['entry_price'] ?></td>
                                <td class="amount"><?= $row['amount'] ?></td>
                                <td class="brokerage"><?= $row['brokerage'] ?></td>
                                <td class="total_brokerage"><?= $row['total_brokerage'] ?></td>
                                <td class="total_amount"><?= $row['total_amount'] ?></td>
                                <td style="width: 15%;">
                                    <div class="row d-flex flex-row gap-1 ">
                                        <button data-script_id="<?= $row['script_id'] ?>" <?= $disabled ?> data-buy_id="<?= $row['id'] ?>" class="btn btn-primary edit" style="width: 40%;">Edit</button>
                                        <a href="sell-add.php?id=<?= $row['id'] ?>" class="btn btn-danger " style="width: 40%;">SELL</a>
                                    </div>
                                </td>


                            </tr>
                        <?php } ?>
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
                            <th scope="col">Actions</th>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
    <div class="mt-1 mb-2"><br></div>

</div>
<?php include('../includes/footer.php'); ?>
<script>
    $(document).ready(function() {
        $('#buy_sell').addClass('active');
        $('#dataTable, #dataTable1').DataTable({
            info: false,
            lengthChange: false,
            dom: 'Bfrtip',
            buttons: ['pageLength', 'copy', 'excel', 'pdf', 'colvis'],
            stateSave: true
        });
        $('.edit').on('click', function() {
            $('#display_row').removeClass('d-none');
            var id = $(this).data('buy_id');
            var script_name = $(this).closest('tr').find('.script_name').text();
            $('#script_name').val(script_name);
            var sector = $(this).closest('tr').find('.sector').text();
            $('#sector').val(sector);
            var entry_date = $(this).closest('tr').find('.entry_date').text();
            $('#entry_date').val(entry_date);
            var quantity = $(this).closest('tr').find('.quantity').text();
            $('#quantity').val(quantity);
            var entry_price = $(this).closest('tr').find('.entry_price').text();
            $('#entry_price').val(entry_price);
            var amount = $(this).closest('tr').find('.amount').text();
            $('#amount').val(amount);
            var brokerage = $(this).closest('tr').find('.brokerage').text();
            $('#brokerage').val(brokerage);
            var total_brokerage = $(this).closest('tr').find('.total_brokerage').text();
            $('#total_brokerage').val(total_brokerage);
            var total_amount = $(this).closest('tr').find('.total_amount').text();
            $('#total_amount').val(total_amount);
            var id = $(this).data('buy_id');
            $('#buy_id').val(id);
            var script_id = $(this).data('script_id');
            $('#script_id_val').val(script_id);

            $('#script_name').on('input', function() {
                // var script_id = $('#script_name').val(); // Get the value of the input field
                // Only trigger AJAX request if input field is not empty
                var selectedOption = $(this).find('option:selected');
                $('#display_row').removeClass('d-none');
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

                    },
                    error: function(data) {
                        $('.script_result').html(data);
                    }
                });

            });



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

    });
</script>