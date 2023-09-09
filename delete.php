<?php
session_start();
require_once("pdo.php");

$email_check = false;
$empty_fields = false;


if(isset($_POST['cancel'])){
    header("Location:index.php");
    return;
}

if (isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
    $username = $_SESSION['name'];
    $user_id = $_SESSION['user_id'];
} else {
    die("ACCESS DENIED");
}

if(isset($_GET['profile_id'])){
    $p_id = $_GET['profile_id'];
    $sql = "SELECT * FROM `profile` WHERE profile_id = :p_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':p_id', $p_id);
    $stmt->execute();
    $selectedRow = $stmt->fetch(PDO::FETCH_ASSOC);
}

if(isset($_GET['profile_id'])){
    $p_id = $_GET['profile_id'];

    $stmt = $pdo->prepare("DELETE FROM `profile` WHERE profile_id = :p_id");
    $stmt->bindParam(':p_id', $p_id);
    if(isset($_POST['delete'])){
    $result = $stmt->execute();

    if($result == 1){
        $_SESSION['deleted'] = true;
    }
    
    header("Location: index.php"); 
    return;
    }
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Ameen Mohammad Said's Profile Add</title>
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
<h1>Deleteing Profile</h1>
<form method="post" >
<p>First Name:
<?php echo $selectedRow['first_name']; ?></p>
<p>Last Name:
<?php echo $selectedRow['last_name']; ?></p>
<input type="hidden" name="profile_id"
value="123"
/>
<input type="submit" name="delete" value="Delete">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
