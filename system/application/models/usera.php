<?php

require_once APPPATH.'../../vendor/autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;


class Usera {
	
	public $connectionString = 'DefaultEndpointsProtocol=http;AccountName=nfsstage;AccountKey=LVq+K0f7Uq/tDu5oBdyJ9SYfrvq/gwffJEc7VtCwAHvtvZ8Pve/p/1tvN4XwU7zd/TnVu2v4qH0iDDMGWshIyw==';
	public $tableRestProxy;
	
	public function __construct(){
		$tableRestProxy = ServicesBuilder::getInstance()->createTableService($this->connectionString);
	}
	
	public function createTable(){
		// Create table REST proxy.
		$this->tableRestProxy = ServicesBuilder::getInstance()->createTableService($this->connectionString);
		try {
		    // Create table.
		    $this->tableRestProxy->createTable("mytable2");
		}
		catch(ServiceException $e){
		    $code = $e->getCode();
		    $error_message = $e->getMessage();
			return $error_message;
		    // Handle exception based on error codes and messages.
		    // Error codes and messages can be found here: 
		    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
		}
	}
	
	public function addEntity(){
		$entity = new Entity();
		$entity->setPartitionKey("tasksLosAngeles");
		$entity->setRowKey("1");
		$entity->addProperty("Description", null, "Take out the trash.");
		$entity->addProperty("AwesomeDescription", null, "000000000000000");
		$entity->addProperty("DueDate", 
		                     EdmType::DATETIME, 
		                     new DateTime("2012-11-05T08:15:00-08:00"));
		$entity->addProperty("Location", EdmType::STRING, "Home");

		try{
		    $this->tableRestProxy->insertEntity("mytable", $entity);
		}
		catch(ServiceException $e){
		    // Handle exception based on error codes and messages.
		    // Error codes and messages are here: 
		    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
		    $code = $e->getCode();
		    $error_message = $e->getMessage();
		}
		
	}
	public function getTables(){
		$this->tableRestProxy = ServicesBuilder::getInstance()->createTableService($this->connectionString);
		$filter = "PartitionKey eq 'tasksSeattle'";
		
		try {
			$result = $this->tableRestProxy->queryTables();
			error_log(print_r($result->getTables(),true),0);
			
		} catch (Exception $e) {
			// Handle exception based on error codes and messages.
		    // Error codes and messages are here: 
		    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
		    $code = $e->getCode();
		    $error_message = $e->getMessage();
		    echo $code.": ".$error_message."<br />";
		}
		
		// try {
// 		    $result = $this->tableRestProxy->queryEntities("mytable", $filter);
// 		}
// 		catch(ServiceException $e){
// 		    // Handle exception based on error codes and messages.
// 		    // Error codes and messages are here: 
// 		    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
// 		    $code = $e->getCode();
// 		    $error_message = $e->getMessage();
// 		    echo $code.": ".$error_message."<br />";
// 		}
// 
// 		$entities = $result->getEntities();
// 
// 		foreach($entities as $entity){
// 			// $description = $entity->getProperty("Description")->getValue();
// 			//     echo $description."<br />";
// 			// 		    echo $entity->getPartitionKey().":".$entity->getRowKey()."<br />";
// 			error_log(print_r($entity->getProperties(),true),0);
// 		}
	}
	public function getEntities($table = 'mytable'){
		$this->tableRestProxy = ServicesBuilder::getInstance()->createTableService($this->connectionString);
		$e = $this->tableRestProxy->queryEntities($table);
		$a = $e->getEntities(); //returns array
		
		$myentities = array();
		
		foreach ($a as $key => $value) {
			$t = $value->getProperties();
			foreach ($t as $k => $v) {
				$myentities[$k] = $v->getValue();
			}
		}
		error_log(print_r($myentities,true),0);
		
	
	}
}
?>