<?php declare(strict_types = 1);

namespace ExampleTestCase;

class FooTestCase extends \PHPUnit\Framework\TestCase
{

	public function testObviouslyNotSameAssertSame()
	{
		$this->assertEquals(1, '1');

		// with incorrect comment
		$this->assertEquals(1, '1');

		// assertEquals because I want it!
		$this->assertEquals(1, '1');
	}

}
