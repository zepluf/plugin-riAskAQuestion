<?php

namespace plugins\riAskAQuestion;

use plugins\riPlugin\Object;

use plugins\riResultList\ResultSource;
class AskAQuestions extends \plugins\riResultList\ResultSource{
    
    private $questions = array();
	
	public function findById($id, $reload = false){
		global $db;
		
		if($reload || !isset($this->questions[$id])){
		
    		$result = $db->Execute("select * from ".DB_PREFIX."ask_a_question where id=".(int)$id);
    		if($result->recordCount() > 0)
    			$this->questions[$id] = $this->container->get('riAskAQuestion.AskAQuestion')->setArray($result->fields);					
    		else 
    			$this->questions[$id] = false;	
		}
		return $this->questions[$id];
	}
	
	public function getTotalNumberOfResults(){
		global $db;
		$sql = "SELECT COUNT(*) AS count FROM ".DB_PREFIX."ask_a_question";
		
		$sql = $this->resultList_->buildBaseQuery($sql);
			
		$result = $db->Execute($sql);
		return $result->fields['count'];
	}
	
    
	public function getResults($reload = false){
		global $db;
		
		$sql = "SELECT * FROM ".DB_PREFIX."ask_a_question";

		$sql = $this->resultList_->buildPaginationQuery($sql);	
		
		$result = $db->Execute($sql);
		
		$questions = array();
		while(!$result->EOF){
			$questions[] = $this->findById($result->fields['id']);			
			$result->MoveNext();
		}
		return $questions;
	}
	
}