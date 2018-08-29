<?php namespace Notify;

defined('IS_NOTIFY') or die('You cannot access this page directly.');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include dirname(__DIR__).'/phpmailer/vendor/autoload.php';

class Mailer extends PHPMailer
{
	private $config;

	public function __construct($config)
	{
		parent::__construct(true);

		$this->config = $config;
		try
		{
			// SMPT Standardeinstellungen übernehmen
			$this->setSmtpDefaultData();
		} catch (phpmailerException $e)
		{
			$msg = 'SMTP-Default-Data could not load';
			$log = new FileLog(wire('config')->paths->logs .
				(isset($this->config->notifications_file) ? $this->config->notifications_file .'.txt' : 'errors.txt'));
			$log->save($msg);
			return false;
		}
	}

	private function setSmtpDefaultData()
	{
		// SMTP
		if($this->config->smtpMail == 1)
		{
			try
			{
				$this->name = '';
				$this->isSMTP();
				$this->SMTPDebug = $this->config->smtpDebug;
				$this->SMTPAuth =  true;
				$this->SMTPSecure = $this->config->smtpSecure;
				$this->Host = $this->config->smtpHost;
				$this->Port = $this->config->smtpPort;
				$this->Username = $this->config->smtpUserName;
				$this->Password = $this->config->smtpPassword;
			} catch (phpmailerException $e)
			{
				echo $e->errorMessage();
			}
		}

		// Typical mail data
		$this->CharSet = 'utf-8';
		$this->SetFrom($this->config->emailFrom, $this->config->emailFromName);
		$this->isHTML($this->config->isHtml);
		$this->addReplyTo($this->config->emailTo, $this->config->siteName);
	}

	public function send()
	{
		ob_start();
		if(true !== parent::send()) {
			echo $this->ErrorInfo;
		}
		@ob_end_clean();
		$this->ClearAddresses();
		$this->ClearAttachments();
		$this->ClearAllRecipients();
	}
}