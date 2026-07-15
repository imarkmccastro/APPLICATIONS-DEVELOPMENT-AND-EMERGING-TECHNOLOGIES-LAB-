<?php
// Copy this file to mail_config.php and enter the SMTP credentials supplied by
// your email provider. Never commit the real password to a public repository.
return array(
    'enabled' => true,
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'encryption' => 'tls',
    'username' => 'your-sender@gmail.com',
    'password' => 'your-app-password',
    'from_email' => 'your-sender@gmail.com',
    'from_name' => 'BBB Clothing Store',
    'site_url' => 'https://your-domain.example'
);
