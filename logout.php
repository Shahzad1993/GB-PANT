<?php
session_start();
if(isset($_SESSION['astro_email']))
{
	unset($_SESSION['astro_email']);
	unset($_SESSION['astro_role']);
	unset($_SESSION['astro_name']);
	
	header("Location: ./");
}
else{
	header("Location: ./");
}
?>