<?php

/**
 *
 * @category    Mage4
 * @package     Mage4_ExtraTabs
 * @author      Rehan Mobin
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mage4\ExtraTabs\Block\Catalog\Product\View;

/**
 * Product information tabs
 */
class Tabs extends \Magento\Framework\View\Element\Template
{
    
    /**
     * Array of tabs
     *
     * @var array
     */
    protected $tabs = [];
    
    /**
     * Raw Array of tabs
     *
     * @var array
     */
    protected $rawtabs = [];
    
    /**
     * System configuration values of tabs
     *
     * @var array
     */
    protected $config = [];
    
    protected $_helper;
    
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context,
     * @param \Mage4\ExtraTabs\Helper\Data                     $helper,
     * @param array                                            $data
     */
    public function __construct(
        \Mage4\ExtraTabs\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->_helper = $helper;
        parent::__construct($context, $data);
    }
    
    /**
     * Prepare global layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->config = $this->_helper->getConfigData();
        
        $this->setDescriptionTab();
        $this->setAdditionalAttributesTab();
        $this->setReviewsTab();
        $this->setRelatedProductsTab();
        $this->setTextAreaAttr();
        $this->setStaticBlocks();
        
        foreach ($this->rawtabs as $tab) {
            $this->addTab(
                $tab['alias'],
                $tab['title'],
                $tab['block'],
                $tab['template'],
                $tab['position'] ? $tab['position'] : 0,
                $tab['data']
            );

        }
        return parent::_prepareLayout();
    }
    
    
    /**
     * Add tab to the container
     *
     * @param  string $alias
     * @param  string $title
     * @param  string $block
     * @param  string $template
     * @param  string $position
     * @param  string $header
     * @return void
     */
    public function addTab($alias, $title, $block, $template, $position, $header = null)
    {
        if (!$title || !$block || !$template) {
            return;
        }

        $this->tabs[] = ['alias' => $alias, 'title' => $title, 'position' => $position];
        
        $this->setChild($alias, $this->getLayout()->createBlock($block, $alias, ['data' => $header])->setTemplate($template));
    }
    
    /**
     * Return configured tabs
     *
     * @return array
     */
    public function getTabs()
    {
        usort(
            $this->tabs, function ($a, $b) {
                return $a['position'] - $b['position'];
            }
        );
        return $this->tabs;
    }
    
    /**
     * set product description tab
     *
     * @param  null
     * @return void
     */
    
    protected function setDescriptionTab()
    {
        
        if($this->config['description']) {
            $this->rawtabs[] = array('alias' => 'description', 'title' => $this->config['description_title'], 'block' => 'Magento\Catalog\Block\Product\View\Description', 'template' => 'Mage4_ExtraTabs::catalog/product/view/tabs/attribute.phtml', 'position' => $this->config['description_pos'], 'data' => array('attribute_code' => 'description'));
        }
    }
    
    /**
     * set Additional Attributes tab
     *
     * @param  null
     * @return void
     */
    protected function setAdditionalAttributesTab()
    {
        
        if($this->config['additional']) {
            $this->rawtabs[] = array('alias' => 'additional_attributes', 'title' => $this->config['additional_title'], 'block' => 'Magento\Catalog\Block\Product\View\Attributes', 'template' => 'Magento_Catalog::product/view/attributes.phtml', 'position' => $this->config['additional_pos'], 'data' => array()  );
        }
    }
    
    /**
     * set product reviews tab
     *
     * @param  null
     * @return void
     */
    protected function setReviewsTab()
    {
        
        if($this->config['review']) {
            $this->rawtabs[] = array('alias' => 'reviews_tab', 'title' => $this->config['review_title'], 'block' => 'Magento\Review\Block\Product\Review', 'template' => 'Mage4_ExtraTabs::catalog/product/view/tabs/review.phtml', 'position' => $this->config['review_pos'], 'data' => array());
        }
    }
    
    /**
     * remove default related products block from product page
     * set Related Products tab
     *
     * @param  null
     * @return void
     */
    protected function setRelatedProductsTab()
    {
        
        if($this->config['related']) {
            // unset default related product block
            $layout = $this->getLayout();
            $layout->unsetElement('catalog.product.related');
            
            $this->rawtabs[] = array('alias' => 'related_tab', 'title' => $this->config['related_title'], 'block' => 'Magento\Catalog\Block\Product\ProductList\Related', 'template' => 'Magento_Catalog::product/list/items.phtml', 'position' => $this->config['related_pos'], 'data' => array('type' => 'related')  );
        }
    }
    
    /**
     * set multi-textarea attributes tab
     *
     * @param  null
     * @return void
     */
    protected function setTextAreaAttr()
    {
        
        if($attrs = $this->config['attributes']) {
            $attributes = json_decode($attrs, TRUE);
            if (is_array($attributes)) {
                foreach($attributes as $_attribute) {
                    $this->rawtabs[] = array('alias' => $_attribute['attribute'], 'title' => $_attribute['title'], 'block' => 'Magento\Catalog\Block\Product\View\Description', 'template' => 'Mage4_ExtraTabs::catalog/product/view/tabs/attribute.phtml', 'position' => $_attribute['pos'], 'data' => array('attribute_code' => $_attribute['attribute']));

                }
            
            }
        }
    }
    
    /**
     * set multi-cms static blocks tab
     *
     * @param  null
     * @return void
     */
    protected function setStaticBlocks()
    {
        
        if($blocks = $this->config['blocks']) {
            $blocks = json_decode($blocks, TRUE);
            if (is_array($blocks)) {
                foreach($blocks as $_block) {
                    $this->rawtabs[] = array('alias' => 'cms_'. $_block['static_block'], 'title' => $_block['title'], 'block' => 'Magento\Framework\View\Element\Template', 'template' => 'Mage4_ExtraTabs::catalog/product/view/tabs/block.phtml', 'position' => $_block['pos'], 'data' => array('block_code' => $_block['static_block']));

                }
            
            }
        }
    }
}