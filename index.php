<?php
//include functions
include ('assets/functions.php');

//check for request method and set the right one for further actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = $_POST;
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request = $_GET;
}
//only POST and GET requests are permitted
else {
    outputStatus('403', 'Request method not permitted');
    die();
}
//get endpoint
$endpoint = strtok($_SERVER["REQUEST_URI"],'?');
//check for unique id
if (!isset($request['id'])) {
     outputStatus('401', 'ID not defined');
}
//check if id is valid
elseif (checkID($request['id']) == true) {
    //check for action
    if (isset($request['action'])) {
        checkAction($request['action'], $endpoint);
    }
    else {
        outputStatus('400', 'No action defined');
    }
}
else {
    outputStatus('403', 'Invalid ID');
}
?>