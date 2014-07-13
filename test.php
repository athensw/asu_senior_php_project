<?php


$data = array("assignment" => "blah.cpp", "username" => "chorlick", "password"=>"happydance", "content"=>base64_encode("this is a test"));
$data_string = array( "submission" => json_encode($data));                                                                                 

print_r($data);

$ch = curl_init('http://localhost/senior/submit.php');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 
print "Sending curl request \n";
$response = curl_exec($ch);
print $response . "\n";
curl_close($ch);
?>
