<?php
//include settings
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= '/assets/config.php';
if (file_exists($path)) {
    $config = include_once($path);
}
else {
    echo '404 Error - No config file found!';
    exit();
}


//establish database connection
$connect = mysqli_connect($config['db']['host'],$config['db']['user'], $config['db']['password'], $config['db']['name']);
if(!$connect) {
    die('Could not connect: ' . mysql_error());
}

//check if ID exists in DB, if yes: return true
function verifyID($id) {
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
            'status' => $config['status'][$code],
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //output status with notice
    else {
        $data = array(
            'status' => $config['status'][$code],
            'notice' => $notice,
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

function requireID($id) {
    global $config;
    //only require id if set in settings
    if ($config['require_id'] == 'true') {
        //no id defined
        if ($id == '') {
            outputStatus('401', 'ID not defined');
            return false;
        }
        //id verified
        elseif (verifyID($id) == true) {
            return true;
        }
        //unvalid id
        else {
            outputStatus('403', 'Invalid ID');
            return false;
        }
    }
    //do not check id if disabled in settings
    elseif ($config['require_id'] == 'false') {
        return true;
    }
}

//return array with all endpoints and related actions
function getEndpointActions() {
    $endpointActionArray = array();
    //get endpoints
    $endpoints = glob('endpoints' . '/*' , GLOB_ONLYDIR);
    //get actions for each endpoint
    foreach ($endpoints as $point) {
        //scan for files(actions) in every endpoint directory
        $point = str_replace('endpoints/', '', $point);
        $allActions = scandir('endpoints/'.$point);
        $actions = array_diff($allActions, array('.', '..'));
        $actionsArray = array();
        //remove .php extention from files(actions)
        foreach ($actions as $action) {
            $action = str_replace('.php', '', $action);
            array_push($actionsArray, $action);
        }
        //push endpoint and matching actions to final array
        $endpointActionArray[$point] = $actionsArray;
    }
    return $endpointActionArray;
}

//check for existence of action and endpoint, if given: execute
function executeAction($action, $endpoint) {
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
    //check action existence and execute
    if (in_array($action, $endpointActionArray[$endpoint])) {
        $path = $_SERVER['DOCUMENT_ROOT'];
        $path .= '/endpoints/'.$endpoint.'/'.$action.'.php';
        include_once($path);
    }
    //no action defined
    elseif ($action == '') {
        outputStatus('400', 'No action defined');
    }
    //action does not exist
    else {
        outputStatus('400', "Action '".$action."' does not exist at endpoint '".$endpoint."'");
    }
}
?>