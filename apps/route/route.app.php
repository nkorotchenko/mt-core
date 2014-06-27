<?php
class RouteApplication extends Application {

	public function ExclusionPages($pageClass)
	{
		$exclusionList = array(
			"admin",
			"control",
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
		
		$isCommingSoon = $settings->GetParam("core", "comming_soon");
		$commingSoonDate = $settings->GetParam("core", "comming_date");
		
		$pageClass = "index";
		
		if (count($args) > 0)
			$pageClass = $args[0];

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