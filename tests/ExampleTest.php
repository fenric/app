<?php

use PHPUnit\Framework\TestCase;

/**
 * php ./vendor/bin/phpunit --bootstrap ./tests/bootstrap.php ./tests/ExampleTest
 */

class ExampleTest extends TestCase
{
	public function testTrue()
	{
		$this->assertTrue(true);
	}

	public function testFalse()
	{
		$this->assertFalse(false);
	}

	public function testNull()
	{
		$this->assertNull(null);
	}
}
