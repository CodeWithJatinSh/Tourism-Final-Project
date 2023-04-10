<?php
session_start();
session_destroy();
header('location:./');
/*
header('location:./') redirects the user to the home page of the website 
by setting the HTTP Location header to './' (which means the current directory). 
*/