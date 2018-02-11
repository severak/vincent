<?php
// table list for Vincent
// arguments:
// - table (name)
// - page
// - pageCount
// - recordCount
// - fields
?>
<table class="pure-table pure-table-bordered">
	<thead>
		<th>#</th>
	<?php foreach ($fields as $field) { ?>
		<th><?=$field; ?></th>
	<?php } ?>
		<th></th>
	</thead>
	<?php foreach ($page as $ord=>$row) { ?>
	<tr>
	<td><?=$row['id'];?></td>
	<?php foreach ($fields as $field) { 
		$td = isset($row[$field]) ? $row[$field] : '';
		$td = htmlspecialchars($td);
	?>
	<td><?=$td;?></td>
	<?php } ?>
	<td>
		<a href="<?=Flight::url('/'.$table.'/edit/'.$row['id']);?>" class="pure-button button-primary"><i class="fa fa-pencil"></i> edit</a>
		<a href="<?=Flight::url('/'.$table.'/delete/'.$row['id']);?>" class="pure-button button-error"><i class="fa fa-trash"></i> delete</a>
	</td>
	</tr>
	<?php } ?>	
</table>

<?php if ($pageCount>1) { ?>
<form class="pure-form" method="get" action="<?=Flight::url('/'.$table.'/list'); ?>">
	<button type="submit" class="pure-button pure-button-primary">Jump to page:</button>
	<select name="page">
	<?php foreach (range(1,$pageCount) as $no) { ?>
		<option value="<?=$no; ?>" <?=$no==$pageNo ? 'selected' : ''; ?> ><?=$no; ?></option>
	<?php } ?>	
	</select>	
</form>
<?php } ?>
