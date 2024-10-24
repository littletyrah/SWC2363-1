<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL root password if you have one
$dbname = "sales_commission";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form values
    $name = $_POST['name'];
    $month = $_POST['month'];
    $sales_amount = $_POST['sales_amount'];

    // Calculate commission based on sales amount
    if ($sales_amount >= 1 && $sales_amount <= 2000) {
        $commission_rate = 0.03; // 3%
    } elseif ($sales_amount >= 2001 && $sales_amount <= 5000) {
        $commission_rate = 0.04; // 4%
    } elseif ($sales_amount >= 5001 && $sales_amount <= 7000) {
        $commission_rate = 0.07; // 7%
    } else {
        $commission_rate = 0.10; // 10%
    }

    // Calculate the commission amount
    $commission = $sales_amount * $commission_rate;

    // Insert the data into the database
    $sql = "INSERT INTO sales (name, month, sales_amount, commission) VALUES ('$name', '$month', '$sales_amount', '$commission')";

    if ($conn->query($sql) === TRUE) {
        // Output the result in a styled container
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Sales Commission Result</title>";
        echo "<link rel='stylesheet' href='styles.css'>"; // Link to your CSS file
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Sales Commission Result</h1>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Month:</strong> $month</p>";
        echo "<p><strong>Sales Amount:</strong> RM " . number_format($sales_amount, 2) . "</p>";
        echo "<p><strong>Sales Commission:</strong> RM " . number_format($commission, 2) . "</p>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
