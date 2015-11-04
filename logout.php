<?php

$_SESSION['userData']['session_token'] = NULL;
$_SESSION['userData'] = NULL;
setUserToken($_SESSION['userData']['user_id'], NULL);