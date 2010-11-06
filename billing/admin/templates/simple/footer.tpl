
    </div>
  </div>

</td><td id="toolbar" valign="top">

<form method="get" onsubmit="intellisearch();return false">
<div align="center" id="intellisearch"><img src="images/icons/search.png" alt="Search" width="16" height="16" align="absmiddle" /> <input type="text" id="intellisearchval" size="25" /> <img src="images/delete.gif" alt="Cancel" width="16" height="16" align="absmiddle" id="intellisearchcancel" />
<div align="left" id="searchresults"></div>
</div>
<input type="submit" style="display:none;">
</form>

<br />

{include file="simple/sidebar.tpl"}

<br />

<form method="get" action="search.php">
<span class="header"><img src="images/icons/search.png" class="absmiddle" width="16" height="16" /> Advanced Search</span><br />
    <select name="type" id="searchtype" onchange="populate(this)">
      <option value="clients">Clients</option>
      <option value="orders">Orders</option>
      <option value="services">Services</option>
      <option value="domains">Domains</option>
      <option value="invoices">Invoices</option>
      <option value="tickets">Tickets</option>
    </select><br />
    <select name="field" id="searchfield">
      <option>Client ID</option>
      <option selected="selected">Client Name</option>
      <option>Company Name</option>
      <option>Email Address</option>
      <option>Address 1</option>
      <option>Address 2</option>
      <option>City</option>
      <option>State</option>
      <option>Postcode</option>
      <option>Country</option>
      <option>Phone Number</option>
      <option>CC Last Four</option>
    </select><br />
    <input type="text" name="q" size="20" /><br />
    <input type="submit" value="Search" class="button" />
</form>

</td></tr></table>

<div id="footer">Copyright &copy; <a href="http://www.whmcs.com/" target="_blank">WHMCompleteSolution</a>.  All Rights Reserved.</div>

</body>
</html>