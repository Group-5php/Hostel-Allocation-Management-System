<!DOCTYPE html>
<html>

<head>
    <title>Hostel Allocation Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            width: 400px;
            margin: 100px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        a.button {
            display: block;
            margin: 12px 0;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hostel Allocation System</h1>
        <p>Welcome! Choose what you want to do:</p>

        <a class="button" href="register.php">Register Student</a>
        <a class="button" href="allocate.php">Allocate Room</a>
        <a class="button" href="transfer.php">Transfer Room</a>
        <a class="button" href="vacate.php">Vacate Room</a>
        <a class="button" href="report.php">View Report</a>
    </div>
</body>

</html>