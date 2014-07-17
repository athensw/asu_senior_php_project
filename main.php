<?php 
	require_once("curl.php");
	require_once("moodle.php");
	require_once("class.php");
	require_once("student.php");

	define ("ADD_NEW_COURSE", 1);	
	define ("ADD_BRANCHES", 2);	
	define ("QUIT", 3);	

	define ("MAX_INPUT", 3);

	function do_add_course() {
                $handle = fopen ("php://stdin","r");
		$moodle = new libmoodle();
		$courses = $moodle->get_courses();
		system("/usr/bin/clear");
		printf("Select course\n");
		for($i = 0; $i < sizeof($courses); $i++) {
			$cur = new course();
			$cur->shortname = $courses[$i]->shortname;
			$cur->fullname = $courses[$i]->fullname;
			$cur->id = $courses[$i]->id;
			$local_courses[$i] = $cur;
			printf("[%d] %s - %s\n", $i, $cur->shortname, $cur->fullname);
		}	
		$input = trim(fgets($handle));
		system("/usr/bin/clear");
		$repo = $input;
		$users = $moodle->get_users_by_course( $local_courses[$input]->id);
		system("/usr/bin/clear");
		printf("[%s]Select user or all\n", $local_courses[$input]->shortname);
		for($i = 0; $i < sizeof($users); $i++) {
			$stud = new student();
			$stud->first_name = $users[$i]->firstname;
			$stud->last_name = $users[$i]->lastname;
			$stud->id = $users[$i]->id;
			$stud->username = $users[$i]->username;
			$students[$i] = $stud;
			printf("[%d] %s %s\n", $i, $stud->first_name, $stud->last_name);
		}	
		printf("[%d] All Users\n", $i);
		$input = trim(fgets($handle));
		$repo_path = str_replace(" ", "", "/tmp/" . $local_courses[$repo]->id . "-" . $local_courses[$repo]->shortname);
		
		$current_path = getcwd();
		//init the repo if we need to
		if(!file_exists($repo_path)) {
			printf("Initing repo %s\n", $repo_path);
			git_repository_init($repo_path);	
			chdir($repo_path);
			
			system("touch blah.txt && /usr/bin/git add . ");
			system("/usr/bin/git commit -m \"Iniital commit\"");
		}
		chdir($repo_path);
		$branch = $students[$input]->first_name . $students[$input]->last_name;
		system("cd " . $repo_path . " &&  /usr/bin/git branch " . $branch);
		system("cd " . $current_path);
		$input = trim(fgets($handle));
		
	}

	function print_main_menu() {
		system("/usr/bin/clear");
		printf("Welcome to the php git interface\n");
		printf("Please select your action\n");
		printf("[1] Add new course\n");
		printf("[2] Add branches to course\n");
		printf("[3] Quit\n");
	}
	
	function print_help_menu() {
                $handle = fopen ("php://stdin","r");
		printf("Add new course\n\tThis will create a new course or repo\n");
		printf("Add branches\n\tThis will create new branches for each user\n");
		printf("Quit\n\tQuit using application\n");
		fgets($handle);
		fclose($handle);
	}
	
	function get_user_input() {
		$handle = fopen ("php://stdin","r");
		$input = fgets($handle);
		$input = trim($input);
		fclose($handle);
		return $input;
	}

	function validated_input() {
		$out = get_user_input();
		if($out <= MAX_INPUT && $out >= 1) {
			return $out;
		}else {
			printf("Error\n");
			printf("Press enter to continue\n");
			print_help_menu();
			return -1;
		}
	}
	$input = 0;
	do {
		print_main_menu();
		$input = validated_input();
		switch($input) {
			case ADD_NEW_COURSE:
				do_add_course();	
			break;
		};
	}while( $input != QUIT );

?>
