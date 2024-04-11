<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Community</title>
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
    <div class="top-container">
    <img class="top-code" src="binary-code.png" alt="code-img">
    <h1>Hug Community</h1>
    <h2 id= "admin">Join <span class="power">Community</span> Any Time!</h2>
    <img class="bottom-code" src="binary-code.png" alt="code-img">
    <img class="programming-gif" src="programming.png" alt="animation-img">
    </div>


    <div class="middle-container">
    <h2>Enter Community ID to view Blogs</h2>
    <form method="GET" action="community_list.php"> 
    <input type="hidden" id="viewCommunityRequest" name="viewCommunityRequest">
    ID: <input type="text" name="communityID"> <br /><br />
    <input class = "btn" type="submit" value="Submit" name="submit"></p>
    </form>
  </div>

  <div class="top-container">
    <h2>Community List</h2>
    <p>If you want to view the community list, press on the view button</p>
    <form method="GET" action="community_list.php"> 
      <input type="hidden" id="listCommunityRequest" name="listCommunityRequest">
      <input class = "btn" type="submit" value="View" name="listSubmit"></p>
    </form>
  </div>

  <div class="middle-container">
      <h2>Go To Topics</h2>
      <p>If you want to view the topic page, press on the button</p>
      <form method="GET" action="community_list.php">
        <input type="hidden" id="topicRequest" name="topicRequest">
        <input class = "btn" type="submit" value="Go" name="topicSubmit"></p>
      </form>
    </div>


        <?php
        include "connect.php";
        session_save_path('/home/r/rjin02/public_html');
        session_start();
        
        function handleViewRequest() {
            $communityID = $_GET['communityID'];
                    
            if ($communityID !== '') {
                $result = executePlainSQL("SELECT * FROM Community WHERE communityID = $communityID");
                $row = OCI_Fetch_Array($result, OCI_BOTH); 
                if ($row[0]){
                    $_SESSION['community'] = $row[0];
                    header("refresh:0;url=blog_list.php");
                } else {
                    echo "<br>Result not found.<br>";
                }
            }else {
                echo "<br>Please enter ID.<br>";
            }
        }

        function handleListRequest() {
            $result = executePlainSQL("SELECT * FROM Community");

            echo "<br>Community List:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Level</th><th>Topics</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td>"; 
                $communityID = $row[0];
                $topics = executePlainSQL("SELECT topic_name FROM About WHERE communityID = $communityID");
                while ($topic = OCI_Fetch_Array($topics, OCI_BOTH)) {
                    echo "<td>" . $topic[0] . "</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        }

        function handleTopicRequest() {
            header("refresh:0;url=topic_list.php");
        }

        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('viewCommunityRequest', $_GET)) {
                    handleViewRequest();
                } else if (array_key_exists('listCommunityRequest', $_GET)) {
                    handleListRequest();
                } else if (array_key_exists('topicRequest', $_GET)) {
                    handleTopicRequest();
                }

                disconnectFromDB();
            }
        }
        

		if (isset($_GET['submit']) || isset($_GET['listSubmit']) || isset($_GET['topicSubmit'])) {
            handleGETRequest();
        } 

	?>
	</body>
</html>
