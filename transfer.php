no <?php
    include('db_connect.php');

    if (isset($_POST['transfer'])) {
        $matric_no = $_POST['matric_no'];
        $new_room = $_POST['new_room'];

        // Check if student currently has an active allocation
        $check = mysqli_query($conn, "SELECT * FROM allocations WHERE matric_no='$matric_no' AND allocation_status='active'");
        if (mysqli_num_rows($check) == 0) {
            echo "<script>alert('This student does not have any active room!');</script>";
        } else {
            $currentAlloc = mysqli_fetch_assoc($check);
            $old_room = $currentAlloc['room_num'];

            // Check capacity of new room
            $roomCheck = mysqli_query($conn, "
            SELECT capacity, 
            (SELECT COUNT(*) FROM allocations WHERE room_num='$new_room' AND allocation_status='active') AS occupied
            FROM rooms WHERE room_num='$new_room'
        ");
            $roomData = mysqli_fetch_assoc($roomCheck);

            if (!$roomData) {
                echo "<script>alert('New room not found!');</script>";
            } else {
                $capacity = $roomData['capacity'];
                $occupied = $roomData['occupied'];

                if ($occupied >= $capacity) {
                    echo "<script>alert('New room is already full!');</script>";
                } else {
                    // Update student's allocation to new room
                    mysqli_query($conn, "UPDATE allocations SET room_num='$new_room', date_allocated=CURDATE() WHERE matric_no='$matric_no' AND allocation_status='active'");

                    // Update room statuses
                    // 1. Mark old room available if it now has free space
                    $oldRoomCheck = mysqli_query($conn, "
                    SELECT capacity, 
                    (SELECT COUNT(*) FROM allocations WHERE room_num='$old_room' AND allocation_status='active') AS occupied
                    FROM rooms WHERE room_num='$old_room'
                ");
                    $oldRoomData = mysqli_fetch_assoc($oldRoomCheck);
                    if ($oldRoomData['occupied'] < $oldRoomData['capacity']) {
                        mysqli_query($conn, "UPDATE rooms SET status=1 WHERE room_num='$old_room'");
                    }

                    // 2. Mark new room occupied if full
                    if ($occupied + 1 >= $capacity) {
                        mysqli_query($conn, "UPDATE rooms SET status=0 WHERE room_num='$new_room'");
                    }

                    echo "<script>alert('Room transferred successfully!');</script>";
                }
            }
        }
    }
    ?>

 <!DOCTYPE html>
 <html>

 <head>
     <title>Transfer Room</title>
     <link rel="stylesheet" href="style.css">
 </head>

 <body>
     <div class="form-container">
         <h2>Transfer Room</h2>

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

             <label>New Room:</label>
             <select name="new_room" required>
                 <option value="">Select Room</option>
                 <?php
                    $rooms = mysqli_query($conn, "SELECT room_num FROM rooms WHERE status=1");
                    while ($r = mysqli_fetch_assoc($rooms)) {
                        echo "<option value='{$r['room_num']}'>{$r['room_num']}</option>";
                    }
                    ?>
             </select>

             <button type="submit" name="transfer">Transfer</button>
         </form>
     </div>
 </body>

</html>
