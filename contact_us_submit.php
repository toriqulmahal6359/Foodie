<?php
include('database.inc.php');
include('function.inc.php');
include('constant.inc.php');

// prx($_POST);
$contact_query = '';

$name = get_safe_value($_POST['name']);
$email = get_safe_value($_POST['email']);
$mobile = get_safe_value($_POST['mobile']);
$subject = get_safe_value($_POST['subject']);
$message = get_safe_value($_POST['message']);
$added_on = date('Y-m-d H:i:s');

$contact_query = "INSERT INTO contact_us(name,email,mobile,subject,message,added_on) VALUES('$name','$email','$mobile','$subject','$message','$added_on')";
mysqli_query($con, $contact_query);
echo "Thanks for connecting with us, will get back to you shortly";

?>