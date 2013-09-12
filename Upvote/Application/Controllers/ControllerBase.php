<?php

namespace Upvote\Application\Controllers;
use Upvote;
class ControllerBase 
{
	/**
	 * Config array
	 * 
	 * @var array
	 */
	protected $config;
	
	/**
	 * PDO Connection
	 * @var \Pdo
	 */
	protected $dba;
	
	public function __construct(array $config)
	{
		$this->setupConfig($config);
		$this->setupDb();
	}

	/**
	 * Setup a db connection. Totally crap here
	 * 
	 * @todo abstract this out correctly. 
	 */
	protected function setupDb()
	{
		$dbconfig = $this->getConfig()['database'];
		$dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
		$this->dba = new \PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
		$this->dba->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
	}
	
	/**
	 * Fetch the db connection.
	 * 
	 * @return Pdo
	 */
	protected function getDba()
	{
		return $this->dba;
	}
	
	/**
	 * Setup config array so its available
	 *
	 * @param array $config
	 */
	protected function setupConfig($config) {
		$this->config = $config;
	}
	
	/**
	 * Get the config array.
	 * @return array
	 */
	protected function getConfig()
	{
		return $this->config;
	}
}