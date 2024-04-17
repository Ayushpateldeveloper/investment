<?php include('../includes/header.php'); ?>
<?php include('../includes/dbcon.php'); ?>

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
</style>
<div class="container mb-0">
    <div class="float-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddnewModal">Add New</button>
    </div>
</div>
<div class="container w-full">
    <div class="box p-3 rounded-2">
        <table class="table pt-5 w-full float-start" id="dataTable">
            <thead>

                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>

            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM fund_db WHERE isActive='True'";
                $run = SQLSRV_QUERY($Con, $sql);
                while ($row = SQLSRV_FETCH_ARRAY($run, SQLSRV_FETCH_ASSOC)) {
                ?>

                    <tr>
                        <td class="id"><?= $row['id'] ?></td>
                        <td class="fundname"><?= $row['fund_name'] ?></td>
                        <td>
                            <div class="container d-flex flex-row" id="actions_style">
                                <button type="button" class="btn btn-primary edit d-flex flex-row align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModal" id="<?php echo $row['id'] ?>"><i class='bx bxs-edit'></i>&nbsp;&nbsp;Edit</button>
                                <button type="button" class="btn btn-danger delete d-flex flex-row align-items-center " id="<?php echo $row['id'] ?>"><i class='bx bxs-trash'></i>Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- Add new modal -->
<div class="modal fade" id="AddnewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Fund</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../includes/fund_db.php" method="post" id="fund_update">
                    <label for="fund_name">Fund Name
                        <input type="text" name="add_fund_name" id="fund_name">
                    </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="add_new_fund" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- update modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Fund</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../includes/fund_db.php" method="post" id="fund_update">
                    <label for="fund_update">Fund Name
                        <input type="text" name="update_fund_name" id="update_fund_name">
                        <input type="hidden" name="id" id="id">
                    </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="update_fund" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>
<script>
    $(document).ready(function() {
        $('#Fund').addClass('active');
        $('#dataTable').DataTable({
            info: false,
            lengthChange: false,
            dom: 'Bfrtip',
            buttons: ['pageLength'],
            stateSave: true

        });

        $('.edit').on('click', function() {

            var data = $(this).closest('tr').find('.fundname').text();
            var id = $(this).closest('tr').find('.id').text();

            $('#update_fund_name').val(data);
            $('#id').val(id);

        });

        $('.delete').on('click', function() {
            var id = $(this).closest('tr').find('.id').text();
            $.ajax({
                url: "../includes/fund_db.php",
                method: "POST",
                data: {
                    delete_fund: id
                },
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
        });
    });
</script>