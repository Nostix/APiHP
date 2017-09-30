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
//check if id and user set
if (isset($request['id']) && isset($request['user'])) {
    if (requireID($request['id'], $request['user']) == true) {
        //execute action if set
        if (isset($request['action'])) {
            executeAction($request['action'], $endpoint);
        }
        else {
            outputStatus('400', 'No action defined');
        }
    }
}
//only id set
elseif (isset($request['id']) && !isset($request['user'])) {
    if (requireID($request['id'], '') == true) {
        //execute action if set
        if (isset($request['action'])) {
            executeAction($request['action'], $endpoint);
        }
        else {
            outputStatus('400', 'No action defined');
        }
    }
}
//only user set
elseif (!isset($request['id']) && isset($request['user'])) {
    if (requireID('', $request['user']) == true) {
        //execute action if set
        if (isset($request['action'])) {
            executeAction($request['action'], $endpoint);
        }
        else {
            outputStatus('400', 'No action defined');
        }
    }
}
//check blank user and if if both not set
else {
    if (requireID('', '') == true) {
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