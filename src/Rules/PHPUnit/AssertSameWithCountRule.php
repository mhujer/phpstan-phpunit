<?php declare(strict_types = 1);

namespace PHPStan\Rules\PHPUnit;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;

class AssertSameWithCountRule implements \PHPStan\Rules\Rule
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
		if (!is_string($node->name) || strtolower($node->name) !== 'assertsame') {
			return [];
		}

		$right = $node->args[1]->value;

		$leftType = $scope->getType($node->args[0]->value);
		$rightType = $scope->getType($node->args[1]->value);

		if ($right instanceof Node\Expr\FuncCall && strtolower($right->name->toString()) === 'count') {
			return [
				sprintf(
					'You should use assertCount() instead of assertSame($expectedCount, count($variable)).',
					$leftType->describe(),
					$rightType->describe()
				),
			];
		}

		return [];
	}

}
