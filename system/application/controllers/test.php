<?php
use Aws\Common\Aws;
use Aws\DynamoDb\Exception\DynamoDbException;

class Test extends CI_Controller
{
    public function index()
    {
        


		// Create a service building using shared credentials for each service
		$aws = Aws::factory(array(
		    'key'    => 'your-aws-access-key-id',
		    'secret' => 'your-aws-secret-access-key',
		    'region' => 'us-west-2'
		));

		// Retrieve the DynamoDB client by its short name from the service builder
		$client = $aws->get('dynamodb');

		// Get an item from the "posts"
		try {
		    $result = $client->getItem(array(
		        'TableName' => 'posts',
		        'Key' => $client->formatAttributes(array(
		            'HashKeyElement' => 'using-dynamodb-with-the-php-sdk'
		        )),
		        'ConsistentRead' => true
		    ));
		    print_r($result['Item']);
		} catch (DynamoDbException $e) {
		    echo 'The item could not be retrieved.';
		}
    }
}
?>