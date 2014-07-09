<?php 
	require_once("curl.php");


class libmoodle {

	private $token = 'c93104c1fc264f64be49244021754a18';

	public function get_courses() {

		$response = $this->call_moodle( 'core_course_get_courses', $params, $this->token );
		$json = json_decode($response);
		print_r($json);
		return $json;
	}

	public function call_moodle( $function_name, $params, $token )
	{
		$restformat = 'json';
		$domain = 'http://mcs.athens.edu/moodle';
		$serverurl = $domain . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$function_name;
		$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';

		$curl = new curl;
		$url = $serverurl.$restformat;
		print $url . "\n";
		$response = $curl->post( $url, $params );

		if ( TRACING ) 
			echo "Response from $function_name: \n", $response, "\n";

		return $response;
	}


	public function get_users_by_course($id) {
		$params = array( 'courseid' => $id);
		$response = $this->call_moodle('moodle_user_get_users_by_courseid', $params, $this->token);
		return json_decode($response);
	}

	public function get_users($ids) {

	//$userids = array(7,8,9);
	//$params = array( 'userids' => $userids );
	//print_r($params);
	//$response = call_moodle( 'moodle_user_get_users_by_id', $params, $token );
	}

};
?>
