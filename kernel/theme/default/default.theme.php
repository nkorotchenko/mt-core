<?php
class DefaultTheme extends Theme {

	public function Header()
	{
		echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><meta http-equiv='X-UA-Compatible' content='IE=edge'>";
		echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'><meta name='description' content=''><meta name='author' content=''>";
		if ($this->title)
			echo "<title>".$this->title."</title>";
		echo "<script src='".$this->url."/js/jquery.min.js'></script>";
		echo "<link rel='stylesheet' href='".$this->url."/css/bootstrap.min.css'>";
		/*<link rel="stylesheet" type="text/css" href="<?php echo $this->url; ?>/css/banners.css" />
		<script type="text/javascript" src="<?php echo $this->url; ?>/js/selectBox.min.js"></script>*/
	}
	
	public function Content()
	{
		echo "</head><body>";
	}
	
	public function EndContent()
	{
		echo "<script src='".$this->url."/js/bootstrap.min.js'></script>";
		echo "</body>";
	}
	
	public function Footer()
	{
		echo "</html>";
	}	

	public function Draw ($name, $params)
	{
		$fileName = null;
		if (!empty($name))
			$fileName = $this->app->path."/pages/$name.page.php";
			
		if (!file_exists($fileName))
			System::Redirect("/404");
			
		$this->Header();
		
		parent::HeaderStrings();
		
		$this->Content();		
		
		include($fileName);
		
		$this->EndContent();
		
		parent::FooterStrings();
		
		$this->Footer();
	}
}
?>