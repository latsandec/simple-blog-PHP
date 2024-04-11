    <?php 
	include "connect.php";
	header('Content-type:text/html; charset=utf-8');
	// start Session
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
				# 用户名和密码都正确,将用户信息存到Session中
				$_SESSION['username'] = $username;
				$_SESSION['islogin'] = 1;
				echo "succeed";
				header("refresh:0;url=admin.html");
				// 处理完附加项后跳转到登录成功的首页
				// header('location:index.php');
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
