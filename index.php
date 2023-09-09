<?php
session_start();
require_once("pdo.php");
$sql = "SELECT `profile_id`, `first_name`, `last_name`, `headline` FROM `profile`";
$result = $pdo->query($sql);
?>



<!DOCTYPE html>
<html>

<head>
    <title>Ameen Mohammad Said's Resume Registry</title>
    <!-- bootstrap.php - this is HTML -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
        integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>


<body>
    <div class="container">
        <h1>Ameen Mohammad Said's Resume Registry</h1>
        <?php ?>
        <?php if (isset($_SESSION['name']) && isset($_SESSION['user_id'])) {

            echo '<p><a href="logout.php">Logout</a></p>
    <p><a href="add.php">Add New Entry</a></p>';
            if (isset($_SESSION['inserted']) && $_SESSION['inserted'] == true) {
                echo "<span style='color: green;'>" . htmlspecialchars("Profile added") . "</span>";
                unset($_SESSION['inserted']);
            }
            if (isset($_SESSION['updated']) && $_SESSION['updated'] == true) {
                echo "<span style='color: green;'>" . htmlspecialchars("solutions_Profile updated") . "</span>";
                unset($_SESSION['updated']);
            }
            if (isset($_SESSION['deleted']) && $_SESSION['deleted'] == true) {
                echo "<span style='color: green;'>" . htmlspecialchars("Profile deleted") . "</span>";
                unset($_SESSION['deleted']);
            }
           
            if ($result == true) {
                echo '
<table border="1">
<tr><th>Name</th><th>Headline</th><tr>';
                foreach ($result as $row) {
                    echo
                        '<tr><td>

<a href="view.php?profile_id=' . $row['profile_id'] . '">' . $row['first_name'] . $row['last_name'] . '</a></td><td>' .
                        $row['headline'] . '</td><td><a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a></td></tr>';
                }
                echo '</table>';
            }
        } else {
            echo '<p><a href="login.php">Please log in</a></p>';
            if ($result == true) {
                echo '
    <table border="1">
    <tr><th>Name</th><th>Headline</th><tr>';
                foreach ($result as $row) {
                    echo
                        '<tr><td>
    
    <a href="view.php?profile_id=' . $row['profile_id'] . '">' . $row['first_name'] . $row['last_name'] . '</a></td><td>' .
                        $row['headline'] . '</td></tr>';
                }
                echo '</table>';
            }
        }
        ?>

        <p>
            <b>Note:</b> Your implementation should retain data across multiple
            logout/login sessions. This sample implementation clears all its
            data periodically - which you should not do in your implementation.
        </p>
    </div>
</body>