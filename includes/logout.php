<?php
	require_once 'classes.php';

    $userSession = new UserSession();
    $userSession->closeSession();
    header("location: ../login");
?>