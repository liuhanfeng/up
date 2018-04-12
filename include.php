<?php
session_start();
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
include_once 'config.php';

// Include ezSQL core
include_once "include/sql_core.php";

// Include ezSQL database specific component
include_once "include/sql_mysql.php";

$db = new ezSQL_mysql($config['db']['user'], $config['db']['password'], $config['db']['name'], $config['db']['host']);
$current_time = $db->get_var("SELECT " . $db->sysdate());
// print "database datetime $current_time";

$current_user = array(
    'userid' => 0,
    'username' => '',
    'userstate' => 0
);

function checklogin()
{
    global $current_user;
    
    if (isset($_SESSION['uuserid']) && intval($_SESSION['uuserid']) > 0) {
        $current_user['userid'] = intval($_SESSION['uuserid']);
        $current_user['username'] = $_SESSION['username'];
        $current_user['userstate'] = $_SESSION['userstate'];
        return true;
    } else {
        header('location:/login.php');
        return false;
    }
}

function rn2br($content){
    return str_replace("\n", '<br/>', $content);
}

function rn2sp($content){
    return str_replace("\r", '', str_replace("\n", '', $content));
}

