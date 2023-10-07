<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="imankitkalirawana">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Students - Divinely Developers</title>
    <!-- Style Sheet -->
    <link rel="stylesheet" type="text/css" href="/css/theme.css" />
    <link rel="stylesheet" type="text/css" href="/css/common.css" />
    <link rel="stylesheet" type="text/css" href="/css/data-table.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.5/datatables.min.css" rel="stylesheet">


    <!-- Javascript -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://pro.Fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="container">
        <h1>Student Details</h1>
        <table id="studentsTable" class="display">
            <thead>
                <tr>
                    <th>Reg. No</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>Mother Name</th>
                    <th>DOB</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            var studentsTable = $('#studentsTable').DataTable({
                "ajax": {
                    "url": "get_students.php",
                    "type": "POST",
                    "dataType": "json",
                    "dataSrc": ""
                },
                "columns": [{
                        "data": "reg_no"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "father_name"
                    },
                    {
                        "data": "mother_name"
                    },
                    {
                        "data": "dob"
                    },
                    {
                        "data": "phone_number"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "address"
                    }
                ],
                "paging": true,
                "pageLength": 10,
                "searching": true,
                "ordering": true,
            });

            $('#studentsTable').on('click', '.delete-btn', function() {
                var row = $(this).closest('tr');
                var rowData = studentsTable.row(row).data();

                // Send an AJAX request to the server-side PHP script to delete the record
                $.ajax({
                    url: 'delete_student.php', // Replace with the path to your server-side PHP script
                    type: 'POST',
                    data: {
                        reg_no: rowData.reg_no
                    }, // Send the unique identifier of the record to be deleted
                    success: function(response) {
                        // If the record is successfully deleted from the database, remove the row from the DataTable
                        if (response.success) {
                            studentsTable.row(row).remove().draw();
                        } else {
                            // Handle any error messages returned from the server-side script, if needed
                            console.log(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle any AJAX errors, if necessary
                        console.log(error);
                    }
                });
            });
        });
    </script>





    <script src="https://cdn.datatables.net/v/dt/dt-1.13.5/datatables.min.js"></script>
</body>

</html>