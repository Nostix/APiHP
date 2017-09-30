<?php
//include functions
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/assets/functions.php';
include_once($path);

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
//check id if set
if (isset($request['id'])) {
    if (requireID($request['id']) == true) {
        //execute action if set
        if (isset($request['action'])) {
            executeAction($request['action'], $endpoint);
        }
        else {
            outputStatus('400', 'No action defined');
        }
    }
}
//check blank id if no id set
else {
    if (requireID('') == true) {
        //execute action if set
        if (isset($request['action'])) {
            executeAction($request['action'], $endpoint);
        }
        else {
            outputStatus('400', 'No action defined');
        }
    }
}
?>