<?php

function pr($arr){
    echo "<pre>";
    print_r($arr);
}

function prx($arr){
    echo "<pre>";
    print_r($arr);
    die();
}

function get_safe_value($str){
    global $con;
    $str = mysqli_real_escape_string($con,$str);
    return $str;
}

function redirect($link){
    ?>
    <script>
        window.location.href = '<?php echo $link; ?>';
    </script>
    <?php
    die();
}

function send_email($email, $subject, $html){
    $mail = new PHPMailer(true);
    $mail->isSMTP();    
    $mail->Host="smtp.gmail.com";    
    $mail->Port=587;    
    $mail->SMTPSecure="tls";    
    $mail->SMTPAuth=true;    
    $mail->Username="toriqulmahal6359@gmail.com";    
    $mail->Password="3bc2tMaF";    
    $mail->SetFrom("SMTP_EMAIL_ID");    
    $mail->addAddress($email);    
    $mail->IsHTML(true);    
    $mail->Subject=$subject;    
    $mail->Body=$html;    
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_safe_signed'=>false,
    ));
    
    if($mail->send()){
        echo "done";
    }else{

    }

}

?>