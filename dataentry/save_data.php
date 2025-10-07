<?php
$host = "localhost";
$user = "root";        // your DB username
$pass = "";            // your DB password
$db   = "diamond_db";  // your DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$barcode = $_POST['barcode'];
$process_names = $_POST['process_name'];
$pcs = $_POST['pcs'];
$carats = $_POST['carat'];
$percentages = $_POST['percentage'];

for ($i = 0; $i < count($process_names); $i++) {
    $pname = $conn->real_escape_string($process_names[$i]);
    $p_pcs = (int)$pcs[$i];
    $p_carat = (float)$carats[$i];
    $p_percentage = (float)$percentages[$i];

    $sql = "INSERT INTO processes (process_name, pcs, carat, percentage) 
            VALUES ('$pname', '$p_pcs', '$p_carat', '$p_percentage')";

    $conn->query($sql);
}

$conn->close();

echo "<script>alert('Data saved successfully!'); window.location.href='dataentry.html';</script>";
?>
