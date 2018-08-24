<?php

/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is licensed exclusively to Inovia Team.
 *
 * @copyright  Copyright (c) 2015 Inovia Team (http://www.inovia.fr)
 * @license      All rights reserved
 * @author       The Inovia Dev Team
 *
 * Default Helper class needed for translations and defining XML CONFIG PATH
 *
 */

class Wisepops_Connect_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * @var string (xml path for retrieving the config : status)
     */
    const XML_PATH_CONFIG_WISEPOPS_ACTIVATED    = 'wisepopsconnect/settings/status';
    /**
     * @var string (xml path for retrieving the config : wisepops id)
     */
    const XML_PATH_CONFIG_WISEPOPS_USER_ID      = 'wisepopsconnect/settings/wisepops_id';

    /**
     * @var string (wisepops config section name, used to append javascript on the wisepops configuration page)
     */
    const WISEPOPS_CONFIG_SECTION_NAME          = 'wisepopsconnect';
}