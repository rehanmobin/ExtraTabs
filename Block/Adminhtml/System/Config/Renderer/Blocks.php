<?php

/**
 *
 * @category    Mage4
 * @package     Mage4_ExtraTabs
 * @author      Rehan Mobin
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mage4\ExtraTabs\Block\Adminhtml\System\Config\Renderer;
 
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;

class Blocks extends \Magento\Framework\View\Element\Html\Select
{
   
    /**
     * Block collection factory
     *
     * @var CollectionFactory
     */
    protected $blockCollectionFactory;
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Context                          $context
     * @param CollectionFactory $blockCollectionFactory
     * @param array                                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        CollectionFactory $blockCollectionFactory,
        array $data = []
    ) {
        $this->blockCollectionFactory = $blockCollectionFactory;
        parent::__construct($context, $data);
    }  
    /**
     * Returns countries array
     *
     * @return array
     */ 
     /**
      * Render block HTML
      *
      * @return string
      */
    public function _toHtml() 
    {
        if (!$this->getOptions()) {
            $options = $this->blockCollectionFactory->create()->load()->toOptionArray();
            foreach ($options as $option) {
                $this->addOption($option['value'], $option['label']);
            }
        }
        return parent::_toHtml();
    }
    /**
     * Sets name for input element
     *
     * @param  string $value
     * @return $this
     */
    public function setInputName($value) 
    {
        return $this->setName($value);
    }
}
 