<?php

/**
 *
 * @category    Mage4
 * @package     Mage4_ExtraTabs
 * @author      Rehan Mobin
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mage4\ExtraTabs\Block\Adminhtml\System\Config\Fields;

class Blockmap extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * Grid columns
     *
     * @var array
     */
    protected $_columns = [];
    /**
     * Renderer static blocks
     *
     * @var array
     */
    protected $staticBlockRenderer;
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
    protected function getStaticBlockRenderer() 
    {
        if (!$this->staticBlockRenderer) {
            $this->staticBlockRenderer = $this->getLayout()->createBlock(
                '\Mage4\ExtraTabs\Block\Adminhtml\System\Config\Renderer\Blocks', '', ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->staticBlockRenderer;
    }
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender() 
    {
        $this->addColumn(
            'static_block', [
            'label' => __('Static Block'),
            'renderer' => $this->getStaticBlockRenderer(),
                ]
        );
        $this->addColumn('title', ['label' => __('Title'), 'class' => 'input-text required-entry', 'style' => 'width:150px']);
        $this->addColumn('pos', ['label' => __('Position')]);
        $this->_addAfter = false;
        $this->addButtonLabel = __('Add');
        parent::_construct();
    }
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row) 
    {
        $staticBlockVal = $row->getStaticBlock();
        $options = [];
        if ($staticBlockVal) {
            $options['option_' . $this->getStaticBlockRenderer()->calcOptionHash($staticBlockVal)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    } 
   
}