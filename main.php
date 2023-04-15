<!DOCTYPE html>
<html>
<head>
  <title>Address Form</title>
</head>
<body>
  <?php
   
    $address = $city = $state = "";
    $addressErr = $cityErr = $stateErr = "";
    $successMsg = "";
    
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["address"])) {
        $addressErr = "Address is required";
      } else {
        $address = test_input($_POST["address"]);
      }

      if (empty($_POST["city"])) {
        $cityErr = "City is required";
      } else {
        $city = test_input($_POST["city"]);
      }

      if (empty($_POST["state"])) {
        $stateErr = "State is required";
      } else {
        $state = test_input($_POST["state"]);
        if (!preg_match("/^[a-zA-Z]{2}$/", $state)) {
          $stateErr = "State must be a valid two-letter abbreviation";
        }
      }

      if (empty($addressErr) && empty($cityErr) && empty($stateErr)) {
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "myDB";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO addresses (address, city, state) VALUES ('$address', '$city', '$state')";

        if (mysqli_query($conn, $sql)) {
          $successMsg = "Address inserted successfully";
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
      }
    }
  ?>

  <h2>Enter Your Address</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?php echo $address;?>">
    <span class="error"><?php echo $addressErr;?></span>
    <br><br>
    <label for="city">City:</label>
    <input type="text" id="city" name="city" value="<?php echo $city;?>">
    <span class="error"><?php echo $cityErr;?></span>
    <br><br>
    <label for="state">State:</label>
    <input type="text" id="state" name="state" value="<?php echo $state;?>">
    <span class="error"><?php
