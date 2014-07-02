<?php
class RouteApplication extends Application {

	public function ExclusionPages($pageClass)
	{
		$exclusionList = array(
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
		$settings = System::GetSettings();
		
		$isCommingSoon = $settings->core["comming_soon"];
		$commingSoonDate = $settings->core["comming_date"];
		
		$pageClass = "index";
		
		if (count($args) > 0)
			$pageClass = System::GetPageClass($args);
			
		if (System::IsPageClass($pageClass, "login") || System::IsPageClass($pageClass, "logout")) {
			if (System::IsAppExist("sign"))
			{
				System::RunApp("sign");
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