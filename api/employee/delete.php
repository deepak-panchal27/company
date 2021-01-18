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
        $update_query = "DELETE FROM `employee_master` WHERE `Employee_Name`='$name'";
        $result = mysqli_query($conn, $update_query);

        $select_query = "SELECT * FROM `address_master` WHERE `Employee_Master_ID`='$d_id'";
        $result = mysqli_query($conn, $select_query);

        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
            $d_id = $row["Address_ID"];
            $update_query = "DELETE FROM `address_master` WHERE `Employee_Master_ID`='$d_id'";
            $result = mysqli_query($conn, $update_query);

            $select_query = "SELECT * FROM `phone_master` WHERE `Address_ID`='$d_id'";
            $result = mysqli_query($conn, $select_query);

            if ($result)
            {
                $row = mysqli_fetch_assoc($result);
                $d_id = $row["Phone_ID"];
                $update_query = "DELETE FROM `phone_master` WHERE `Phone_ID`='$d_id'";
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
