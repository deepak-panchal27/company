<?php
require_once ('../config.php');

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$name = "";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $sql = "SELECT * FROM `department`";

    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
          $final = json_encode($row);
          print_r($final);
        }
      } else {
        echo "0 results";
      }

    mysqli_close($conn);

}
?>
