<?php
include('database.inc.php');
include('function.inc.php');
include('constant.inc.php');

// pr($_POST);
// $contact_query = '';

$name = get_safe_value($_POST['name']);
$email = get_safe_value($_POST['email']);
$mobile = get_safe_value($_POST['mobile']);
$password = get_safe_value($_POST['password']);
$type = get_safe_value($_POST['type']);
$added_on = date('Y-m-d h:i:s');

if($type == 'register'){
    $check_query = "SELECT * FROM user WHERE email='$email'";
    $check_res = mysqli_query($con, $check_query);
    $check = mysqli_num_rows($check_res);
    if($check > 0){
        $arr = array('status'=>'error', 'msg'=>'Email ID has already been registered', 'field'=>'email_error');
    }else{
        $log_reg_query = "INSERT INTO user(name,email,mobile,password,status,email_verify,added_on) VALUES('$name','$email','$mobile','$password','1','0','$added_on')";
        mysqli_query($con, $log_reg_query);
        $arr = array('status'=>'success', 'msg'=>'Thanks for registering. In case of verify, please check your email address', 'field'=>'success_msg');
    }
    echo json_encode($arr);
}



?>