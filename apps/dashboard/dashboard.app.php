<?php
class DashboardApplication extends Application {
	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		$pageClass = System::GetPageClass($args, 1);
		
		if (Auth::IsAuth()) {		
			if (System::IsPageClass($pageClass, "index")) {
				$theme = Template::Get("default", $this);
				
				$theme->title = "Dashboard";
				$theme->Draw("index", null);
			}
			else {
				$trace = debug_backtrace();
				trigger_error("Undefinded page class '".$pageClass."' in ".get_class($this), E_USER_NOTICE);
			}
		}
		else {			
			System::Redirect("/login?url=".$_SERVER["REQUEST_URI"]);
		}
	}
};
?>