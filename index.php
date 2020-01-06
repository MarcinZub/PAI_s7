<?php  require("function.php");
 session_start();

Get_head();

if((!isset($_SESSION['logged']))||($_SESSION['logged']==false))
{
	Login();
	if(isset($_SESSION['info']))
	{
		echo $_SESSION['info'];
	}unset($_SESSION['info']);
	
}else if($_SESSION['logged']==true)
{
	Get_page();
}


Get_footer();
?>