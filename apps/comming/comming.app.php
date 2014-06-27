<?php
class CommingApplication extends Application {
	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		
		$commingSoonDate = $settings->GetParam("core", "comming_date");
		$time = strtotime($commingSoonDate);
		
		$theme = Template::Get("default", $this);
		
		$theme->title = "Comming soon";		
		$theme->commingSoonDate = $time;
		
		$theme->Draw("default", null);
		
		/*$theme = Template::Get("default", $this);
		$theme->title = "Главная";
		$theme->Draw("index/index", null);

		$temptime = mktime( 13, 30, 0, 5, 31, 2014 );//time();
		echo strftime('%Hh%M %A %d %b',$temptime);
		$temptime = System::DateAdd('m',1,$temptime);
		echo '<p>';
		echo strftime('%Hh%M %A %d %b',$temptime);*/
	}
};
?>