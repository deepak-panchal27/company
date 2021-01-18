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

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    if (empty($_POST["name"]))
    {
        $nameErr = "Department Name is required";
        echo $nameErr;
        exit;
    }
    elseif (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["name"]))
    {
        $nameErr = "Only letters and white space allowed";
        echo $nameErr;
        exit;
    }
    else
    {
        $name = test_input($_POST["name"]);
    }

    $sql = "DELETE FROM `department` WHERE `Department_Name`='$name'";

    if (mysqli_query($conn, $sql))
    {
        echo "Record deleted successfully";
    }
    else
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

}
?>
