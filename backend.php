<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>

<body>

</body>

</html>

<?php
require('config.php');

if (isset($_POST['stripeToken'])) {
    \Stripe\Stripe::setVerifySslCerts(false);
    $token = $_POST['stripeToken'];
    $name = $_POST["name"];
    $email = $_POST["email"]; 
    $package = $_POST["package"];
    $pkg =preg_split("/[\s]+/",$package,2);
    print_r($pkg[0]);  
    $amount = $_POST["amount"]; 
    $price = $pkg[0] / 100;
    $data = \Stripe\Charge::create(array(
        "amount" => $price,
        "currency" => "usd",
        "description" => 'xyz',
        "source" => $token,
    ));
    $url = $data['receipt_url'];
    $html = "<table class='table table-bordered'><thead> <tr> <th scope='col'>Name</th><th scope='col'>Email</th><th scope='col'>package</th><th scope='col'>Amount</th><th scope='col'>Recipt</th></tr></thead><tbody><tr><th scope='row'>$name</th><td>$email</td><td>$pkg[1]</td><td>$amount</td> <td><img src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=$url'></td></tr> </tbody></table>";
    require('smtp/PHPMailerAutoload.php');
    $mail = new PHPMailer();
    $mail->SMTPDebug = 3;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = "587";
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "asifaslamaimviz@gmail.com";
    $mail->Password = 'jdmwncwtnwsaaljv';
    $mail->SetFrom("asifaslamaimviz@gmail.com");
    //   $mail->Subject = $subject;
    $mail->addAddress('asifaslamaimviz@gmail.com');
    $mail->isHTML(true);
    $mail->subject = "NEW contact us";
    $mail->Body = $html;
    //   $mail->AddAddress($to);
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
    } else {
        echo 'Sent';
    }
}
