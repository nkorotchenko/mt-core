<?php
class RouteApplication extends Application {
	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		$isCommingSoon = $settings->GetParam("core", "comming_soon");
		$commingSoonDate = $settings->GetParam("core", "comming_date");
		
		$pageClass = "index";
		
		if (count($args) > 0)
			$pageClass = $args[0];

		if ($isCommingSoon && !System::IsPageClass($pageClass, "comming")) {
			if (!System::IsPageClass($pageClass, "404")) {
				System::Redirect("/comming");
			}
		}
		
		//if (count($args) == 0)
		if (!System::IsAppExist($pageClass)) {
			if (!System::IsPageClass($pageClass, "404"))
				System::Redirect("/404");

			echo "Error 404: page not exist...";
		}
		else {
			System::RunApp($pageClass);
		}
	}
};
?>