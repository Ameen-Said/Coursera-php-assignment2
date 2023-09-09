<?php
session_start();
require_once("pdo.php");

// Check if the user is logged in
if (isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
    $username = $_SESSION['name'];
    $user_id = $_SESSION['user_id'];
} else {
    die("ACCESS DENIED");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $f_name = $_POST['first_name'];
    $l_name = $_POST['last_name'];
    $email = $_POST['email'];
    $headline = $_POST['headline'];
    $summary = $_POST['summary'];

    // Input validation
    if (empty($f_name) || empty($l_name) || empty($email) || empty($headline) || empty($summary)) {
        $_SESSION['empty_fields'] = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_check'] = true;
    } else {
        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO `profile` (user_id, first_name, last_name, email, headline, summary) VALUES (:user_id, :f_name, :l_name, :email, :headline, :summary)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":f_name", $f_name);
        $stmt->bindValue(":l_name", $l_name);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":headline", $headline);
        $stmt->bindValue(":summary", $summary);

        $result = $stmt->execute();

        if ($result) {
            $_SESSION['inserted'] = true;
            header("Location: index.php");
            return;
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Ameen Mohammad Said's Profile Add</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Adding Profile for <?php echo htmlspecialchars($username); ?></h1>
        <form method="post">
            <?php
            if (isset($_SESSION['empty_fields']) && $_SESSION['empty_fields']) {
                echo "<span style='color: red;'>All fields are required.</span>";
                unset($_SESSION['empty_fields']);
            } elseif (isset($_SESSION['email_check']) && $_SESSION['email_check']) {
                echo "<span style='color: red;'>Email address must be valid.</span>";
                unset($_SESSION['email_check']);
            }
            ?>
            <p>First Name:
                <input type="text" name="first_name" size="60" />
            </p>
            <p>Last Name:
                <input type="text" name="last_name" size="60" />
            </p>
            <p>Email:
                <input type="text" name="email" size="30" />
            </p>
            <p>Headline:<br />
                <input type="text" name="headline" size="80" />
            </p>
            <p>Summary:<br />
                <textarea name="summary" rows="8" cols="80"></textarea>
            </p>
            <p>
                <input type="submit" value="Add">
                <input type="submit" name="cancel" value="Cancel">
            </p>
        </form>
    </div>
</body>

</html>
