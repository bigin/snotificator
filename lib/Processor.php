<?php namespace Notify;


class Processor
{
	private $config = null;

	private $mailer = null;

	public function init($config = null) {
		if(!$config) { $config = new Config(); }
		$this->config = $config;
		$this->mailer = new Mailer($this->config);
	}

	public function notify()
	{
		if(!$this->config) $this->init();

		$this->mailer->Subject = $this->config->emailSubject;
		$this->mailer->Body = $this->config->emailBody;

		$this->mailer->addAddress($this->config->emailTo, $this->config->siteName);
		return $this->mailer->send();
	}
}
