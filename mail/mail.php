<?php
// Check for empty fields
if(empty($_POST['token']))
   {
   echo "No arguments Provided!";
   return false;
   }
   
$nama = strip_tags(htmlspecialchars($_POST['nama']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$token = strip_tags(htmlspecialchars($_POST['token']));


$email_subject = "Website Contact From:  Tiem Schedule";
$headers = "From: tiemschedule@tiematweb18.000webhostapp.com"."\r\n";
$headers .= "Reply-To:noreply@tiematweb18.000webhostapp.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message ='<html>';
$message .='<body>';
    $message .='<div class="mail" style="margin: auto; width: 100%; max-width: 350px; text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 30px;">';
        $message .='<div class="mail-header" style="color: white; background-color: #003365; width: 100%; font-size: 20px; padding: 20px; border-top-left-radius: 25px; border-top-right-radius: 25px;">';
            $message .='<strong>VERIFIKASI EMAIL DARI <br/>TIEM SCHEDULE</strong>';
        $message .='</div>';
        $message .='<div class="mail-body" style="color: black; background-color:  #CFE7EA; width: 100%; padding: 20px;">';
            $message .='<h1>Hallo '.$nama.', Silahkan lakukan verifikasi email anda dengan menekan tombol berikut </h1>';
            $message .='<a href="https:/tiematweb18.000webhostapp.com/api/mail/verifikasiEmail.php?token='.$token.'"><button style="background-image: linear-gradient(to left, #0025BC , #0071BC); width: 100%; text-align: center; margin: auto; min-height: 40px; color: white; font-size: 30px; cursor: pointer;">Klik disini</button></a>';
        $message .='</div>';
        $message .='<div class="mail-footer" style="color: black; background-color: #adadad; width: 100%; font-size: 20px;padding: 20px; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;">';
            $message .='Apabila link tersebut bermasalah, silahkan akses url berikut:';
            $message .='https://tiematweb18.000webhostapp.com/api/verifikasiEmail.php?token='.$token;
        $message .='</div>';
    $message .='</div>';
$message .='</body>';
$message .='</html>';

if(mail($email,$email_subject,$message,$headers)){
    echo "berhasil";
    return true; 
}else{
    echo "gagal";
}
        
?>