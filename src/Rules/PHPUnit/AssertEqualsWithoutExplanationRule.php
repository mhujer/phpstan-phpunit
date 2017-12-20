<?php declare(strict_types = 1);

namespace PHPStan\Rules\PHPUnit;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;

class AssertEqualsWithoutExplanationRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\NodeAbstract::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		$testCaseType = new ObjectType(\PHPUnit\Framework\TestCase::class);
		if ($node instanceof Node\Expr\MethodCall) {
			$calledOnType = $scope->getType($node->var);
		} elseif ($node instanceof Node\Expr\StaticCall) {
			if ($node->class instanceof Node\Name) {
				$class = (string) $node->class;
				if (in_array(
					strtolower($class),
					[
						'self',
						'static',
						'parent',
					],
					true
				)) {
					$calledOnType = new ObjectType($scope->getClassReflection()->getName());
				} else {
					$calledOnType = new ObjectType($class);
				}
			} else {
				$calledOnType = $scope->getType($node->class);
			}
		} else {
			return [];
		}

		if (!$testCaseType->isSuperTypeOf($calledOnType)->yes()) {
			return [];
		}

		if (count($node->args) < 2) {
			return [];
		}
		if (!is_string($node->name) || strtolower($node->name) !== 'assertequals') {
			return [];
		}

		$file = explode("\n", file_get_contents($scope->getFile()));
		$previousLine = $file[$node->getLine()-2];

		if (!preg_match('~^\s+//\s+assertEquals because(.*)~', $previousLine)) {
			return [
				'You should use assertSame instead of assertEquals. Or it should have a comment above with explanation: // assertEquals because ...'
			];
		}

		return [];
	}

}
