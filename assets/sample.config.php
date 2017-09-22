<?php
//some definitions which do not fit in the other files
return array(
    'version' => '0.0.1',
    'author' => 'nostix',
    'title' => 'APiHP',
    'description' => 'A simple basis to build an API for any application.',
    //CHANGE THE PASSWORD FOR THE GENERATE PAGE HERE
    'generate_password' => 'ChangeMe',
    //CHANGE DATABASE CREDENTIALS HERE
    'db' => array(
                'host' => 'database-host',
                'name' => 'database-name',
                'user' => 'database-user',
                'password' => 'database-password',
                ),
    'status' => array(
                '200' => array('200' => 'OK'),
                '400' => array('400' => 'Bad Request'),
                '401' => array('401' => 'Unauthorized'),
                '403' => array('403' => 'Forbidden'),
                '500' => array('500' => 'Internal Server Error'),
                '503' => array('503' => 'Service Unavailable')
                ),
    // DEFINE ENDPOINTS & ACTIONS HERE //
    //
    'endpoints' => array(
                    'index' => array('info', 'test'),
                ),
    //
    //********************************//
);
?>