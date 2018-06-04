<?php
date_default_timezone_set('asia/kolkata');
$conn = mysqli_connect('localhost','root','root','transport') or die(mysqli_connect_error());

$qry = mysqli_query($conn,
	'SELECT S.next_service_date AS s_date,V.vehicle_number FROM vehicles AS V LEFT JOIN `vehicle-service` AS S ON S.vehicle_id = V.vehicle_id LEFT JOIN `driver-details` AS D ON D.vehicle_id = V.vehicle_id') or die(mysqli_error($conn));
$count = mysqli_num_rows($qry);
if($count > 0)
{
while ($data = mysqli_fetch_array($qry) or die(mysqli_error($conn))) {
	$date = strtotime($data['s_date']);
	$today_date = strtotime(date('Y-m-d'));
	
	if ($date == $today_date) {

/**** Get admin details ***/
$ad_qry =mysqli_query($conn,"SELECT * FROM users WHERE role = 'admin'") or die(mysqli_error($conn));
$ad_mobile = array();
while ($ad_data = mysqli_fetch_array($ad_qry)) {
	$mobile = $ad_data['mobileNo'];
	$mobile = str_replace("+91","",$mobile);
	$ad_mobile[] = $mobile;
}
$ad_mobile = implode(',', $ad_mobile);
		$query = http_build_query([
 'uname' => 'psvpolytech',
 'password' => 'welcome123',
 'sender' => 'PSVCOL',
 'receiver' => $ad_mobile,
 'route' => 'TA',
 'msgtype' => '1',
 'sms' => 'Today is '.$data['vehicle_number'].' Vechicle Next Service Day',
]);

$url = "http://5.189.140.219/index.php/smsapi/httpapi/?".$query;

$ch = curl_init($url);
var_dump($ch);
	}
}
}


?>