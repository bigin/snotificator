<?php namespace Notify;
defined('IS_NOTIFY') or die('You cannot access this page directly.');

/* E-Mail parameters/settings */
$this->siteName = 'YOUR SITE NAME';

$this->emailFrom = 'gmail@chuck.norris.com';

$this->emailFromName = 'Chuck Norris';

$this->emailTo = 'gmail@chuck.norris.com';


/**
 * PHPMailer settings.
 * Gmail example:
 * https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps
 */
$this->smtpMail = false;

	/* required if SMTP_EMAIL is true */
	$this->smtpMailerLang = 'en';

	$this->smtpHost = 'smtp.gmail.com';

	$this->smtpUserName = 'gmail@chuck.norris.com';

	$this->smtpPassword = 'your password';

	$this->smtpSecure = 'START_TLS';

	$this->smtpPort = 25;

	// 1, 2 or 3. Use 'false' on production server
	$this->smtpDebug = false;

$this->isHtml = false;

/**
 * Default email subject and text
 */
$this->emailSubject = 'This is your email subject';

$this->emailBody = 'This is your email text insert your message here.';