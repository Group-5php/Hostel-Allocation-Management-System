<?php
include('db_connect.php');

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $matric_no = $_POST['matric_no'];
    $department = $_POST['department'];
    $gender = $_POST['gender'];

    $query = "INSERT INTO students (name, matric_no, department, gender)
              VALUES ('$name', '$matric_no', '$department', '$gender')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Student registered successfully!');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Register New Student</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="text" name="matric_no" placeholder="Matric Number" required><br>
        <input type="text" name="department" placeholder="Department" required><br>
        <input type="text" name="gender" placeholder="Gender" required><br>
        <button type="submit" name="register">Register</button>
    </form>
</body>

</html>