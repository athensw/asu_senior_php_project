<?
        require_once("curl.php");
        require_once("moodle.php");
        require_once("class.php");
        require_once("student.php");

        define ("ADD_NEW_COURSE", 1);
        define ("ADD_BRANCHES", 2);
        define ("QUIT", 3);

	$json = json_decode($_POST['submission']);
	
	$assignment_name = $json->assingment;
	$username =        $json->username;
	$password =        $json->password;
	$assignment_content = $json->content;

	printf("Assignment Name %s\n", $assignment_name);
	printf("User Name %s\n", $username);
	printf("Password %s\n", $password);
	print base64_decode($assignment_content);
?>
