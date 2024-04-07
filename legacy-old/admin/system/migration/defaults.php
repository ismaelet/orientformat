<?php

// config table
if (!DB::table('config')) {
	DB::execute('
		CREATE TABLE config (
			id INT(3) AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(30),
			value VARCHAR(300) 
		)
	');

	DB::add('config (name, value)', ['public', 1]);
}

// users table
if (!DB::table('users')) {
	DB::execute('
		CREATE TABLE users (
			id INT(11) AUTO_INCREMENT PRIMARY KEY,
			username VARCHAR(50) DEFAULT "",
			password VARCHAR(128) DEFAULT "",
			email VARCHAR(50) DEFAULT "",
			firstName VARCHAR(50) DEFAULT "",
			lastName VARCHAR(50) DEFAULT "",
			groupId INT(11) DEFAULT 0,
			admin TINYINT(1) DEFAULT 0,
			time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		)
	');

	DB::add('users (username, password, email, firstName, lastName, admin)', ['ismaele.t', 'Luminol#221b', 'ismaele.tuffanelli@gmail.com', 'Ismaele', 'Tuffanelli', 2]);
}

// password resets
DB::execute('
	CREATE TABLE IF NOT EXISTS user_resets (
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		userID INT(11),
		security VARCHAR(10),
		time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	)
');

// authentication table
DB::execute('
	CREATE TABLE IF NOT EXISTS auth_tokens (
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		selector VARCHAR(12),
		validator VARCHAR(64),
		userID INT(11),
		expiration TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP()
	)
');
