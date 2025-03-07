<html><head><title>Tout JavaScript.com - Mouseover sur un tableau</title>
<STYLE>
  .tabnormal{background-color:white; color:navy; font-weight:bold}
  .tabover{background-color:red; color:white; font-weight:bold}
</STYLE>
</HEAD>

<BODY text="navy" bgcolor="#FFFFFF" alink="#FF8C00" link="#FF8C00" vlink="#FF8C00">
<FONT FACE="Arial" SIZE='-1' COLOR="navy"><CENTER>
<BIG><B>TARIF ARTICLES</B></BIG><BR><BR>
<BR><BR>
<BR>
<BR>
<TABLE border=1 cellpadding=3 cellspacing=0 style="border-width:1px;border-style:solid;border-color:navy">

<?
	/*CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	*/
	require "config.php";
	require "connect_db.php";
	require "functions.php";

	$sql  = "SELECT * ";
	$sql .= "FROM produits ORDER BY produit;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) {
?>
	
<TR class="tabnormal" onmouseover="this.className='tabover'" onmouseout="this.className='tabnormal'">
	<TD><?php echo $users_["produit"]; ?></TD>
	<TD align="right"><?php echo $users_["prix"]; ?></TD>
</TR>
<? }?>
</TABLE>
<BR><BR>



<BR><BR>

<TABLE>
<TR>

</TR>
</TABLE>

<BR><BR><BR>
<BR><BR><BR><BR><BR>

</FONT>
</BODY>
</HTML>

<!-- Script développé par Olivier Hondermarck  -->
<!-- D'autres scripts et des conseils sur http://www.toutjavascript.com -->

