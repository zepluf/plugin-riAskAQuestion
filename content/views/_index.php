<form action="<?php echo $router->generate('admin_askaquestion', riGetAllGetParams());?>" method="POST">
<input type="hidden" name="sub_action" value="mass_update" />
<table>
	<tr class="dataTableHeadingRow">
		<th class="dataTableHeadingContent"><?php echo ri('Id');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Objects id');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Type');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Customer name');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Customer email');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Message');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Created on');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Delete');?></th>
	</tr>	
<?php 
	foreach($result_list->getResults() as $q){ ?>
	<tr <?php if($q->id == $id) echo " class='current'"?>>
		<td><?php echo $q->id;?></td>
		<td><?php echo zen_draw_input_field('questions['.$q->id.'][data][objects_id]', $q->objectsId);?></td>
		<td><?php echo zen_draw_input_field('questions['.$q->id.'][data][type]', $q->type);?></td>		
		<td><?php echo zen_draw_input_field('questions['.$q->id.'][data][customers_name]', $q->customersName);?></td>
		<td><?php echo zen_draw_input_field('questions['.$q->id.'][data][customers_email_address]', $q->customersEmailAddress);?></td>
		<td><?php echo zen_draw_input_field('questions['.$q->id.'][data][message]', $q->message);?></td>
		<td><?php echo zen_draw_input_field('questions['.$q->id.'][data][created_on]', $q->createdOn);?></td>
		<td><?php echo zen_draw_checkbox_field('questions['.$q->id.'][delete]', 1) ?></td>
	</tr>	
<?php 
	}
?>
</table>
<button type="submit"><?php echo ri('Mass update')?></button>
</form>
<?php  echo $riview->render('riResultList::_pagination.php', array('result_list' => $result_list, 'current_route' => 'admin_askaquestion'))?>