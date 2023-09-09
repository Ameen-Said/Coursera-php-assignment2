<?php
session_start();
require_once("pdo.php");



if (isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
    $username = $_SESSION['name'];
    $user_id = $_SESSION['user_id'];
} else {
    die("ACCESS DENIED");
}

if (isset($_GET['profile_id'])) {
    $p_id = $_GET['profile_id'];
}

if (
    isset($_POST['first_name']) &&
    isset($_POST['last_name']) &&
    isset($_POST['email']) &&
    isset($_POST['headline']) &&
    isset($_POST['summary'])
) {
    if (strpos($_POST['email'], "@")) {
        $f_name = $_POST['first_name'];
        $l_name = $_POST['last_name'];
        $email = $_POST['email'];
        $headline = $_POST['headline'];
        $summary = $_POST['summary'];

        // Use prepared statements to prevent SQL injection
        $sql = "UPDATE `profile` 
        SET first_name = :f_name,
            last_name = :l_name,
            email = :email,
            headline = :headline,
            summary = :summary
        WHERE user_id = :user_id
        AND profile_id = :p_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":f_name", $f_name);
        $stmt->bindValue(":l_name", $l_name);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":headline", $headline);
        $stmt->bindValue(":summary", $summary);
        $stmt->bindValue(":p_id", $p_id);

        $result = $stmt->execute();

        if ($result == 1) {
            $_SESSION['updated'] = true;

            header("Location:index.php");
            return;
        }
    } else {
        $_SESSION['email_check'] = true;
    }
} else {
    $_SESSION['empty_fields'] = true;
}



if (isset($p_id)) {
    $sql = "SELECT * FROM `profile` WHERE profile_id = :p_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':p_id', $p_id);
    $stmt->execute();
    $selectedRow = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Ameen Mohammad Said's Profile Edit</title>
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
        <h1>Editing Profile for
            <?php echo $_SESSION['name']; ?>
        </h1>
        <form method="post">
            <?php
            if (isset($_SESSION['empty_fields']) && $_SESSION['empty_fields'] == true) {
                echo "<span style='color: red;'>" . htmlspecialchars("All fields are required") . "</span>";
                unset($_SESSION['empty_fields']);
            } elseif (isset($_SESSION['email_check']) && $_SESSION['email_check'] == true) {
                echo "<span style='color: red;'>" . htmlspecialchars("Email address must contain @") . "</span>";
                unset($_SESSION['email_check']);
            } ?>
            <p>First Name:
                <input type="text" name="first_name" value="<?= htmlentities($selectedRow['first_name']) ?>"
                    size="60" />
            </p>
            <p>Last Name:
                <input type="text" name="last_name" value="<?= htmlentities($selectedRow['last_name']) ?>" size="60" />
            </p>
            <p>Email:
                <input type="text" name="email" value="<?= htmlentities($selectedRow['email']) ?>" size="30" />
            </p>
            <p>Headline:<br />
                <input type="text" name="headline" value="<?= htmlentities($selectedRow['headline']) ?>" size="80" />
            </p>
            <p>Summary:<br />
                <textarea name="summary" rows="8" cols="80"><?= htmlentities($selectedRow['summary']) ?></textarea>
            <p>
                <input type="submit" value="Save">
                <input type="submit" name="cancel" value="Cancel">
            </p>
        </form>
    </div>
</body>

</html>