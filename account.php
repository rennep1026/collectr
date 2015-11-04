<?php

$routes = getPathRoute();

if(sizeof($routes)<2){
    include('header.php');
    include('profile.php');
    true;
}

?>