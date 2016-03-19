  <?php
$search = $_Get['search'];
$servername = "	ftp.0fees.us";
$username = "0fe_17703085";
$password = "cancer";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT Id, Drugs, Effects FROM Forum ORDER BY Id Desc";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $strpar = $row['Effects'];
      $pos = strpos($strpar,$search);
      if ($pos== true) {
        $Id = $row['Id'];
        header("Loacation: www.phorum.0fees.us/forum/index.php?Id=$Id ");
        die();

      }

    }
} else {
    echo "0 results";
}
$conn->close();
?>
?>
