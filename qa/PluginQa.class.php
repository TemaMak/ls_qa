<?php
if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginQa extends Plugin {

    public function Activate() {
       // if (!$this->isTableExists('prefix_user_cast_history')) {
      //      $resutls = $this->ExportSQL(dirname(__FILE__) . '/activate.sql');
      //     return $resutls['result'];
      //  }

        return true;
    }

    public function Deactivate(){
    	return true;
    }

    public function Init() {  
    	$this->Topic_AddTopicType('qa');  	
		return true;
    }
}
?>
