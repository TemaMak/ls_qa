<?php

class PluginReports_HookReports extends Hook {

    /*
     * Регистрация событий на хуки
     */
    public function RegisterHook() {
		$this->AddHook('template_menu_create_topic_item', 'add');
        $this->AddHook('topic_edit_after','save_source_event');
        $this->AddHook('topic_add_after','save_source_event');
        $this->AddHook('topic_add_before','set_report_type');
        
        $this->AddHook('template_topic_show_info','show_event_for_report');

		$this->AddHook('template_menu_rating', 'MenuRating');
      	$this->AddHook('rating_get_list', 'Rating');
        
    }

    public function add($aParams) {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'menu.topic_action.tpl');
    }
    
	public function save_source_event($aParams){
		$oTopic = $aParams['oTopic'];
				
		if ($oTopic->getType() == 'report' ){
			$iSourceEventId = getRequest('source_event');
			
			$this->PluginReports_Reports_SaveSourceEvent($iSourceEventId,$oTopic->getId());
		}    
	}
	
	public function set_report_type($aParams){
		$oTopic = $aParams['oTopic'];
		$sTopicType = getRequest('topic_type');
		if ($sTopicType == 'report'){
			$oTopic->setType('report');	
		}		
	}
	
	public function show_event_for_report($aParams){
		$oTopic = $aParams['topic'];
		if ($oTopic->getType() == 'report'){
			$oSourceEvent = $this->PluginReports_Reports_GetSourceEvent($oTopic->getId());
			if (!empty($oSourceEvent)){
			$this->Viewer_Assign('oSourceEvent',$oSourceEvent);
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'event_source.tpl');				
			}
		}		
	}
	
	public function Rating($aParams){
		$rating_name = $aParams['rating_name'];
		$iPage = $aParams['page'];
		$iPerPage = 10;

		
		if ($rating_name == 'top_reporter'){
			$this->Viewer_Assign('RatingName',$this->Lang_Get('plugin.reports.top_reporter'));
			
			$aUsers = $this->Pluginreports_Reports_GetTopReporters($iPerPage,($iPage - 1) * $iPerPage);
			
			$aPaging=$this->Viewer_MakePaging(
				$aUsers['count'],
				$iPage,
				$iPerPage,
				Config::Get('pagination.pages.count'),
				Router::GetPath('rating').$rating_name
			);
			$this->Viewer_Assign('aPaging',$aPaging);
			$this->Viewer_Assign('aUsers',$aUsers['collection']);					
		}		
		
	}
	
	public function MenuRating(){
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'menu_rating.tpl');
	}	
	
}
?>
