<?php

include "sanitization.php";

if (isset($_POST['to'])) {
    $from = sanitizeString($_POST['from']);
    $to = sanitizeString($_POST['to']);
    $cc = sanitizeString($_POST['cc']);
    $subject = sanitizeString($_POST['subject']);
    $message = sanitizeString($_POST['message']);

// send email
    $result = mail($to, $subject, $message, "From: $from" . "\r\n" . "CC: $cc");
    if (!$result)
        echo "E-mail couldn't be sent";
    else
        echo "Email was sent successfully!";
}
?>