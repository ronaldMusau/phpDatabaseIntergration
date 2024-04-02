<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Student Login</h2>
        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $class = $_POST["class"];

            // Database connection details
            $servername = "localhost";
            $db_username = "root"; // Changed variable name to avoid conflict
            $db_password = "";
            $dbname = "student_records";

            // Create a connection
            $conn = new mysqli($servername, $db_username, $db_password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute the SQL query to check login credentials
            $sql = "SELECT * FROM students WHERE `Class` = '$class' AND `Class` = '$class'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Login successful, redirect to edit.php
                header("Location: edit.php");
                exit();
            } else {
                // Invalid username or password
                echo "Invalid class record.";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="class">Class Record</label>
            <input type="text" name="class" placeholder="Class Record" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
