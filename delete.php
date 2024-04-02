<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $class = $_POST["class"];
    $password = $_POST["password"];

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
    $sql = "SELECT * FROM students WHERE `Class` = '$class' AND `Class` = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Authentication successful, proceed with deletion
        // Prepare and execute the SQL query to delete the record
        $delete_sql = "DELETE FROM students WHERE `Class` = '$class'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "Records for class $class deleted successfully. Redirecting...";
            // Redirect to index.html after a brief delay
            header("refresh:2;url=index.html");
            exit();
        } else {
            echo "Error deleting records: " . $conn->error;
        }
    } else {
        // Authentication failed
        echo "Invalid class or password.";
    }

    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        // Function to display a confirmation dialog before deletion
        function confirmDeletion() {
            return confirm("Are you sure you want to delete records?");
        }
    </script>
</head>
<body>
    <h2>Delete Student Records</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return confirmDeletion()">
        <label for="class">Class:</label>
        <input type="text" name="class" required><br>

        <label for="password">Password (Class Record):</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Delete Records">
    </form>
</body>
</html>
