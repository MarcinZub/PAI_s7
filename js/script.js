function edytujilosc(id) 
{
	var ile=$("#ile_"+id).val();
	$.post("include/edytujkoszyk.php", { id: id, ile: ile },
	function(data) 
	{
		$('#wynik').show();
		$('#wynik').html(data);
		
		$('#wynik').delay(3000).hide('slow');
	});
}
