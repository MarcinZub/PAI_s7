<?php 
session_start();
if(!isset($_SESSION['logged']))
{
	header('location: ../index.php');
	exit();
}

echo '<div id="menuWrap">';
echo '<ul id="menu">';
if($_SESSION['rola']==0)
{
	echo '<li><a href="index.php?page=1" title="Użytkownicy">Użytkownicy</a></li>';
}

echo '<li><a href="index.php?page=2" title="Magazyny">Magazyny</a></li>';

if($_SESSION['rola']!=2)
{
	echo '<li><a href="index.php?page=3" title="Towar">Towar</a></li>';
}	
		
echo '<li><a href="index.php?page=4" title="Koszyk">Koszyk</a></li>';
echo '<li><a href="logout.php" title="Wyloguj">Wyloguj</a></li>';
echo'</ul>';
echo '</div>';

?>