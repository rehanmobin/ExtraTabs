<?php

/**
 *
 * @category    Mage4
 * @package     Mage4_ExtraTabs
 * @author      Rehan Mobin
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mage4\ExtraTabs\Block\Adminhtml\System\Config\Renderer;

class Attributes extends \Magento\Framework\View\Element\Html\Select
{
   
    /**
     *
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection
     */
    protected $entityAttributeCollection;
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Context                          $context
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $entityAttributeCollection
     * @param array                                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $entityAttributeCollection,
        array $data = []
    ) {
        $this->entityAttributeCollection = $entityAttributeCollection; 
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
            $attributesCollection = $this->getAttributeRenderer();
            foreach ($attributesCollection as $attribute) {
                     $this->addOption($attribute['attribute_code'], $attribute['frontend_label']);
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
    
    /**
     * get attributes data
     *
     * @param  null
     * @return array data
     */
    protected function getAttributeRenderer()
    {
        $collection = $this->entityAttributeCollection
            ->setEntityTypeFilter(4)                
            ->setFrontendInputTypeFilter('textarea');
        
        $attributes = $collection->load();
        return $attributes->getData();
    }
}
 