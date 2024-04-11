<?php
    $userID = $_REQUEST["userID"];
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    $repasword = $_REQUEST["repasword"];
    $birthday = $_REQUEST["birthday"];

    $email = $_REQUEST["email"];
    $security_question = $_REQUEST["security_question"];
    $answer = $_REQUEST["answer"];
    include "connect.php";
    //echo $userID;
    // echo $password;
    // echo $repasword;

    if($password != $repasword){
        header('refresh:3; url=signup.html');
		echo "Please confirm your password again!";
        exit;
    }

    if(connectToDB()){
        $cmd = "SELECT * FROM blog_users WHERE userID = $userID";
        $result = executePlainSQL($cmd);
        // echo $cmd;
        // echo $result;
		$row = OCI_Fetch_Array($result, OCI_BOTH);
        // echo $row[0];
        // echo var_dump($userID);
        // echo var_dump($row[0]);
        if($row[0]==$userID){
            echo "UserID already exists!";
        }else{
            $cmd = "INSERT INTO blog_users    VALUES($userID,'$username','$birthday','$password',0)";
            executePlainSQL($cmd);

            $cmd = "INSERT INTO SecurityInfo_Of    VALUES($userID,'$email','$security_question','$answer')";
            executePlainSQL($cmd);

            echo "Succesfully created!";
            header('refresh:3; url=login.html');
        }
        OCICommit($db_conn);
        disconnectFromDB();
        
    }else{
        echo "Please check your connection!";
    }
?>