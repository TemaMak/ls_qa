<?php

class PluginReports_ModuleReports_MapperReports extends ModuleTopic_MapperTopic
{
	
	public function SaveSourceEvent($iTopicId,$iReportId){
			$sqlEvent =  "INSERT INTO ".Config::Get('db.table.report_for_event')." 
				(
					event_id,
					report_id
				)
				VALUES(?d,?d)
				ON DUPLICATE KEY UPDATE
					event_id =?d			
			";
			
			return $this->oDb->query(
				$sqlEvent,
				$iTopicId,
				$iReportId,
				/* ON DUPLICATE KEY UPDATE  */
				$iTopicId	
			);		
	}

	public function GetSourceEventId($iTopicId){
			$sql =  "
				SELECT 
					event_id 
				FROM ".Config::Get('db.table.report_for_event')." 
					WHERE report_id = ?d		
			";
			
			$iEventId = null;
			if ($aRows=$this->oDb->select($sql,$iTopicId)) {
				foreach ($aRows as $aTopic) {
					$iEventId = $aTopic['event_id'];
				}
			}			
			
			return $iEventId;	
	}
	
	public function GetReportsForEvent($iEventId){
			$sql =  "
				SELECT 
					report_id 
				FROM ".Config::Get('db.table.report_for_event')." 
					WHERE event_id = ?d		
			";
			
			$aReportsId = null;
			if ($aRows=$this->oDb->select($sql,$iEventId)) {
				foreach ($aRows as $aTopic) {
					$aReportsId[] = $aTopic['report_id'];
				}
			}			
			
			return $aReportsId;			
	}
	
	
    public function GetTopReporter($iLimit,$iOffset,&$iCount,$excludeId = array(0)){
    	
    	$sql = "
			SELECT 
				t.user_id,
				(sum(t.topic_count_vote) / (sum(1)/50 + 1) + sum(t.topic_count_favourite) /(sum(1)/50 + 1) + sum(1) / 100 + sum(t.topic_count_vote)/10 + sum(t.topic_count_favourite)/10 + sum(t.topic_count_comment)/1000) AS rating 
			FROM 
				".Config::Get('db.table.report_for_event')." r 
			JOIN 
				".Config::Get('db.table.topic')." t 
			ON 
				r.report_id = t.topic_id
			WHERE 
				t.user_id NOT IN (?a) 
			GROUP 
				by t.user_id 
			ORDER BY 
				rating DESC
  			LIMIT 
  				?d,?d				    	
    	";
    	
		$aUserIds=null;
		if ($aRows=$this->oDb->selectPage($iCount,$sql,$excludeId,$iOffset,$iLimit)) {
			foreach ($aRows as $aTopic) {
				$aUserIds[] = $aTopic;
			}
		}

		return $aUserIds;    	
    } 	
	
	
}

?>
