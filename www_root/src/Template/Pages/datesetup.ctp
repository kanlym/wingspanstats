<?php 
?>
<div class="row">
 <div class="panel-heading">
 <h1> Set audited dates </h1>
 </div>
<table width="100%" class="table table-striped table-bordered table-hover">

<form method="POST">
<tr>
	<td>	Start Date</td>
	<td><input name="dateStart" type="text" id="dateStart"></td>
</tr>
<tr>
	<td>End Date</td>	
	<td><input name="dateEnd" type="text" id="dateEnd"></td>
</tr>	
<tr>
<td></td> <td><button>Save</button></td>
</tr>
</form>

</div>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
	$(document).ready(function() {
		$('#dateStart').datepicker({ dateFormat: 'yy-mm-dd' });
		$('#dateEnd').datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>