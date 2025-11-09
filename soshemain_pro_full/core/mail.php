<?php
require_once __DIR__ . '/helpers.php';

if (file_exists(BASE_PATH . '/vendor/phpmailer/src/PHPMailer.php')) {
    require_once BASE_PATH . '/vendor/phpmailer/src/Exception.php';
    require_once BASE_PATH . '/vendor/phpmailer/src/PHPMailer.php';
    require_once BASE_PATH . '/vendor/phpmailer/src/SMTP.php';
}

function send_mail(string $toEmail, string $toName, string $subject, string $htmlBody, string $textBody = ''): bool
{
    if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($toEmail, $toName);
            $mail->addReplyTo(SMTP_FROM_EMAIL, SMTP_FROM_NAME);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $textBody ?: strip_tags($htmlBody);

            $mail->send();
            return true;
        } catch (PHPMailer\PHPMailer\Exception $e) {
            error_log('Mail error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    $headers = 'From: ' . SMTP_FROM_NAME . ' <' . SMTP_FROM_EMAIL . ">\r\n" .
        "Content-Type: text/html; charset=UTF-8\r\n";
    return mail($toEmail, $subject, $htmlBody, $headers);
}
