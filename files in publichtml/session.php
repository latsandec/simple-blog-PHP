<?php
session_start();
if(isset($_SESSION["login"])){
    include "connect.php";
}else{
    ?>
    <script>
        alert("Login Please!");
        window.location.href="index.html";
    </script>
    <?php
}
?>