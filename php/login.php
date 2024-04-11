<?php 
	include "connect.php";
	header('Content-type:text/html; charset=utf-8');
	// start Session
	session_save_path('/home/r/rjin02/public_html');
	session_start();
	
	// retrive user data
	
	if(connectToDB()){
		if (isset($_POST['login'])) {
			
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			
			$cmd = "SELECT * FROM blog_users WHERE userID = $username";
			
			$result = executePlainSQL($cmd);
			$row = OCI_Fetch_Array($result, OCI_BOTH);
			

			OCICommit($db_conn);
			
			if (($username == '') || ($password == '')) {
				// if it is blank, go back to the login page
				header('refresh:3; url=login.html');
				echo "Wrong username or password!";
				exit;
			}elseif (stringIsEqual($password,$row[3])) {
				$_SESSION['username'] = $username;
				$_SESSION['islogin'] = 1;
				echo "succeed";
				header("refresh:0;url=blog_list.php");
			}else {
				# wrong password, same as the first case
				header('refresh:3; url=login.html');
				echo "Wrong username or password!";
				exit;
			} 
		}
		disconnectFromDB();
	}

	
 ?>
</body>
</html>
