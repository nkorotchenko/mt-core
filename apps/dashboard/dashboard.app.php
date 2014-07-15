<?php
class DashboardApplication extends Application {
	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		$pageClass = System::GetPageClass($args, 1);
		
		if (Auth::IsAuth()) {		
			if (System::IsPageClass($pageClass, "index")) {
				$theme = Themes::Get("default", $this);
				$template = $theme->GetTemplate("default");
				
				$theme->title = "Dashboard";
				$theme->Draw("index", $template);
			}
			else {
				$trace = debug_backtrace();
				_error("Undefinded page class '".$pageClass."'");
			}
		}
		else {			
			System::Redirect("/login?url=".$_SERVER["REQUEST_URI"]);
		}
	}
};
?>