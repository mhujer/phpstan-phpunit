<?php declare(strict_types = 1);

namespace ExampleTestCase;

class FooTestCase extends \PHPUnit\Framework\TestCase
{

	public function testObviouslyNotSameAssertSame()
	{
		$this->assertSame(true, 'a');
		$this->assertSame(false, 'a');

		/** @var bool $a */
		$a = null;

		$this->assertSame($a, 'b');
	}

}
