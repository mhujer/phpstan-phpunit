<?php

declare(strict_types = 1);

namespace PHPStan\Rules\PHPUnit;

use PHPStan\Rules\Rule;

class AssertEqualsWithoutExplanationRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new AssertEqualsWithoutExplanationRule();
	}

	public function testRule()
	{
		$this->analyse([__DIR__ . '/data/assert-equals-without-explanation.php'], [
			[
				'You should use assertSame instead of assertEquals. Or it should have a comment above with explanation: // assertEquals because ...',
				10,
			],
			[
				'You should use assertSame instead of assertEquals. Or it should have a comment above with explanation: // assertEquals because ...',
				13,
			],
		]);
	}

}
