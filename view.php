<?php 
require_once("pdo.php");

if(isset($_GET['profile_id'])){
    $sql = "SELECT * FROM `profile` WHERE `profile_id` = :p_id ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':p_id' => $_GET['profile_id']));
    $row =  $stmt->fetch(PDO::FETCH_ASSOC);
}





?>

<!DOCTYPE html>
<html>
<head>
<title>Ameen Mohammad Said's Profile View</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Profile information</h1>
<p>First Name:
<?php echo $row['first_name'];?></p>
<p>Last Name:
<?php echo $row['last_name'];?></p>
<p>Email:
 <?php echo $row['email'];?></p>
<p>Headline:<br/>
<?php echo $row['headline'];?></p>
<p>Summary:<br/>
<?php echo $row['summary'];?><p>
</p>
<a href="index.php">Done</a>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
