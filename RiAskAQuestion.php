<?php 

namespace plugins\riAskAQuestion;

use plugins\riCore\Plugin;

class RiAskAQuestion extends Plugin{
    
    public function init(){
        
        $container = $this->container;
        
        $objects_id = 0;
        $type = 'categories';
        if(isset($_GET['products_id'])) { 
            $type = 'products';   		
    		$objects_id = $_GET['products_id'];
    	}
    	elseif(isset($_GET['cPath'])) {    		
    		$objects_id = end(explode('_' , $_GET['cPath']));
    	}
    
        $parse_view = function ($event) use ($container, $type, $objects_id){
           $container->get('riCore.HolderHelper')->add($event->getSlot(), $container->get('riCore.View')->render('riAskAQuestion::_frontend_link.php', array(
               'type' => $type,
               'objects_id' => $objects_id
           ))); 
        };
        
        // add listener to index_categories_top holder
        $this->dispatcher->addListener('view.helper.holder.get.start.index_categories_top', $parse_view);       
        $this->dispatcher->addListener('view.helper.holder.get.start.index_product_list_top', $parse_view);
        $this->dispatcher->addListener('view.helper.holder.get.start.index_product_top', $parse_view);
    }    
}
