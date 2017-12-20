<?php declare(strict_types = 1);

namespace PHPStan\Rules\PHPUnit;

use PHPStan\Rules\Rule;

class AssertSameWithBooleanRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new AssertSameWithBooleanRule();
	}

	public function testRule()
	{
		$this->analyse([__DIR__ . '/data/assert-same-boolean.php'], [
			[
				'You should use assertTrue() when expecting "true"',
				10,
			],
			[
				'You should use assertFalse() when expecting "false"',
				11,
			],
		]);
	}

}
