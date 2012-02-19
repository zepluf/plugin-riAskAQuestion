<?php 

namespace plugins\riAskAQuestion;

use plugins\riCore\Plugin;

class RiAskAQuestion extends Plugin{
    
    public function init(){
        
        $container = $this->container;
        
        $request = $container->getParameter('request');
        
        $objects_id = 0;
        $type = 'categories';
        if($request->get('products_id') != null) { 
            $type = 'products';   		
    		$objects_id = $request->get('products_id');
    	}
    	elseif($request->get('cPath') != null) {    		
    		$objects_id = end(explode('_' , $request->get('cPath')));
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
