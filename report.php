<?php
include('db_connect.php');
$result = mysqli_query($conn, "
    SELECT s.name, s.matric_no, s.department, a.room_num, a.date_allocated, a.allocation_status
    FROM allocations a
    JOIN students s ON s.matric_no = a.matric_no
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Allocation Report</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Allocation Report</h2>
    <table border="1" cellpadding="6">
        <tr>
            <th>Name</th>
            <th>Matric No</th>
            <th>Department</th>
            <th>Room No</th>
            <th>Date Allocated</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['name']; ?></td>
                <td><?= $row['matric_no']; ?></td>
                <td><?= $row['department']; ?></td>
                <td><?= $row['room_num']; ?></td>
                <td><?= $row['date_allocated']; ?></td>
                <td><?= $row['allocation_status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
