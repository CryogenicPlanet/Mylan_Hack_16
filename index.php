  <?php
$search = $_POST['search'];
$servername = "sql305.0fees.us";
$username = "0fe_17703085";
$password = "cancer";
$dbname ="0fe_17703085_phorum";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ID, Effects FROM Forum ORDER BY ID Desc";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

      $strpar = $row['Effects'];
      $pos = strpos($strpar,$search);
     
      if ($pos != false) {
        $Id = $row['ID'];
echo "hi";
        header("Location: www.phorum.0fees.us/forum/index.php?Id=$Id");
        exit;

      }

    }
} else {
    echo "0 results";
}
$conn->close();
?>

