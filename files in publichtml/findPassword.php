<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Password</title>
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
    
<form method = "GET" action="findPassword.php">
    <h2> Find Password</h2>

            <p >Enter Your Email and Click Confirm Please:</p>
            <input type="text" name = "email" placeholder = "email">
            <input class = "btn" type="submit" value="confirm" name="confirm">
    
</form>


<?php
session_save_path('/home/r/rjin02/public_html');
session_start();
$email = NULL;
$answer = NULL;

include "connect.php";

function enter_answer($quesion){
    echo "<h1> Please answer this question: <br> $quesion  </h1>";
            // <form method = \"GET\" action=\"\">
            //     <input type=\"text\" name = \"answer\" placeholder = \"answer\">
            //     <input type=\"submit\" value=\"confirm\" name=\"confirm_answer\">
            // </form>";
    if(isset($_GET['confirm_answer'])){
        echo "set";
    }
}

function check_answer($answer){
    if(connectToDB()){
        $cmd = "SELECT * FROM answer";
        $result = executePlainSQL($cmd);
        $row = OCI_Fetch_Array($result, OCI_BOTH);
        echo $row[0];
        echo $row[1];
    }
}

function handleConfirm(){
    $email = $_GET["email"];
    $_SESSION['email'] = $email;
    if(connectToDB()){
        $cmd = "SELECT * FROM SecurityInfo_Of WHERE email = '$email'";
        $result = executePlainSQL($cmd);
        $row = OCI_Fetch_Array($result, OCI_BOTH);
            //echo $row[1];
        if(stringIsEqual($row[1], $email)){
            echo "<h1> Email does not exists! Refresh in 3 seconds !<h1>";
            header('refresh:3; url=findPassword.php');
        }else{
            $answer = $row[3];
            $_SESSION['answer'] = $answer;
            // $cmd = "CREATE TABLE answer(email CHAR(300) NOT NULL, answer CHAR(300) NOT NULL, PRIMARY KEY (email))";
            // executePlainSQL($cmd);
            // echo $answer;
            // echo var_dump($email);
            // echo var_dump($answer);
             enter_answer($row[2]);
            // $cmd = "GRANT SELECT ON answer TO public";
            // executePlainSQL($cmd);
            // $cmd = "INSERT INTO answer VALUES('$email', '$answer')";
            // // echo $cmd;
            // executePlainSQL($cmd);
        }
    }
    OCICommit($db_conn);
    disconnectFromDB();
}

if (isset($_GET['confirm'])){
    handleConfirm();
}
 
?>

<form method = "GET" action="findPassword.php">
            <p >Enter Your Answer and click Confirm Please:</p>
            <input type="text" name = "answer" placeholder = "answer">
            <input class = "btn" type="submit" value="submit" name="submit_answer">
</form>

<?php
if(isset($_GET['submit_answer'])){
    session_save_path('/home/r/rjin02/public_html');
    session_start();
    $email = $_SESSION['email'];
    $answer = $_SESSION['answer'];
    $getAnswer = $_GET["answer"];
    if(stringIsEqual($getAnswer, $answer)){
        if(connectToDB()){
            // echo $_SESSION['email'];
            // echo $email;
            $cmd = "SELECT * FROM SecurityInfo_Of WHERE email = '$email'";
            $result = executePlainSQL($cmd);
            $row = OCI_Fetch_Array($result, OCI_BOTH);

            $userID =  $row[0];

            $cmd = "SELECT * FROM blog_users WHERE userID = $userID";
            $result = executePlainSQL($cmd);
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<h1> Your password is: $row[3]";

        }
        
    }
}
?>

</body>
</html>
