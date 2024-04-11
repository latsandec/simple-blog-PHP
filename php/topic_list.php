<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Topics you Love</title>
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
    <h1>Topic Search</h1>
    <h2 id= "admin">Search topics that <span class="power">YOU</span> love</h2>
    <img class="bottom-code" src="binary-code.png" alt="code-img">
    <img class="programming-gif" src="programming.png" alt="animation-img">
  </div>

  <div class="middle-container">
    <h2>Enter Topic to Find Community You Love</h2>
    <p>Ex. you can search "Anime" "Cook" "Music" "Sports" "IT" to find communities.</p>
    <form method="POST" action="topic_list.php"> 
    <input type="hidden" id="showTopicCommunityRequest" name="showTopicCommunityRequest">
    Interested Topic: <input type="text" name="Topic"> <br /><br />
    <input class = "btn" type="submit" value="Search" name="searchtopic"></p>
    </form>
  </div>

  <div class="top-container">
    <h2>Hunt Topic with Level</h2>
    <p>Ex. you can find out our hottest topic where level is greater than you expect</p>
    <form method="POST" action="topic_list.php"> 
    <input type="hidden" id="showLevelCommunityRequest" name="showLevelCommunityRequest">
    Level At Least: <input type="text" name="Level"> <br /><br />
    <input class = "btn" type="submit" value="Search" name="searchlevel"></p>
    </form>
  </div>

  <div class="middle-container">
      <h2>Go To Community</h2>
      <p>If you want to view the community page, press on the button</p>
      <form method="GET" action="community_list.php">
        <input type="hidden" id="communityRequest" name="communityRequest">
        <input class = "btn" type="submit" value="Go" name="communitySubmit"></p>
      </form>
    </div>


  <?php
        include "connect.php";

        function handleSearchTopicRequest() {
            global $db_conn;
            $topic = $_REQUEST['Topic'];

            if ($topic !== '') {
                // $result = executePlainSQL("SELECT C.CommunityID, C.community_level FROM Community C
                //                             Where NOT EXISTS (
                //                                 (SELECT CommunityID 
                //                                     FROM Community)
                //                                     MINUS 
                //                                     (SELECT A.CommunityID 
                //                                     FROM About A, Community CO
                //                                     WHERE A.CommunityID = CO.CommunityID AND A.topic_name = '$topic')
                //                             )" ); 

                                            //list community that have the topic
                                            //community that except with the topic
                                            //community that with the topic
                //属于是暂时放弃这个玩意了，我重做了sql去达到同样的功能 for fun。
                $result = executePlainSQL("SELECT a.communityID
                                           FROM About a
                                           Where a.topic_name = '$topic'");
            } else {
                echo "<br>Please enter topic.<br>";
            }

            echo "<br>Community List:<br>";
            echo "<table>";
            echo "<tr><th>Community ID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; 
            }

            echo "</table>";
        }

        function handleCommunityLevelRequest() {
            global $db_conn;
            // $topic = $_REQUEST['Topic'];
            $level = $_REQUEST['Level'];
            settype($level, "integer");

            if ($level !== '') {
                $result = executePlainSQL("SELECT topic_name, COUNT(*)
                                            from Community C, About A
                                            WHERE C.CommunityID = A.CommunityID and C.community_level > '$level'
                                            GROUP BY topic_name" );
            } else {
                echo "<br>Please enter level.<br>";
            }

            echo "<br>Hot Topic List:<br>";
            echo "<table>";
            echo "<tr><th>Topic</th><th>Popularity</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
            }

            echo "</table>";
        }

        function handleCommunityRequest() {
            header("refresh:0;url=community_list.php");
        }

        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('searchtopic',$_POST)) {
                    handleSearchTopicRequest();
                } else if (array_key_exists('searchlevel',$_POST)) {
                    handleCommunityLevelRequest();
                } else if (array_key_exists('topicRequest', $_GET)) {
                    handleCommunityRequest();
                }
                disconnectFromDB();
            }
        }

        if (isset($_POST['searchtopic']) || isset($_POST['searchlevel']) || isset($_GET['communitySubmit'])) {
            handlePOSTRequest();
        }
    
    ?>