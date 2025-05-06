<?php

    include '../server/config.php';

    if(isset($_GET['data'])) {
        if(!empty($_GET['data'])) {
            $whereClause = $_GET['data'];
        } else {
            $whereClause = "";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation History</title>
      <?php include '../assets/templates/template.php' ?>
      <link rel="stylesheet" href="../main-css/print.css" media="print">
</head>
<style>
    @media print {
        @page { margin: 0; size: auto; }
    }
</style>
<body>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-12">
                <br>
                <h2 class="text-center mb-5">Reservation History</h2>
                <table class="table" id="myTable" style="width: 100%">
                    <thead>
                        <tr class="text-center">
                            <th>Result</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Reserved At</th>
                            <th>No. of Guest</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                            $getList = "SELECT * FROM history ".base64_decode($whereClause)." ORDER BY id DESC";
                            $listResult = mysqli_query($conn, $getList);

                            if($listResult) {
                                while($row = mysqli_fetch_assoc($listResult)) {

                                    $list_id = $row['id'];
                                    $list_name = $row['name'];
                                    $list_email = $row['email'];
                                    $list_date = $row['date'];
                                    $list_time = $row['time'];
                                    $mobile = $row['mobile'];
                                    $done_at = $row['done_at'];
                                    $list_table_reserved = $row['table_reserved'];
                                    $list_no_of_guest = $row['no_of_guest'];
                                    $result = $row['result'];
                                    $created_date = $row['created_at'];
                                    $created_by = $row['created_by'];

                                    echo '
                                        <tr class="text-center">
                                            <td class="'.($result == 'Approved' ? 'text-success' : 'text-danger').'">'.$result.'</td>
                                            <td>'.$list_name.'</td>
                                            <td>'.$list_email.'</td>
                                            <td>'.$list_date. ' ' .$list_time.'</td>
                                            <td>'.$list_no_of_guest.'</td>
                                        </tr>
                                        
                                    ';
                                }
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

<script>
    setTimeout(() => {
        window.onafterprint = window.close
        window.print()
    }, 10);
</script>
</body>
</html>