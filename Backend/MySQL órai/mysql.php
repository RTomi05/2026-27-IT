<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proba2026";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

if (mysqli_query($conn, $sql)) {
  echo "Table created successfully";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

$conn -> close();

//var_dump($conn);



$conn2 = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn2) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully\n";

if (mysqli_query($conn, $sql)) {
  echo "Table created successfully";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn2);
//var_dump($conn2);

try {
  $conn3 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully\n";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
$conn3 = null;

//unsigned - nemnegatív számok

$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com')";

if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$result = $conn->query($sql);

?>