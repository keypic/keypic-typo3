<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$t3Version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('keypic');

if ($t3Version >= 6000000 AND \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('form')) {
    $txFormValidator = $extPath . 'Classes/Validator/KeypicValidator.php';
    require_once($txFormValidator);
}