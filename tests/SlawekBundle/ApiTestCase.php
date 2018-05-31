<?php
namespace Tests\SlawekBundle;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ApiTestCase extends TestCase
{
	private static $staticClient;

	/**
	* @var Client
	*/
	protected $client;

	public static function setUpBeforeClass()
	{
		$baseUrl = getenv('TEST_BASE_URL');
		self::$staticClient = new Client(
			array('base_url'=>$baseUrl,
				'defaults'=> array('exceptions' => false)
			)
		);
	}

	protected function setUp()
	{
		$this->client = self::$staticClient;
	}
}
