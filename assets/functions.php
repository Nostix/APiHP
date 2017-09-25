<?php
//include settings
$config = include('config.php');

//establish database connection
$connect = mysqli_connect($config['db']['host'],$config['db']['user'], $config['db']['password'], $config['db']['name']);
if(!$connect) {
    die('Could not connect: ' . mysql_error());
}

//check if ID exists in DB, if yes: return true
function checkID($id) {
    global $connect;
    $IdQuery = $connect->prepare("SELECT * FROM api WHERE id LIKE ?");
    $IdQuery->bind_param('s', $id);
    $IdQuery->execute();
    $IdQueryResult = $IdQuery->get_result();
    $IdQueryRow = mysqli_fetch_array($IdQueryResult);
    if($IdQueryRow==0) {
        return false;
    }
    else {
        return true;
    }
}

//output HTML-statuscode with optional notice as JSON object
function outputStatus($code, $notice = NULL) {
    global $config;
    //output status wihtout notice
    if (is_null($notice)) {
        $data = array(
            'version' => $config['version'],
            'author' => $config['author'],
            'status' => $config['status'][$code],
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //output status with notice
    else {
        $data = array(
            'version' => $config['version'],
            'author' => $config['author'],
            'status' => $config['status'][$code],
            'notice' => $notice,
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

//return array with all endpoints and related actions
function getEndpointActions() {
    $endpointActionArray = array();
    //get endpoints
    $endpoints = glob('endpoints' . '/*' , GLOB_ONLYDIR);
    //get actions for each endpoint
    foreach ($endpoints as $point) {
        $point = str_replace('endpoints/', '', $point);
        $allActions = scandir('endpoints/'.$point);
        $actions = array_diff($allActions, array('.', '..'));
        $actionsArray = array();
        //remove .php extention from actions
        foreach ($actions as $action) {
            $action = str_replace('.php', '', $action);
            array_push($actionsArray, $action);
        }
        //push endpoint and actions to array
        $endpointActionArray[$point] = $actionsArray;
    }
    return $endpointActionArray;
}

//check for existence of action and endpoint, if given: execute
function checkAction($action, $endpoint) {
    global $config;
    //cover both options for index endpoint
    if ($endpoint == '/' || $endpoint == '/index.php') {
        $endpoint = 'index';
    }
    else {
        $endpoint = preg_replace(array('/^\//','/\/$/'), '',$endpoint);    
    }
    //check endpoint existence
    $endpointActionArray = getEndpointActions();

    if (!in_array($endpoint, array_keys($endpointActionArray))) {
        outputStatus('400', "Endpoint '".$endpoint."' does not exist");
        return;
    }
    //check action, directory and file existence
    if (in_array($action, $endpointActionArray[$endpoint])) {
        include('/../endpoints/'.$endpoint.'/'.$action.'.php');
    }
    //action does not exist
    elseif ($action == '') {
        outputStatus('400', 'No action defined');
    }
    else {
        outputStatus('400', "Action '".$action."' does not exist at endpoint '".$endpoint."'");
    }
}
?>