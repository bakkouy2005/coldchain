<?php
/* Template Name: mailtest*/
get_header();

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$to = 'abde.bakk013@gmail.com';
$subject = 'Testmail vanaf Strato PHP';
$message = 'Dit is een testmail direct via wp_mail()';
$headers = [
    'From: info@coldchainlogisticservices.nl',
    'Content-Type: text/plain; charset=UTF-8'
];

if (wp_mail($to, $subject, $message, $headers)) {
    echo "✅ Mail verzonden";
} else {
    echo "❌ Mail mislukt";
}