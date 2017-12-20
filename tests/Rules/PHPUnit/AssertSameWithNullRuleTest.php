<?php

declare(strict_types = 1);

namespace PHPStan\Rules\PHPUnit;

use PHPStan\Rules\Rule;

class AssertSameWithNullRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new AssertSameWithNullRule();
	}

	public function testRule()
	{
		$this->analyse([__DIR__ . '/data/assert-same-null.php'], [
			[
				'You should use assertNull() instead of assertSame(null, $variable) when expecting a null variable.',
				10,
			],
			[
				'You should use assertNull() instead of assertSame(null, $variable) when expecting a null variable.',
				13,
			],
		]);
	}

}
