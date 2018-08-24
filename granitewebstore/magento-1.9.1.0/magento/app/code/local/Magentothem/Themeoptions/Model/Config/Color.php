<?php
/*------------------------------------------------------------------------
# Websites: http://www.plazathemes.com/
-------------------------------------------------------------------------*/ 
class Magentothem_Themeoptions_Model_Config_Color
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'red', 'label'=>Mage::helper('adminhtml')->__('Teal_Magenta')),
            array('value'=>'green', 'label'=>Mage::helper('adminhtml')->__('Mustard_Fern')),
            array('value'=>'pink', 'label'=>Mage::helper('adminhtml')->__('SkyBlue_LavenderRose')),
            array('value'=>'blue', 'label'=>Mage::helper('adminhtml')->__('AtomicTangerine_SkyBlue')),
            array('value'=>'orange', 'label'=>Mage::helper('adminhtml')->__('Emeral_NeonCarrot')),
            array('value'=>'yellow', 'label'=>Mage::helper('adminhtml')->__('FadedRed_Mustard'))
        );
    }

}
