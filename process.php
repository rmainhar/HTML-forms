<?php
//process.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    
	    //mysql credentials
    $mysql_host = "localhost";
    $mysql_username = "root";
    $mysql_password = "123456";
    $mysql_database = "test";
	
	$u_name = $_POST["user_name"]; //set PHP variables like this so we can use them anywhere in code below
    $u_email = $_POST["user_email"];
    $u_text = $_POST["user_text"];
    
	if (empty($u_name)){
        die("Please enter your name");
    }
    if (empty($u_email) || !filter_var($u_email, FILTER_VALIDATE_EMAIL)){
        die("Please enter valid email address");
    }
        
    if (empty($u_text)){
        die("Please enter text");
    }   
	//Open a new connection to the MySQL server
    //see https://www.sanwebe.com/2013/03/basic-php-mysqli-usage for more info
    $mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    
    //Output any connection error
    if ($mysqli->connect_error) {
        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }   
    
    $statement = $mysqli->prepare("INSERT INTO users_data (user_name, user_email, user_message) VALUES(?, ?, ?)"); //prepare sql insert query
    //bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
    $statement->bind_param('sss', $u_name, $u_email, $u_text); //bind value
	 if($statement->execute()){
    //print output text
	echo nl2br("Hello ". $u_name . "! We have received your message and email; ". $u_email.  "\r\nWe will contact you very soon!", false);
	 }else{
		 print $mysqli->error; //show mysql error if any
	 }
}
?>