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

    $select_query = "SELECT * FROM `employee_master` WHERE `Employee_Name`='$name'";
    $result = mysqli_query($conn, $select_query);

    if ($result)
    {
        $row = mysqli_fetch_assoc($result);
        $d_id = $row["Employee_ID"];
        $delete_query = "DELETE FROM `employee_master` WHERE `Employee_Name`='$name'";
        print_r($delete_query);
        $result = mysqli_query($conn, $delete_query);

        $select_query1 = "SELECT * FROM `address_master` WHERE `Employee_Master_ID`='$d_id'";
        $result = mysqli_query($conn, $select_query1);

        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
            $d_id = $row["Address_ID"];
            $delete_query1 = "DELETE FROM `address_master` WHERE `Employee_Master_ID`='$d_id'";
            print_r($delete_query1);
            $result = mysqli_query($conn, $delete_query1);

            $select_query2 = "SELECT * FROM `phone_master` WHERE `Address_ID`='$d_id'";
            $result = mysqli_query($conn, $select_query2);

            if ($result)
            {
                $row = mysqli_fetch_assoc($result);
                $d_id = $row["Phone_ID"];
                $delete_query2 = "DELETE FROM `phone_master` WHERE `Phone_ID`='$d_id'";
                print_r($delete_query2);
                $result = mysqli_query($conn, $delete_query2);
                echo "Record deleted successfully";
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
