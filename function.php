<?php

function Get_head(){ require ('head.php');}

function Get_page(){ require ('page.php');}

function Get_footer(){ require ('footer.php');}

function Get_menu(){ require('include/menu.php');}

function Get_user(){ require('include/user.php');}

function Get_magazyny(){ require('include/magazyny.php');}

function Get_towar(){ require('include/towar.php');}

function Get_koszyk(){ require('include/koszyk.php');}


/*DLA PLIKÓW FOLDERU include*/
function Get_head_out(){ require ('../head.php');}

function Get_menu_out(){ require('menu_out.php');}

function Get_footer_out(){ require ('../footer.php');}

function Get_page_out(){ require ('../page.php');}//po co?



function Get_user_out(){ require('user.php');}//po co?

function Get_magazyny_out(){ require('magazyny.php');} //po co?

function Get_towar_out(){ require('towar.php');}// po co?

function Get_koszyk_out(){ require('koszyk.php');} //po co?

/*DLA PLIKÓW FOLDERU include - END*/


function Sessioninfo()
{
	if(isset($_SESSION['info'])){ echo $_SESSION['info'];}
	unset($_SESSION['info']);
}

function Login()
{
	echo '<form id="formlogin" action="login.php" method="post">';
	echo 'Login: <input type="text" name="login" id="login" placeholder="Login" required><br />';
	echo 'Hasło: <input type="password" name="haslo" id="haslo" placeholder="Hasło" required><br />';
	echo '<input type="submit" value="Zaloguj!">';
	echo '</form>';
}

function Rejestruj()
{
	#echo '<script src="js/rejestracja.js"></script>';
	echo '<form id="formrejestracja" action="include/rejestracja.php" method="post">';
	echo '<div class="form_rejestracja">Typ:<br /><select name="typ_user" id="typ_user">';
	echo '<option selected value="-1"></option>';
    echo '<option value="0">Administrator</option>';
    echo '<option value="1">Magazynier</option>';
    echo '<option value="2">Wydawca</option>';
    echo '</select><br /></div>';	
	echo '<div class="form_rejestracja">Imie:<br /><input type="text" id="imie" name="imie" placeholder="Imie" required></div>';
	echo '<div class="form_rejestracja">Nazwisko:<br /><input type="text" id="nazwisko" name="nazwisko" placeholder="Nazwisko" required></div>';
	echo '<div class="form_rejestracja">Login:<br /><input type="text" id="login" name="login" placeholder="Login" required></div>';
	echo '<div class="form_rejestracja">Miejscowości: <br /><select name="miejscowosc" id="miejscowosc"></div>';
	echo '<option selected value="-1"></option>';
    echo '<option value="Poniszowice">Poniszowice</option>';
    echo '<option value="Pyskowice">Pyskowice</option>';
    echo '<option value="Stare Pyskowice">Stare Pyskowice</option>';
    echo '<option value="Taciszów">Taciszów</option>';
    echo '<option value="Toszek">Toszek</option>';
    echo '</select><br /></div>';
	echo '<div class="form_rejestracja">Hasło:<br /><input type="password" name="haslo1" id="haslo1" placeholder="Hasło" required></div>';
	echo '<div class="form_rejestracja">Powtórz Hasło:<br /><input type="password" name="haslo2" id="haslo2" placeholder="Powtórz Hasło" required></div>';
	echo '<br /><br /><input type="submit" value="Rejestruj!">';
	echo '</form>';
}

function Dodajmagazyn()
{
	echo '<form id="dodajmagazyn" action="include/dodajusunmagazyn.php" method="post">';
	echo '<div class="form_dodajMagazyn">Nazwa: <br /><input type="text" id="nazwa" name="nazwa" placeholder="Nazwa" required></div>';
	echo '<div class="form_dodajMagazyn">Region: <br /><select name="region" id="region">';
	echo '<option selected value="-1"></option>';
    echo '<option value="Poniszowice">Poniszowice</option>';
    echo '<option value="Pyskowice">Pyskowice</option>';
    echo '<option value="Stare Pyskowice">Stare Pyskowice</option>';
    echo '<option value="Taciszów">Taciszów</option>';
    echo '<option value="Toszek">Toszek</option>';
    echo '</select></div>';
	echo '<div class="form_dodajMagazyn">Opis: <br /><input type="textarea" name="opis" id="opis" placeholder="Brak"></div>';
	echo '<br /><br /><br /><input type="submit" value="Dodaj!">';
	echo '</form>';		
}

function Edytujuser()
{
	echo '<form id="fromedycja" action="zapiszedycje.php" method="post">';
	echo '<input type="hidden" name="id" value='.$row['id_uzytkownika'].'>';
	echo 'Typ: <select name="typ_user" id="typ_user">';
	echo '<option ';
	echo $row['rola']==0 ? 'selected' :'';
	echo ' value="0">Administrator</option>';
	echo '<option ';
	echo $row['rola']==1 ? 'selected' :'';
	echo ' value="1">Magazynier</option>';
	echo '<option ';
	echo $row['rola']==2 ? 'selected' :'';
	echo ' value="2">Wydawca</option>';
	echo '</select><br />';	
	echo 'Imie: <input type="text" id="imie" name="imie" placeholder="Imie" value='.$row['imie'].'><br />';
	echo 'Nazwisko: <input type="text" id="nazwisko" name="nazwisko" placeholder="Nazwisko" value='.$row['nazwisko'].'><br />';
	echo 'Login: <input type="text" id="login" name="login" placeholder="Login" value='.$row['login'].'><br>';
	echo 'Miejscowości: <select name="miejscowosc" id="miejscowosc" >';
	echo '<option selected value="-1"></option>';
	echo '<option ';
	echo $row['region']=="Poniszowice"? 'selected' :'';
	echo ' value="Poniszowice">Poniszowice</option>';
	echo '<option ';
	echo $row['region']=="Pyskowice"? 'selected' :'';
	echo ' value="Pyskowice">Pyskowice</option>';
	echo '<option ';
	echo $row['region']=="Stare Pyskowice"? 'selected' :'';
	echo ' value="Stare Pyskowice">Stare Pyskowice</option>';
	echo '<option ';
	echo $row['region']=="Taciszów"? 'selected' :'';
	echo ' value="Taciszów">Taciszów</option>';
	echo '<option ';
	echo $row['region']=="Toszek"? 'selected' :'';
	echo ' value="Toszek">Toszek</option>';
	echo '</select><br />';
	echo 'Aktywny: <input type="checkbox" name="aktywny" id="aktywny" value="aktywny"';
	echo $row['aktywny']? 'checked' :'';
	echo '><br>';
	//Dodać w JS wygaszenie inputów 'date' i 'time', gdy czeckbox 'wygaszenie' jest zaznaczony, tak żeby użytkownik nie mógł tego edytwać
	echo 'Data wygasniecia: <input type="date" name="date" id="date" value='.substr($row['data_wygasniecia'], 0, 10).'><br>';
	echo 'Czas wygasniecia: <input type="time" name="time" id="time" value='.substr($row['data_wygasniecia'], 11, 8 ).'><br>';
	echo 'Nie wygaszaj konta: <input type="checkbox" name="wygaszenie" id="wygaszenie" value="wygaszenie"';
	echo $row['data_wygasniecia']=="0000-00-00 00:00:00"? 'checked' :'';
	//----------------------------------------------------------------------------------------------------------
	echo '><br>';
	echo 'Zmien Hasło użytkownika : <input type="password" name="haslo1" id="haslo1" placeholder="Hasło" value="domyslne"><br>';
	echo 'Powtórz Hasło: <input type="password" name="haslo2" id="haslo2" placeholder="Powtórz Hasło" value="domyslne"><br>';
	echo '<input type="submit" value="Edytuj!">';
	echo '</form>';	
}

?>