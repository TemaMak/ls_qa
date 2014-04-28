<?php

class PluginEvents_ModuleEvents_EntitySpeeds extends Entity
{
	public function setName($data){
		$this->_aData['name']=$data;
	}	
	
	public function setId($data){
		$this->_aData['id']=$data;
	}		
	
	public function getName(){
		return $this->_getDataOne('name');
	}	
	public function getId(){
		return $this->_getDataOne('id');
	}
}

?>
