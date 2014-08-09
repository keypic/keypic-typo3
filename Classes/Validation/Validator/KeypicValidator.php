<?php
namespace TYPO3\CMS\Form\Validation;

    /***************************************************************
     *  Copyright notice
     *
     *  (c) Tomita Militaru <mail@tomitamilitaru.com>
     *  All rights reserved
     *
     *  This script is part of the TYPO3 project. The TYPO3 project is
     *  free software; you can redistribute it and/or modify
     *  it under the terms of the GNU General Public License as published by
     *  the Free Software Foundation; either version 2 of the License, or
     *  (at your option) any later version.
     *
     *  The GNU General Public License can be found at
     *  http://www.gnu.org/copyleft/gpl.html.
     *
     *  This script is distributed in the hope that it will be useful,
     *  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *  GNU General Public License for more details.
     *
     *  This copyright notice MUST APPEAR in all copies of the script!
     ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * defaultmailform keypic rule (TYPO3 6.x)
 *
 * @author Tomita Militaru <mail@tomitamilitaru.com>
 * @package keypic
 */
class KeypicValidator extends \TYPO3\CMS\Form\Validation\AbstractValidator {

    /**
     * @var \Keypic
     */
    protected $keypic;

    /**
     * @var string
     */
    public $tsKey = 'standardMailform';

    /**
     * @var mixed
     */
    public $tsConf;

    /**
     * clientEmailAddress
     *
     * @var string
     */
    protected $clientEmailAddress;

    /**
     * clientUsername
     *
     * @var string
     */
    protected $clientUsername;

    /**
     * clientMessage
     *
     * @var string
     */
    protected $clientMessage;

    /**
     * clientFingerprint
     *
     * @var string
     */
    protected $clientFingerprint;

    /**
     * token
     *
     * @var string
     */
    protected $token;

    /**
     * formID
     *
     * @var string
     */
    protected $formID;

    /**
     * Constructor
     *
     * @param array $arguments
     * @return	void
     */
    public function __construct($arguments) {
        $settings = \KEYPIC\Service\TsLoaderService::getTsSetup('keypic', true);
        $this->clientEmailAddress = $settings['clientEmailAddress'];
        $this->clientUsername = $settings['clientUsername'];
        $this->clientMessage = $settings['clientMessage'];
        $this->clientFingerprint = $settings['clientFingerprint'];
        $this->formID = $settings['formID'];
        $this->minSpam = $settings['minSpam'];
        GeneralUtility::devLog('Keypic settings', 'keypic', 0, $settings);
        parent::__construct($arguments);
    }

    /**
     * getKeypic
     *
     * @return \Keypic
     */
    protected function getKeypic() {
        if (!isset($this->keypic)) {
            $this->keypic = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\Keypic');
            $this->keypic->setFormID($this->formID);
        }
        return $this->keypic;
    }

    /**
     * Returns TRUE if submitted value validates according to rule
     *
     * @return boolean
     * @see tx_form_System_Validate_Interface::isValid()
     */
    public function isValid() {

        $this->token = $this->getKeypic()->getToken($this->token);
        $isSpam = $this->getKeypic()->isSpam($this->token, $this->clientEmailAddress, $this->clientUsername, $this->clientMessage, $this->clientFingerprint);
        GeneralUtility::devLog('Keypic token', 'keypic', 0, array($this->token));
        GeneralUtility::devLog('Keypic response', 'keypic', 0, array($isSpam));
        if (intval($isSpam) >= $this->minSpam ) {
            return TRUE;
        } else {
            RETURN FALSE;
        }
    }
}
?>