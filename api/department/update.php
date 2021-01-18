<?php
require_once ('../config.php');

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$oldname = $newname = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    if (empty($_POST["oldname"]))
    {
        $nameErr = "Old Department Name is required";
        echo $nameErr;
        exit;
    }
    elseif (empty($_POST["newname"]))
    {
        $nameErr = "New Department Name is required";
        echo $nameErr;
        exit;
    }
    elseif (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["oldname"]) || !preg_match("/^[a-zA-Z-' ]*$/", $_POST["newname"]))
    {
        $nameErr = "Only letters and white space allowed";
        echo $nameErr;
        exit;
    }
    else
    {
        $oldname = test_input($_POST["oldname"]);
        $newname = test_input($_POST["newname"]);
    }

    $select_query = "SELECT * FROM `department` WHERE `Department_Name`='$oldname'";

    $result = mysqli_query($conn, $select_query);

    if (mysqli_num_rows($result) > 0)
    {

        $row = mysqli_fetch_assoc($result);
        $d_id = $row["Department_ID"];
        $update_query = "UPDATE `department` SET `Department_Name`='$newname' WHERE `Department_ID`='$d_id'";
        $result = mysqli_query($conn, $update_query);
        echo "Record updated successfully";
    }
    else
    {
        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
