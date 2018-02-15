<?php

/**
 * Mage4 ExtraTabs
 * 
 * @category Mage4
 * @package  Mage4_ExtraTabs
 * @author   Rehan Mobin
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mage4\ExtraTabs\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class RemoveBlock implements ObserverInterface
{
    /**
     * System configuration values of tabs
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Checking whether module is enable. remove product details page tabs block.
     *
     * @param  \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $isEnable = $this->scopeConfig->getValue(
            'mage4_extrattabs/general/is_enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        
        if(! $isEnable) { return $this; 
        }
        
        /**
 * @var \Magento\Framework\View\Layout $layout 
*/
        $layout = $observer->getLayout();
        $block = $layout->getBlock('product.info.details');
        if ($block) {
            $layout->unsetElement('product.info.details');
        }
    }
}