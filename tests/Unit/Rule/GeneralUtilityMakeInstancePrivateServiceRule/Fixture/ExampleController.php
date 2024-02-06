<?php declare(strict_types = 1);

namespace Unit\Rule\GeneralUtilityMakeInstancePrivateServiceRule\Fixture;

use TYPO3\CMS\Core\Utility\GeneralUtility;

final class ExampleController
{

	public function action(): void
	{
		$anotherPrivateService = GeneralUtility::makeInstance('private');
		unset($anotherPrivateService);
	}

}
