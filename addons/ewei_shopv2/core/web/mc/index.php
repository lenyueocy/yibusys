<?php  
if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}

class Index_EweiShopV2Page extends WebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		
		header("location:" . webUrl("mc.fans"));
		exit();
	}


}
?>