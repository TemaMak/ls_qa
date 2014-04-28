<?php

class PluginReports_ModuleReports extends ModuleTopic {

	public function Init() {
		parent::Init();		 
		$this->oMapperTopic=Engine::GetMapper(__CLASS__);
	}
	
	public function SaveSourceEvent($iTopicId,$iReportId){
		return $this->oMapperTopic->SaveSourceEvent($iTopicId,$iReportId);
	}
	
	public function GetSourceEvent($iTopicId){
		$iSourceEventId =  $this->oMapperTopic->GetSourceEventId($iTopicId);
		return $this->PluginEvents_Events_GetEventById($iSourceEventId);	
	}
	
	public function GetSourceEventId($iTopicId){
		return $this->oMapperTopic->GetSourceEventId($iTopicId);
	}	
	
	public function GetReportsForEvent($iEventId){
		$aReportsId = $this->oMapperTopic->GetReportsForEvent($iEventId);
		$aReports = $this->oMapperTopic->GetTopicsByArrayId($aReportsId);
		foreach ($aReports as $key => $oReport){
			if ($oReport->getPublish()){
				$aReports[$key]->setBlog(
					$this->Blog_GetBlogById($oReport->getBlogId())
				);				
			} else {
				unset($aReports[$key]);
			}

		}
		
		return $aReports;
	}
	
	
    public function GetTopReporter(){
    	$aUserIds = $this->oMapperTopic->GetTopReporter(1,0,$iCount,Config::Get('plugin.reports.exclude_top_ids'));
    	$aUserId = reset($aUserIds);
		$iUserId = $aUserId['user_id'];
    	$oUser = $this->User_GetUserById($iUserId);
    	
    	return $oUser;
    }    
    
	public function GetTopReporters($iLimit,$iOffset){
	//	if (false === ($data = $this->Cache_Get('awards_top_user'))) {
			$aUserIds = $this->oMapperTopic->GetTopReporter($iLimit,$iOffset,$iCount,Config::Get('plugin.reports.exclude_top_ids'));
	//		$this->Cache_Set($data, 'awards_top_user', array("top_users"), 60*60*24*2);
	//	}
		$aUsers = array();
		
		if ($aUserIds){
			foreach ($aUserIds as $aUser){
				$aUsers[$aUser['user_id']] = $this->User_GetUserById($aUser['user_id']);
				$aUsers[$aUser['user_id']]->SetRating($aUser['rating']);
			}			
		}
					
		return array('collection' => $aUsers, 'count' => $iCount);
	} 	
	
}
?>
