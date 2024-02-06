<?php declare(strict_types = 1);

namespace SaschaEgerer\PhpstanTypo3\Service;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use SaschaEgerer\PhpstanTypo3\Contract\ServiceMap;

final class PrivateServiceAnalyzer
{

	private ServiceMap $serviceMap;

	public function __construct(ServiceMap $symfonyServiceMap)
	{
		$this->serviceMap = $symfonyServiceMap;
	}

	/**
	 * @param MethodCall|StaticCall $node
	 *
	 * @return RuleError[]
	 */
	public function analyze(Node $node, Scope $scope): array
	{
		$serviceId = $this->serviceMap->getServiceIdFromNode($node->getArgs()[0]->value, $scope);

		if ($serviceId === null) {
			return [];
		}

		$service = $this->serviceMap->getServiceDefinitionById($serviceId);

		if ($service === null || $service->isPublic()) {
			return [];
		}

		return [
			RuleErrorBuilder::message(sprintf('Service "%s" is private.', $serviceId))->build(),
		];
	}

}
