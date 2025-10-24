<?php
include('db_connect.php');

if (isset($_POST['vacate'])) {
    $matric_no = $_POST['matric_no'];
    $check = mysqli_query($conn, "SELECT room_num FROM allocations WHERE matric_no='$matric_no' AND allocation_status='active'");
    if ($row = mysqli_fetch_assoc($check)) {
        $room_num = $row['room_num'];
        mysqli_query($conn, "UPDATE allocations SET allocation_status='vacated' WHERE matric_no='$matric_no'");
        mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_num='$room_num'");
        echo "<script>alert('Room vacated successfully!');</script>";
    } else {
        echo "<script>alert('Student not found or not allocated!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Vacate Room</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Vacate Room</h2>
    <form method="POST">
        <input type="text" name="matric_no" placeholder="Matric Number" required><br>
        <button type="submit" name="vacate">Vacate Room</button>
    </form>
</body>

</html>
