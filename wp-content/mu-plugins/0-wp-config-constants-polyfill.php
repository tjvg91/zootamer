<?php
		// Define database constants if not already defined. It fixes the error
		// for imported sites that don't have those defined e.g. WP Cloud and
		// include plugins which try to access those directly e.g. Mailpoet
		if (!defined('DB_NAME')) define('DB_NAME', 'database_name_here');
		if (!defined('DB_USER')) define('DB_USER', 'username_here');
		if (!defined('DB_PASSWORD')) define('DB_PASSWORD', 'password_here');
		if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
		if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8');
		if (!defined('DB_COLLATE')) define('DB_COLLATE', '');
		