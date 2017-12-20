<?php declare(strict_types = 1);

namespace ExampleTestCase;

class FooTestCase extends \PHPUnit\Framework\TestCase
{

	public function testObviouslyNotSameAssertSame()
	{
		$this->assertSame(5, count([1, 2, 3]));
	}

}
