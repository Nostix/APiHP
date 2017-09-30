<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/assets/functions.php';
include_once($path);

$createDB = "CREATE TABLE IF NOT EXISTS api (
          user TEXT,
          id TEXT
          )";
mysqli_query( $connect, $createDB);

if (isset($_POST['user'])) {
    $options = [
        'cost' => 11,
        'salt' => uniqid(mt_rand(), true),
    ];
    //create random id
    $rand = generateRandomString();
    //hash id for database with random hash
    $hash = password_hash($rand, PASSWORD_BCRYPT, $options);
    $createID = $connect->prepare("INSERT INTO api (user, id) VALUES (?, ?)");
    $createID->bind_param('ss',$_POST['user'], $hash);
    $createID->execute();
    echo 'Your ID is: '.$rand.'<br>Write it down carefully.<br>You need it to access the API.';
}
?>
<form action="generate.php" method="post">

    <input type="text" name="user" placeholder="desired username">
    <button type="submit">generate</button>
</form>