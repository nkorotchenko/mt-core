<?php
class SignApplication extends Application {
	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		$pageClass = System::GetPageClass($args);
		
		if (System::IsPageClass($pageClass, "login")) {
			$theme = Template::Get("default", $this);
			
			$theme->title = "Sign in";
			$theme->Draw("signin", null);
		}
		else {
			$trace = debug_backtrace();
			trigger_error("Undefinded page class '".$pageClass."' in ".get_class($this),
				E_USER_NOTICE);
		}
	}
};
?>