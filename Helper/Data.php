<?php

/**
 * Mage4 ExtraTabs
 * 
 * @category Mage4
 * @package  Mage4_ExtraTabs
 * @author   Rehan Mobin
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mage4\ExtraTabs\Helper;

/**
 * Default Tabs helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }
 
        /**
         * get system configuration field values
         * 
         * @return array system configuration
         **/

    public function getConfigData() 
    {

        return  $this->scopeConfig->getValue('mage4_extrattabs/tab_config', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);


    }
 
        
        
}