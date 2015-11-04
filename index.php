<?php

require_once('functions.php');
$routes = getPathRoute();

if(empty($routes)){
    include('header.php');
    include('dashboard.php');
    true;
}
elseif($routes[0]=='register'){
    include('header.php');
    include("register.php");
}
elseif($routes[0]=='login'){
    include('header.php');
    include("login.php");
}
elseif($routes[0]=='logout'){
    require('logout.php');
    include('header.php');
}
elseif($routes[0]=='account'){
    include('account.php');
}
else{
    include('header.php');
    var_dump($routes);
}

include('footer.php');
?>