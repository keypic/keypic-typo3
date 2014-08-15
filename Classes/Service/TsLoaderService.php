<?php
namespace KEYPIC\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\FrontendConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class TsLoaderService {
    /**
     * Get the typoscript setup
     *
     * @param	string		$_EXTKEY    The extension key
     * @param	boolean		$plugin     For a plugin?
     * @return	array
     */
    public static function getTsSetup($_EXTKEY, $plugin = true) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface');
        $settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'keypic');

        return $settings;
    }

    /**
     * Remove dots from the settings array
     *
     * @param   array   $settings The settings array
     * @return	void
     */
    private static function removeDots($settings) {
        $conf = array();
        foreach ($settings as $key => $value)
            $conf[self::removeDotAtTheEnd($key)] = is_array($value) ? self::removeDots($value) : $value;
        return $conf;
    }

    /**
     * Remove final dot
     *
     * @param	string  $string The string
     * @return	string
     */
    private static function removeDotAtTheEnd($string) {
        return preg_replace('/\.$/', '', $string);
    }
}