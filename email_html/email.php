<?php

include "sanitization.php";

if (isset($_POST['to'])) {
    $from = sanitizeString($_POST['from']);
    $to = sanitizeString($_POST['to']);
    $cc = sanitizeString($_POST['cc']);
    $subject = sanitizeString($_POST['subject']);
    $message = $_POST['message'];
    $html = "";
    if (isset($_POST['html']))
        $html = "html";
    $headers = "";

    $headers.="From: $from" . "\r\n" . "CC: $cc \r\n";
    if ($html == "html") {
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    }
    

// send email
    $result = mail($to, $subject, $message, $headers);
    if (!$result)
        echo "E-mail couldn't be sent";
    else
        echo "Email was sent successfully!";
}
?>