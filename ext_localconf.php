<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$t3Version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('keypic');

if ($t3Version >= 6000000 AND \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('form')) {
    $txFormValidator = $extPath . 'Classes/Validation/Validator/KeypicValidator.php';
    $tsService = $extPath . 'Classes/Service/TsLoaderService.php';
    $keypic = $extPath . 'Classes/Library/Keypic.php';
    require_once($txFormValidator);
    require_once($tsService);
    require_once($keypic);
}