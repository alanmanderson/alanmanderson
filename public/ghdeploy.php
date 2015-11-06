<?php
use \alanmanderson\clever_deploy\CleverDeploy;
use \Dotenv;
date_default_timezone_set('America/Los_Angeles');
require_once __DIR__.'/../bootstrap/autoload.php';
\\$app = require_once __DIR__.'/../bootstrap/app.php';
Dotenv::load(__DIR__.'/..');
$cd = new CleverDeploy(Dotenv::findEnvironmentVariable('GITHUB_DEPLOY_FOLDER'),
                       '',
                       '',
                       Dotenv::findEnvironmentVariable('GITHUB_DEPLOY_BRANCH'),
                       Dotenv::findEnvironmentVariable('GITHUB_DEPLOY_SECRET'));
$cmds = array();
$i = 0;
while(true){
    $cmd = Dotenv::findEnvironmentVariable("DEPLOY_COMMANDS[$i]");
    if (!isset($cmd)){
        break;
    } else {
        $cmds[] = $cmd;
    }
    $i++;
}
echo $cd->deploy($cmds);
