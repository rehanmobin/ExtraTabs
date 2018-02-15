<?php

/**
 *
 * @category    Mage4
 * @package     Mage4_ExtraTabs
 * @author      Rehan Mobin
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mage4\ExtraTabs\Block\Adminhtml\System\Config\Fields;

class Attributemap extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * Grid columns
     *
     * @var array
     */
    protected $_columns = [];
    /**
     * Renderer block text area
     *
     * @var array
     */
    protected $textAreaAttributeRenderer;
    /**
     * Enable the "Add after" button or not
     *
     * @var bool
     */
    protected $_addAfter = true;
    /**
     * Label of add button
     *
     * @var string
     */
    protected $addButtonLabel;
    /**
     * Check if columns are defined, set template
     *
     * @return void
     */
    protected function _construct() 
    {
        parent::_construct();
        $this->addButtonLabel = __('Add');
    }
    /**
     * Returns renderer for country element
     * 
     * @return \Magento\Braintree\Block\Adminhtml\Form\Field\Countries
     */
    protected function getAttributeRenderer() 
    {
        if (!$this->textAreaAttributeRenderer) {
            $this->textAreaAttributeRenderer = $this->getLayout()->createBlock(
                '\Mage4\ExtraTabs\Block\Adminhtml\System\Config\Renderer\Attributes', '', ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->textAreaAttributeRenderer;
    }
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender() 
    {
        $this->addColumn(
            'attribute', [
            'label' => __('Attribute'),
            'renderer' => $this->getAttributeRenderer(),
                ]
        );
        $this->addColumn('title', ['label' => __('Title'), 'class' => 'input-text required-entry', 'style' => 'width:150px']);
        $this->addColumn('pos', ['label' => __('Position')]);
        $this->_addAfter = false;
        $this->addButtonLabel = __('Add');
        parent::_construct();
    }
    
    /**
     * Prepare existing row data object.
     *
     * @param \Magento\Framework\DataObject $row
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row) 
    {
        $attributeVal = $row->getAttribute();
        $options = [];
        if ($attributeVal) {
            $options['option_' . $this->getAttributeRenderer()->calcOptionHash($attributeVal)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
   
}