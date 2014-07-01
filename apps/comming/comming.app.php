<?php
class CommingApplication extends Application {
	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		
		$commingSoonDate =
			strtotime($settings->core["comming_date"]);
		
		$theme = Template::Get("default", $this);
		
		$theme->title = "Comming soon";
		$theme->commingSoonDate = $commingSoonDate;
		$theme->Draw("default", null);
	}
};
?>