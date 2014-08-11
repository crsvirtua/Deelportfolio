<?php
function Make_Connection()
	{
  	if (!($Connection_Id = mysql_connect(DB_HOST, DB_USER, DB_PASS )))
   		die ("<hr><h2>Kan geen connectie maken met ".DB_HOST." </h2><hr>");
  	return $Connection_Id;
	}
function Select_Database($Database)
	{
  	if (!mysql_select_db($Database))
  		die ("<hr><h2>Problemen met selecteren database ".$Database."</h2><hr>");
  	return;
	}

function Run_Selection($Link_Id, $Selection)
	{
  	if (!($Query_Result = mysql_query($Selection, $Link_Id)))
  		die ("<hr><h2>Problemen met uitvoeren query:</h2><hr> ".$Selection."");
  	return $Query_Result;
	}

function Close_Connection($Connection_Id)
	{
  	mysql_close($Connection_Id);
	}

?>