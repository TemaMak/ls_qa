<?php

class PluginEvents_ModuleEvents_EntityEvents extends ModuleTopic_EntityTopic
{
	public function ValidateTopicType($sValue,$aParams) {
		if ($this->PluginEvents_Events_IsAllowTopicType($sValue)) {
			return true;
		}
		return $this->Lang_Get('topic_create_type_error');
		//return true;
	}
	
	public function setStartDate($data){
		$this->_aData['date_start']=$data;
	}
	
	public function setStopDate($data){
		$this->_aData['date_stop']=$data;
	}	
	
	public function setAvatar($data){
		$this->_aData['event_avatar']=$data;
	}		
	
	public function setDistance($data){
		$this->_aData['distance']=$data;
	}

	public function setLevel($data){
		$this->_aData['level']=$data;
	}	
	
	public function setTime($data){
		$this->_aData['time_start']=$data;
	}

	public function setSpeed($data){
		$this->_aData['speed']=$data;
	}	
	
	public function getStartDate(){
		return $this->_getDataOne('date_start');
	}
	public function getStopDate(){
		$data = $this->_getDataOne('date_stop');
		if (empty($data)){
			return '0000-00-00';
		} else {
			return $data;
		}		
	}	
	public function getAvatar(){
		return $this->_getDataOne('event_avatar');
	}	

	/**
	 * Возвращает полный URL до топика
	 *
	 * @return string
	 */
	public function getUrl() {
		//return Router::GetPath('blog').$this->Blog_GetBlogById($this->getBlogId())->getUrl().'/'.$this->getId().'.html';
		if (!$this->getBlog()){
			$this->setBlog($this->Blog_GetBlogById($this->getBlogId()));
		}
		
		return parent::getUrl();		
	}	
	
	public function getBlogEventAvatar(){
		$avatarStr = $this->_getDataOne('blog_event_avatar');
		return $avatarStr;
	}
	
	public function getDistance(){
		$distance = $this->_getDataOne('distance');
		if (!empty($distance)){
			return $distance;
		}
		return 0;
	}	

	public function getLevel(){
		return $this->_getDataOne('level');
	}	
	
	public function getTime(){
		$time = $this->_getDataOne('time_start');
		if (!empty($time)){
			return $time;
		}
		return '00:00';
	}	
	
	public function getSpeed(){
		return $this->_getDataOne('speed_name');
	}	
	
	public function getSpeedId(){
		return $this->_getDataOne('speed');
	}	
}

?>
