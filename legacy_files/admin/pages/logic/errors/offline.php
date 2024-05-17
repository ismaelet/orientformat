<?php

if (isset($_POST['submit'])) {
	if (isset($_SESSION['userId'])) logout('login');
	else redirect('/login');
}
