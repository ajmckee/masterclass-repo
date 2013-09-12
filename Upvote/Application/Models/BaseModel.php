<?php

namespace Upvote\Application\Models;

use Upvote;

class BaseModel 
{
	/**
	 * Configuration array
	 * 
	 * @var mixed
	 */
	protected $config;
	
	/**
	 * PDO Connection 
	 * 
	 * @var \PDO
	 */
	protected $dba;
	
	public function __construct(array $config)
	{
		$this->setupConfig($config);
		if(array_key_exists('database', $this->getConfig()))
		{
			$this->setupDb();
		}
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
	 * @return \PDO
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
	
	/**
	 * Populate model using an array.
	 *
	 * @param mixed $data - An Array of data
	 * @return \Upvote\Application\Models\Interfaces\SimpleModel
	 * @see \Upvote\Application\Models\Interfaces\SimpleModel::populate()
	 */
	public function populate(array $data)
	{
		foreach ($data as $key=>$value)
		{
			$this->$key = $value;
		}
		return $this;
	}
	
	/**
	 * Set the value of a property magically. Lazy but meh.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @throws ModelException
	 * @return \Upvote\Application\Models\Comment
	 */
	public function __set($name, $value)
	{
		$this->$name = $value;
		return $this;
	}
	
	/**
	 * Get a property magically.
	 *
	 * @param string $name
	 * @return multitype
	 * @throws ModelException
	 */
	public function __get($name)
	{
		if(!property_exists($name))
		{
			throw new ModelException();
		}
		return $this->$name;
	}
	
	/**
	 * Get the name of the table the model operates on.
	 * 
	 * @return string
	 * @throws ModelException
	 */
	protected function getTableName()
	{
		if(isset($this->tableName))
		{
			return $this->tableName;
		}
		throw new ModelException('Table name has not been defined for class ' . get_called_class(), 1001);
	}
	public function save()
	{
		$realSave = $this->saveModel($this->toArray());
		if($realSave)
		{
			if(property_exists($this, 'id'))
			{
				$this->id = $this->getDba()->lastInsertId();
			}
			return $this;
		}
	}
	
	/**
	 * Saves the data to the database
	 * 
	 * @param array $data
	 * @return \Upvote\Application\Models\BaseModel
	 */
	protected function saveModel(array $data)
	{
		$tblName = $this->getTableName();
		if(!$this->isUpdate($data))
		{
			// @todo Way insecure, all your bases belong to someone else soon!
			$query = 'INSERT INTO `' . $this->getTableName() .'` ('. implode(',', array_keys($data)) .') ';
			$namedBinds = array();
			foreach ($data as $key=>$value)
			{
				array_push($namedBinds, ':'.$key);
			}
			$query .= 'VALUES ('.implode(',', $namedBinds).')';
			
		}
		else 
		{
			$query = 'UPDATE `'. $this->getTableName() .'` SET ';
			$total = count($data);
			$count = 0;
			foreach ($data as $key=>$value)
			{
				$count++;
				$query .= ' '. $key . '=:'.$key;
				($count != $total) ? $query .= ',' : $query .='';
			}
			$query .= ' WHERE id=:updateID';
			$data['updateID'] = $data['id'];
		}
		
		$stmt = $this->getDba()->prepare($query);
		$results = $stmt->execute($data);
		
		
		return $results;
		
	}
	
	private function isUpdate($data)
	{
		if(array_key_exists('id', $data))
		{
			(!is_numeric($data['id'])) ? $update = false :  $update = true ;
		}
		else {
			$update = true;
		}
		return $update;
	}
}