<?
$mysql_server_name="localhost";
$mysql_username="air";
$mysql_password="password";
$mysql_database="air";
$access_table_name = "access";
$user_table_name = "user";
$con=mysql_connect($mysql_server_name, $mysql_username,
                        $mysql_password);
if (!$con){
	die('Could not connect: ' . mysql_error());
}
mysql_query("set names 'utf8'");
mysql_select_db($mysql_database, $con);
?>
