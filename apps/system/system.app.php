<?php
class SystemApplication extends Application {

	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		$pageClass = System::GetPageClass($args);
		
		if (System::IsPageClass($pageClass, "comming")) {
			$theme = Themes::Get("default", $this);
			$template = $theme->GetTemplate("default");
			
			$commingSoonDate =
				strtotime($settings->core["comming_date"]);
			
			$theme->title = "Comming soon";
			$theme->commingSoonDate = $commingSoonDate;
			$theme->Draw("comming", $template);
		}		
		else if (System::IsPageClass($pageClass, "login")) {
		
			if (isset($_POST["login"]) && isset($_POST["password"])) {
		
				$remember = (isset($_POST["password"])) ? true : false;
			
				if (Auth::Check(null, $_POST["login"], $_POST["password"])) {
					Auth::SignIn(null, null, $remember);
					if (isset($_GET["url"]))
						System::Redirect($_GET["url"]);
					//else System::Redirect($_GET["url"]);
				}
			}
		
			$theme = Themes::Get("default", $this);
			$template = $theme->GetTemplate("default");
			
			$theme->title = "Sign in";
			$theme->Draw("signin", $template);
		}
		else if (System::IsPageClass($pageClass, "logout")) {
			Auth::SignOut();
			System::Redirect("/index");
		}
		else if (System::IsPageClass($pageClass, "index")) {
			$theme = Themes::Get("default", $this);
			$template = $theme->GetTemplate("default");
			
			$theme->title = "Index page";
			$theme->Draw("index", $template); 
		}		
		else {
			_error("Undefinded page class '".$pageClass."'");
		}
	}
};
?>