<?php
namespace plugins\riAskAQuestion;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use plugins\riPlugin\Plugin;
use plugins\riSimplex\Controller;

class AdminAskAQuestionController extends Controller{
    
    public function indexAction(Request $request){
        global $messageStack;
        Plugin::load(array('riResultList'));
		$result_list = Plugin::get('riResultList.ResultList');
	
		$questions = Plugin::get('riAskAQuestion.AskAQuestions');
			  	
		$result_list->setResultSource($questions); 
		$result_list->setPagination(10);	
        
		$result_list->setPageNumber($request->get('page', 1));	
		
		if($request->get('sub_action')=='mass_update'){
		   foreach($request->get('questions') as $id => $info){
		  
		        $question = Plugin::get('riAskAQuestion.AskAQuestions')->findById($id);
		        if($info['delete'] == 1){
		            if($question->delete())
		                $messageStack->add(sprintf(ri('The question #%d from customer %s was deleted'), $question->id, $question->customerName), 'success');
		        }
		        else{		        
		            $question->setArray($info['data']);
		            $question->save();
		        }
		    }
		    
		}
		
        $this->view->get('php::holder')->add('main',$this->view->render('riAskAQuestion::_index.php',array('result_list' => $result_list)));    
        return $this->render('riAskAQuestion::admin_layout.php');
    }
}