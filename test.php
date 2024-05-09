<?php
// test_smtp_connection.php

// Require autoloader
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

// Create Symfony Mailer instance
$transport = Transport::fromDsn('smtp://smtp-relay.brevo.com:587?encryption=tls&auth_mode=login&username=74882c001@smtp-brevo.com&password=KVFPvr0gh2XTfstC');
$mailer = new Mailer($transport);

// Create a test email
$email = (new Email())
    ->from('moncef.koubaa@insat.ucar.tn')
    ->to('moncefkoubaa26@gmail.com')
    ->subject('Test Email')
    ->text('This is a test email sent via Symfony Mailer.');

// Send the test email
try {
    $mailer->send($email);
    echo "Test email sent successfully.\n";
} catch (Exception $e) {
    echo "Failed to send test email: ".$e->getMessage()."\n";
}
