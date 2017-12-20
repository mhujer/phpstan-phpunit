<?php declare(strict_types = 1);

namespace ExampleTestCase;

class FooTestCase extends \PHPUnit\Framework\TestCase
{

	public function testObviouslyNotSameAssertSame()
	{
		$this->assertSame(null, 'a');

		$a = null;
		$this->assertSame($a, 'b');

		$this->assertSame('a', 'b'); // OK
	}

}
