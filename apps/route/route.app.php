<?php
class RouteApplication extends Application {

	public function ExclusionPages($pageClass)
	{
		$exclusionList = array(
			"comming",
			"dashboard",
			"login",
			"logout"
		);
		
		foreach ($exclusionList as $item) {
			if (System::IsPageClass($pageClass, $item))
				return true;
		}
		
		return false;
	}

	public function main ($args, $params)
	{
		/*$theme = Themes::Get("default", $this);
		$template = $theme->GetTemplate("default");
		
		$theme->title = "Hello world";
		$theme->Draw("index", $template);*/
		
		///////////////////////////////////////////////////////////
		
		$settings = System::GetSettings();
		
		$isCommingSoon = $settings->core["comming_soon"];
		$commingSoonDate = $settings->core["comming_date"];
		
		$pageClass = System::GetPageClass($args);
			
		if ($this->ExclusionPages($pageClass)) {
			if (System::IsPageClass($pageClass, "dashboard")) {
				if (System::IsAppExist("dashboard")) {
					System::RunApp("dashboard");
					return true;
				}
			}
			else if (System::IsAppExist("system"))
			{
				System::RunApp("system");
				return true;
			}
		}

		if (!$this->ExclusionPages($pageClass)) {
			if ($isCommingSoon && !System::IsPageClass($pageClass, "comming")) {
				if (!System::IsPageClass($pageClass, "404")) {
					System::Redirect("/comming");
				}
			}
		}
		
		if (!System::IsAppExist($pageClass)) {
			if (!System::IsPageClass($pageClass, "404"))
				System::Redirect("/404?page=".$pageClass);

			if (System::IsAppExist("error"))
				System::RunApp("error", null, array("errorNumber"=>404,
					"errorText"=>"Page '".$_GET["page"]."' not exist..."));
			else
				echo "Error 404: Page '".$_GET["page"]."' not exist...";
		}
		else {
			System::RunApp($pageClass);
		}
	}
};
?>