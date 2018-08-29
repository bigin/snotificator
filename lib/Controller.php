<?php namespace Notify;

class Controller
{
	/**
	 * @var object Processor|null
	 */
	private $processor = null;

	/**
	 * @var object Input|null - User input
	 */
	public $input = null;

	public function __construct($processor)
	{
		$this->processor = $processor;
		$this->input = new Input();
	}

	/**
	 * Lets the unauthorized calls go to waste
	 * instead of causing a fatal error.
	 *
	 * @param $name
	 * @param $arguments
	 */
	public function __call($name, $arguments)
	{
		if(method_exists($this, $name)) {
			$reflection = new \ReflectionMethod($this, $name);
			if(!$reflection->isPublic()) return;
		}
	}

	/**
	 * Initialize a controller action.
	 */
	public function execute($config = null)
	{
		if(!$this->input->get->action) return;

		$this->input->whitelist->action = isset($this->input->get->action) ? ucfirst(filter_var($this->input->get->action,
			FILTER_SANITIZE_SPECIAL_CHARS)) : null;

		if(!$this->input->whitelist->action) return;

		if($config) $this->processor->init($config);

		$methodName = 'execute'.ucfirst($this->input->whitelist->action);

		if(method_exists($this, $methodName)) {
			return $this->$methodName();
		}
	}

	/**
	 * Run processer method notify()
	 * Check if the session exists, if not no email should be sent.
	 */
	protected function executeNotify() { return $this->processor->notify(); }
}

class Config
{
	public function __construct($path = null) {
		if(!$path) require dirname(__DIR__).'/config.php';
		else require $path;
	}
}

class Input
{
	public $post;
	public $get;
	public $whitelist;
	public function __construct()
	{
		$this->post = new Post();
		$this->get = new Get();
		$this->whitelist = new Whitelist();
		foreach($_POST as $key => $value) { $this->post->{$key} = $value; }
		foreach($_GET as $key => $value) { $this->get->{$key} = $value; }
	}
}

class Post
{
	/**
	 *
	 * @param string $key
	 * @param mixed $value
	 * return $this
	 *
	 */
	public function __set($key, $value) { $this->{$key} = $value;}
	public function __get($name) { return isset($this->{$name}) ? $this->{$name} : null;}
}

class Get
{
	/**
	 *
	 * @param string $key
	 * @param mixed $value
	 * return $this
	 *
	 */
	public function __set($key, $value) { $this->{$key} = $value; }
	public function __get($name) { return isset($this->{$name}) ? $this->{$name} : null; }
}

class Whitelist
{
	/**
	 *
	 * @param string $key
	 * @param mixed $value
	 * return $this
	 *
	 */
	public function __set($key, $value) { $this->{$key} = $value; }
	public function __get($name) { return isset($this->{$name}) ? $this->{$name} : null; }
}
