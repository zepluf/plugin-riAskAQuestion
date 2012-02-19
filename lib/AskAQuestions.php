<?php

namespace plugins\riAskAQuestion;

use plugins\riResultList\ResultSource;

class AskAQuestions extends ResultSource{
    
    private $questions = array();
	
	public function findById($id, $reload = false){
		global $db;
		
		if($reload || !isset($this->questions[$id])){
		
    		$result = $db->Execute("select * from " . TABLE_ASK_A_QUESTION . " where id=".(int)$id);
    		if($result->recordCount() > 0)
    			$this->questions[$id] = $this->container->get('riAskAQuestion.AskAQuestion')->setArray($result->fields);					
    		else 
    			$this->questions[$id] = false;	
		}
		return $this->questions[$id];
	}
	
	public function getTotalNumberOfResults(){
		global $db;
		$sql = "SELECT COUNT(*) AS count FROM " . TABLE_ASK_A_QUESTION;
		
		$sql = $this->resultList_->buildBaseQuery($sql);
			
		$result = $db->Execute($sql);
		return $result->fields['count'];
	}
	
    
	public function getResults($reload = false){
		global $db;
		
		$sql = "SELECT * FROM " . TABLE_ASK_A_QUESTION;

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