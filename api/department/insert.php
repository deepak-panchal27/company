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

    $sql = "INSERT INTO `department`(`Department_Name`) VALUES ('$name')";

    if ($conn->query($sql) === true)
    {
        echo "New record created successfully";
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

}
?>