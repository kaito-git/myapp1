<?php header("X-XSS-Protection: 0");?>
<?php
    $logged_in = false;

    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        try {
            $dbh = new PDO('mysql:dbname=form;host=localhost', 'root', 'kight1091');
        } catch (PDOException $e) {
            exit('cannot connect to the database'.$e->getMessage());
        }
        $sql = "SELECT * FROM user_info WHERE name='$username' AND password='$password'";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($data)) {
            $logged_in = true;
            echo "Success!";
        } else {
            $logged_in = false;
            echo "Failed";
        }
    }
?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>login form</title>
  </head>
  <body>
    <form id="loginForm" name="loginForm" action="<?php print($_SERVER['SCRIPT_NAME']); ?>" method="POST">
      <legend>Login Form</legend>
      <label for="username">User Name</label>
      <input type="text" id="username" name="username" value="" />
      <br />
      <label for="password">Password</label>
      <input type="password" id="password" name="password" value="" />
      <br />
      <input type="submit" id="login" name="login" value="Login" />
    </form>
    <?php if ($logged_in): ?>
        <?php echo "Hello ".$_POST["username"]."!" ?>
    <?php elseif (!empty($_POST["username"])): ?>
        <?php echo $_POST["username"]." cannot find. Please confirm." ?>
    <?php endif; ?>

    <h3>$_SERVER</h3>
    <pre><?php var_dump($_SERVER); ?></pre>
    <h3>$_POST["username"]</h3>
    <pre><?php var_dump($_POST["username"]); ?></pre>
    <h3>$_POST["password"]</h3>
    <pre><?php var_dump($_POST["password"]); ?></pre>
  </body>
</html>
