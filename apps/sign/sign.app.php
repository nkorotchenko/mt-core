<?php
class SignApplication extends Application {
	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		$pageClass = System::GetPageClass($args);
		
		if (isset($_POST["login"]) && isset($_POST["password"])) {
			if (Auth::Check(null, $_POST["login"], $_POST["password"])) {
				Auth::SignIn();
				if (isset($_GET["url"]))
					System::Redirect($_GET["url"]);
				//else System::Redirect($_GET["url"]);
			}
		}
		
		if (System::IsPageClass($pageClass, "login")) {
			$theme = Template::Get("default", $this);
			
			$theme->title = "Sign in";
			$theme->Draw("signin", null);
		}
		else if (System::IsPageClass($pageClass, "logout")) {
			Auth::SignOut();
			System::Redirect("/index");
		}
		else {
			$trace = debug_backtrace();
			trigger_error("Undefinded page class '".$pageClass."' in ".get_class($this),
				E_USER_NOTICE);
		}
	}
};
?>