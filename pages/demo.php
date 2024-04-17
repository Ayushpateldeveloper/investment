<?php include('../includes/dbcon.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searchable Select Option</title>
    <style>
        .select-wrapper {
            position: relative;
            width: 200px;
            /* Adjust width as needed */
        }

        .select-wrapper select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .select-wrapper .search-box {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1;
            background-color: #fff;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 5px 5px;
            display: none;
            max-height: 150px;
            /* Adjust max-height as needed */
            overflow-y: auto;
        }

        .select-wrapper .search-box input {
            width: 100%;
            padding: 8px;
            border: none;
            border-bottom: 1px solid #ccc;
        }

        .select-wrapper .search-box ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .select-wrapper .search-box ul li {
            padding: 8px;
            cursor: pointer;
        }

        .select-wrapper .search-box ul li:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="select-wrapper">
        <select id="selectOption">
            <option value="">Select option</option>
            <!-- PHP code to fetch options from database and generate options dynamically -->
            <?php
            include('dbcon.php');
            $sql = "SELECT id, name FROM script_db";
            $run = SQLSRV_QUERY($Con, $sql);

            while ($row = SQLSRV_FETCH_ARRAY($run, SQLSRV_FETCH_ASSOC)) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select>
        <div class="search-box">
            <input type="text" placeholder="Search...">
            <ul></ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#selectOption').on('change', function() {
                var selectedValue = $(this).val();
                console.log(selectedValue);
            });

            $('.select-wrapper input').on('input', function() {
                var input = $(this).val().toLowerCase();
                var options = $('#selectOption option');
                $('.search-box ul').empty();
                options.each(function() {
                    if ($(this).text().toLowerCase().indexOf(input) !== -1) {
                        $('.search-box ul').append('<li data-value="' + $(this).val() + '">' + $(this).text() + '</li>');
                    }
                });
            });

            $(document).on('click', '.search-box ul li', function() {
                var selectedValue = $(this).attr('data-value');
                var selectedText = $(this).text();
                $('#selectOption').val(selectedValue);
                $('.select-wrapper .search-box input').val(selectedText);
                $('.search-box ul').empty();
            });

            $(document).on('click', function(event) {
                var container = $(".select-wrapper");
                if (!container.is(event.target) && container.has(event.target).length === 0) {
                    $('.search-box ul').empty();
                }
            });
        });
    </script>
</body>

</html>