<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Super Powerful Admin</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=MonteCarlo&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Gowun+Dodum&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>

    <body>
    <div class="top-container">
    <img class="top-code" src="binary-code.png" alt="code-img">
    <h1>Even Stronger</h1>
    <h2 id= "admin">You know what, you are <span class="power">Stronger</span> Now!</h2>
    <img class="bottom-code" src="binary-code.png" alt="code-img">
    <img class="programming-gif" src="programming.png" alt="animation-img">
    </div>

    <div class="middle-container">
        <form class="" action="superAdmin.php" method="GET">
            <h2>Super Administrator</h2>
            <p>You can access two attributes from any table you want</p>
                <input type="text" name ="attribute1" placeholder="attribute1">
                <input type="text" name ="attribute2" placeholder="attribute2">
                <input type="text" name ="table" placeholder="table name">
                <input type="text" name ="field1" placeholder="field1">
                <!-- <input type="text" name ="field2" placeholder="field2"> -->
                <input type="text" name ="var1" placeholder="var1">
                <input type="text" name ="condition" placeholder="selection condition">
                <input class = "btn" type="submit" name="submit" value="confirm">
            
            <p>Input two attribute you want to select, the name of the table, and constraint of field1 (condition) var1.</p>
        </form>
    </div>
    <div class="top-container">
    <form class="" action="superAdmin.php" method="GET">
            <h2>Change VIP</h2>
            <p>You can update the vip level the preferred color</p>
                <input type="text" name ="vipID" placeholder="vipID">
                <input type="text" name ="attribute5" placeholder="attribute you want to update">
                <input type="text" name ="value" placeholder="value">
                <input type="submit" name="submit2" value="confirm">
        </form>
    </div>

    <div class="top-container">
      <h2>View number of users according to ban status</h2>
      <p>View number of users according to ban status which the larger is greater than</p>
      <form method="GET" action="superAdmin.php">
        <input type="text" name ="number" placeholder="number">
        <input class = "btn" type="submit" value="confirm" name="submit3"></p>
      </form>
    </div>

    <div class="middle-container">
      <h2>Go To Admin</h2>
      <p>If you want to view the Admin page, press on the button</p>
      <form method="GET" action="admin.php">
        <input type="hidden" id="adminRequest" name="adminRequest">
        <input class = "btn" type="submit" value="Go" name="adminSubmit"></p>
      </form>
    </div>
    </div>
    
    

    

<?php
include "connect.php";
$attribute1 = $_REQUEST["attribute1"];
$attribute2 = $_REQUEST["attribute2"];
$table = $_REQUEST["table"];
$field1 = $_REQUEST["field1"];
$var1 = $_REQUEST["var1"];
$vipID = $_REQUEST["vipID"];
$attributeUpdate = $_REQUEST["attribute5"];
$value = $_REQUEST["value"];
$num = $_REQUEST["number"];
$condition = $_REQUEST["condition"];

if(isset($_GET['submit'])){
    // echo "Good";
    if(connectToDB()){
        $cmd = "SELECT $attribute1, $attribute2 FROM $table WHERE $field1 $condition $var1";
        $result = executePlainSQL($cmd);
        //echo $cmd;
        echo "<br>Result<br>";
        echo "<table>";
        echo "<tr><th>$attribute1</th><th>$attribute2</th></tr>";

        while($row = OCI_Fetch_Array($result, OCI_BOTH)){
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";
        }

        
    }
}elseif(isset($_GET['submit2'])){
    // echo $vipID;
    // echo $attributeUpdate;
    if(connectToDB()){
        $cmd = "UPDATE VIP SET $attributeUpdate = $value WHERE vipID = $vipID";
        $result = executePlainSQL($cmd);  
        OCICommit($db_conn);
    }
}elseif(isset($_GET['submit3'])){
    if(connectToDB()){
        $cmd = "SELECT ban_status, COUNT(*)
        from Blog_Users
        GROUP BY ban_status
        Having COUNT(*) > $num";
        $result = executePlainSQL($cmd);  
        OCICommit($db_conn);

        echo "<br>Result<br>";
        echo "<table>";
        echo "<tr><th>ban_status</th><th>number</th></tr>";

        while($row = OCI_Fetch_Array($result, OCI_BOTH)){
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";
        }
    }
}

function handleAdminRequest() {
    header("refresh:0;url=admin_list.php");
}

function handlePOSTRequest() {
    if (connectToDB()) {
        if (array_key_exists('adminRequest', $_GET)) {
            handleAdminRequest();
        }
        disconnectFromDB();
    }
}

if (isset($_GET['adminSubmit'])) {
    handlePOSTRequest();
}
    disconnectFromDB();

?>
    
</body>
</html>