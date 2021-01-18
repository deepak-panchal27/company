<?php
require_once ('../config.php');

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$name = $department = $address1 = $address2 = $address3 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    if (empty($_POST["name"]))
    {
        $nameErr = "Employee Name is required";
        echo $nameErr;
        exit;
    }
    elseif (empty($_POST["department"]))
    {
        $nameErr = "Department Name is required";
        echo $nameErr;
        exit;
    }
    elseif (empty($_POST["address1"]))
    {
        $nameErr = "Address1 is required";
        echo $nameErr;
        exit;
    }
    elseif (empty($_POST["address2"]))
    {
        $nameErr = "Address2 is required";
        echo $nameErr;
        exit;
    }
    elseif (empty($_POST["address3"]))
    {
        $nameErr = "Address3 is required";
        echo $nameErr;
        exit;
    }
    elseif (empty($_POST["phone1"]))
    {
        $nameErr = "Phone no1 is required";
        echo $nameErr;
        exit;
    }
    elseif (empty($_POST["phone2"]))
    {
        $nameErr = "Phone no2 is required";
        echo $nameErr;
        exit;
    }
    elseif (empty($_POST["phone3"]))
    {
        $nameErr = "Phone no3 is required";
        echo $nameErr;
        exit;
    }
    elseif (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["name"]) || !preg_match("/^[a-zA-Z-' ]*$/", $_POST["department"]) || !preg_match("/^[a-zA-Z-' ]*$/", $_POST["address1"]) || !preg_match("/^[a-zA-Z-' ]*$/", $_POST["address2"]) || !preg_match("/^[a-zA-Z-' ]*$/", $_POST["address3"]))
    {
        $nameErr = "Only letters and white space allowed";
        echo $nameErr;
        exit;
    }
    elseif (!preg_match('/^\d{10}$/', $_POST["phone1"]) || !preg_match('/^\d{10}$/', $_POST["phone2"]) || !preg_match('/^\d{10}$/', $_POST["phone3"]))
    {
        $nameErr = "Please enter 10 digit numbers only";
        echo $nameErr;
        exit;
    }
    else
    {
        $name = test_input($_POST["name"]);
        $department = test_input($_POST["department"]);
        $address1 = test_input($_POST["address1"]);
        $address2 = test_input($_POST["address2"]);
        $address3 = test_input($_POST["address3"]);
        $phoneno = test_input($_POST["phone1"]);
        $phoneno2 = test_input($_POST["phone2"]);
        $phoneno3 = test_input($_POST["phone3"]);
    }

    $select_query = "SELECT * FROM `department` WHERE `Department_Name`='$department'";
    $result = mysqli_query($conn, $select_query);

    if ($result)
    {
        $row = mysqli_fetch_assoc($result);
        $d_id = $row["Department_ID"];
        $update_query = "INSERT INTO `employee_master`(`Department_ID`,`Employee_Name`) VALUES ('$d_id','$name')";
        $result = mysqli_query($conn, $update_query);

        $select_query = "SELECT * FROM `employee_master` WHERE `Employee_Name`='$name'";
        $result = mysqli_query($conn, $select_query);

        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
            $d_id = $row["Employee_ID"];
            $update_query = "INSERT INTO `address_master`(`Employee_Master_ID`, `Address1`, `Address2`, `Address3`) VALUES ('$d_id','$address1','$address2','$address3')";
            $result = mysqli_query($conn, $update_query);

            $select_query = "SELECT * FROM `address_master` WHERE `Employee_Master_ID`='$d_id'";
            $result = mysqli_query($conn, $select_query);

            if ($result)
            {
                $row = mysqli_fetch_assoc($result);
                $d_id = $row["Address_ID"];
                $update_query = "INSERT INTO `phone_master`(`Address_ID`, `Phone_No`,`Phone_No2`,`Phone_No3`) VALUES ('$d_id','$phoneno','$phoneno2','$phoneno3')";
                $result = mysqli_query($conn, $update_query);
                echo "New record created successfully";
            }
        }
    }
    else
    {
        echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

}
?>
