<?php
include('db_connect.php');

if (isset($_POST['allocate'])) {
    $matric_no = $_POST['matric_no'];
    $room_num = $_POST['room_num'];

    // Check if student already has an active room
    $checkStudent = mysqli_query($conn, "SELECT * FROM allocations WHERE matric_no='$matric_no' AND allocation_status='active'");
    if (mysqli_num_rows($checkStudent) > 0) {
        echo "<script>alert('This student already has a room!');</script>";
    } else {
        // Check room capacity and occupancy
        $roomCheck = mysqli_query($conn, "
            SELECT capacity, 
            (SELECT COUNT(*) FROM allocations WHERE room_num='$room_num' AND allocation_status='active') AS occupied
            FROM rooms WHERE room_num='$room_num'
        ");
        $roomData = mysqli_fetch_assoc($roomCheck);

        if (!$roomData) {
            echo "<script>alert('Room not found in database!');</script>";
        } else {
            $capacity = $roomData['capacity'];
            $occupied = $roomData['occupied'];

            if ($occupied >= $capacity) {
                echo "<script>alert('This room is already full! Choose another room.');</script>";
            } else {
                // Insert student-room allocation
                $insert = mysqli_query($conn, "
                    INSERT INTO allocations (matric_no, room_num, date_allocated, allocation_status)
                    VALUES ('$matric_no', '$room_num', CURDATE(), 'active')
                ");

                // Update room status if now full
                if ($occupied + 1 >= $capacity) {
                    mysqli_query($conn, "UPDATE rooms SET status=0 WHERE room_num='$room_num'");
                }

                if ($insert) {
                    echo "<script>alert('Room allocated successfully!');</script>";
                } else {
                    echo "<script>alert('Error allocating room.');</script>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Allocate Room</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form-container">
        <h2>Allocate Room</h2>

        <form method="POST" action="">
            <label>Student:</label>
            <select name="matric_no" required>
                <option value="">Select Student</option>
                <?php
                $students = mysqli_query($conn, "SELECT * FROM students");
                while ($s = mysqli_fetch_assoc($students)) {
                    echo "<option value='{$s['matric_no']}'>{$s['name']} ({$s['matric_no']})</option>";
                }
                ?>
            </select>

            <label>Available Room:</label>
            <select name="room_num" required>
                <option value="">Select Room</option>
                <?php
                // Only show rooms that are available (status=1)
                $rooms = mysqli_query($conn, "SELECT room_num FROM rooms WHERE status=1");
                while ($r = mysqli_fetch_assoc($rooms)) {
                    echo "<option value='{$r['room_num']}'>{$r['room_num']}</option>";
                }
                ?>
            </select>
        

            <button type="submit" name="allocate">Allocate</button>
        </form>
    </div>
</body>

</html>
