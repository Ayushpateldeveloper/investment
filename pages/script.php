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
        <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#AddnewModal">Add New</button>
    </div>
</div>
<div class="container w-full">
    <div class="box p-3 rounded-2">
        <table class=" table pt-5 w-full float-start" id="dataTable">
            <thead>

                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Fund Type</th>
                    <th scope="col">Sector</th>
                    <th scope="col">Sub-sector</th>
                    <th scope="col">Actions</th>
                </tr>

            </thead>
            <tbody>
                <?php
                $sql = "SELECT  s.id,s.name,f.fund_name AS fund_type,s.sector,s.sub_sector
        FROM 
          script_db AS s
        JOIN 
          fund_db AS f ON s.fund_id = f.id WHERE s.isActive='TRUE'
       ";
                $run = SQLSRV_QUERY($Con, $sql);
                while ($row = SQLSRV_FETCH_ARRAY($run, SQLSRV_FETCH_ASSOC)) {

                ?>

                    <tr>
                        <td class="id"><?= $row['id'] ?></td>
                        <td class="script_name"><?= $row['name'] ?></td>
                        <td class="fund_name"><?= $row['fund_type'] ?></td>
                        <td class="sector"><?= $row['sector'] ?></td>
                        <td class="sub_sector"><?= $row['sub_sector'] ?></td>
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
                    <th scope="col">Fund Type</th>
                    <th scope="col">Sector</th>
                    <th scope="col">Sub-sector</th>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Script</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../includes/script_db.php" method="post" id="script_add">
                    <div class="mb-2">
                        <label class="form-label">Script Name</label>
                        <input type="text" class="form-control" name="script_name">
                    </div>
                    <div class="mb-2">
                        <label for="ScriptName" class="form-label">Fund Type</label>
                        <select class="form-select" name="fund_id">
                            <option selected></option>
                            <?php
                            $sql_select = "SELECT fund_name,id FROM fund_db WHERE isActive='TRUE'";
                            $select_run = SQLSRV_QUERY($Con, $sql_select);
                            while ($select_row = SQLSRV_FETCH_ARRAY($select_run)) {
                            ?>
                                <option value="<?= $select_row['id'] ?>"><?= $select_row['fund_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="sector" class="form-label">Sector</label>
                        <input type="text" class="form-control" name="sector">
                    </div>
                    <div class="mb-2">
                        <label for="sub_sector" class="form-label">Sub Sector</label>
                        <input type="text" class="form-control" name="sub_sector">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="add_new_script" form="script_add" class="btn btn-primary">Save changes</button>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Script</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../includes/script_db.php" method="post" id="script_update">
                    <div class="mb-2">
                        <label for="ScriptName" class="form-label">Script Name</label>
                        <input type="text" class="form-control" id="ScriptName" name="script_name">
                    </div>
                    <div class="mb-2">
                        <label for="ScriptName" class="form-label">Fund Type</label>
                        <select class="form-select" name="fund_id" id="fund_type">
                            <option selected></option>
                            <?php
                            $sql_select = "SELECT fund_name,id FROM fund_db WHERE isActive='TRUE'";
                            $select_run = SQLSRV_QUERY($Con, $sql_select);
                            while ($select_row = SQLSRV_FETCH_ARRAY($select_run)) {
                            ?>
                                <option value="<?= $select_row['id'] ?>"><?= $select_row['fund_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="sector" class="form-label">Sector</label>
                        <input type="text" class="form-control" id="sector" name="sector">
                    </div>
                    <div class="mb-2">
                        <label for="sub_sector" class="form-label">Sub Sector</label>
                        <input type="text" class="form-control" id="sub_sector" name="sub_sector">
                        <input type="hidden" name="id" id="id">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="update_script" form="script_update" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php include('../includes/footer.php'); ?>
<script>
    $(document).ready(function() {
        $('#Script').addClass('active');
        $('#dataTable').DataTable({
            info: false,
            lengthChange: false,
            dom: 'Bfrtip',
            buttons: ['pageLength'],
            stateSave: true

        });

        $('.edit').on('click', function() {

            var data = $(this).closest('tr').find('.script_name').text();
            var id = $(this).closest('tr').find('.id').text();
            var fund_name = $(this).closest('tr').find('.fund_name').text();
            var sector = $(this).closest('tr').find('.sector').text();
            var sub_sector = $(this).closest('tr').find('.sub_sector').text();

            $('#ScriptName').val(data);
            $('#id').val(id);
            $('#fund_type option').each(function() {
                if ($(this).text() === fund_name) {
                    $(this).prop('selected', true);
                }
            });
            $('#sector').val(sector);
            $('#sub_sector').val(sub_sector);

        });

        $('.delete').on('click', function() {
            var id = $(this).closest('tr').find('.id').text();
            alert(id + ' deleted');
            $.ajax({
                url: "../includes/script_db.php",
                method: "POST",
                data: {
                    delete_script: id
                },
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
        });
    });
</script>