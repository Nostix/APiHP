<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/assets/functions.php';
include_once($path);

$createDB = "CREATE TABLE IF NOT EXISTS api (
          id TEXT
          )";
mysqli_query( $connect, $createDB);

if (isset($_POST['pass'])) {
    if ($_POST['pass'] = $config['generate_password']) {
        $rand = 'h43'.substr(md5(microtime()),rand(0,26),10);
        $createID = $connect->prepare("INSERT INTO api (id) VALUES (?)");
        $createID->bind_param('s', $rand);
        $createID->execute();
        echo 'Your ID is: '.$rand.'<br>Write it down carefully.<br>You need it to access the API.';
    }
}
?>
<form action="generate.php" method="post">
    <input type="password" name="pass">
    <button type="submit">generate</button>
</form>