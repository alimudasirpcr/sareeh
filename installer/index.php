<?php
echo "Welcome to CRM App Installer.\n";
echo "Please enter your MySQL database details.\n";

$host = readline("Host: ");
$username = readline("Username: ");
$password = readline("Password: ");
$database = readline("Database name: ");

$config_template = <<<EOT
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

\$active_group = 'default';
\$query_builder = TRUE;

\$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '$host',
	'username' => '$username',
	'password' => '$password',
	'database' => '$database',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
EOT;

file_put_contents('/path/to/your/application/config/database.php', $config_template);

echo "Database configuration file has been created successfully!\n";
?>