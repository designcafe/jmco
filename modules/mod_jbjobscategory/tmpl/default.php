<?php

// no direct access
defined('_JEXEC') or die('Restricted access'); 

if (!function_exists('call_css_mod_jbjobscategory')) {	
	function call_css_mod_jbjobscategory() {
		$document = & JFactory::getDocument(); 
		$document->addCustomTag( '<link rel="stylesheet" type="text/css" href="'. JURI::base() . 'modules/mod_jbjobscategory/css/style.css"/>' ); 	
	}
	call_css_mod_jbjobscategory();

}

$html = '<link href="'.JURI::base(). 'modules/mod_jbjobscategory/css/style.css" rel="stylesheet" type="text/css" />';
echo $html;


?>
<?php 
if(count($rows) > 0){
$width_column = ceil (100 /$total_column);
$count_categ = count($rows);

?>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<?php 
	$counter_col =0;
	$counter_row =0;
	
	$index_row=0;
	for($i=1; $i <= $total_column; $i++) 
	{?>
		
			<td valign="top"> 
				<?php				
				for($j=1;$j<=$total_row;$j++){
					
					?>
					<div>
					<?php 
					if($view_by == 1){
					
						 if( $index_row < $count_categ ) { ?>
							<p style="font-size:120%; font-weight:600; margin:5px 0; color:#666; text-decoration:underline;"><?php echo $rows[$index_row]->category;?></p>
							<?php					
							$spec = modJBJobsHelper::getItem($rows[$index_row]->id, $show_empty_count);
							if(count($spec) >0){					
								for($k=0;$k<count($spec);$k++){
									$row = $spec[$k];	
									$ref	= JRoute::_( 'index.php?option=com_jbjobs&view=guest&layout=searchbyspec&id='.$row->id);								
									?>
									<a href="<?php echo $ref;?>">
										<?php echo $row->specialization;?>
										<?php
										if($show_count)
										{
											echo '(' . $row->thecount . ')';
										}
										?>
									</a>
									<br />
									<?php 
								}
							} 
						}// end if($index_row < $count_categ)
						
					
					} // end if($view_by == 1)
					
					if($view_by == 2){?>
						<?php
						 if( $index_row < $count_categ ) { 
							$ref	= JRoute::_( 'index.php?option=com_jbjobs&view=guest&layout=searchbyloc&id='.$rows[$index_row]->id);
							?>
							<a href ="<?php echo $ref;?>">
								<?php echo $rows[$index_row]->country;?>
								<?php
								if($show_count)
								{
									echo '(' . $rows[$index_row]->thecount . ')';
								}
								?>
							</a>
							<br />
							<?php	
						 }// end if($index_row < $count_categ)					
					
					} // end if($view_by == 2)
					
					if($view_by == 3){?>
						<?php
						$ref	= JRoute::_( 'index.php?option=com_jbjobs&view=guest&layout=searchbypos&id='.$rows[$index_row]->id);
						?>						
						<a href ="<?php echo $ref;?>">
							<?php echo $rows[$index_row]->pos_type;?>
							<?php
							if($show_count)
							{
								echo '(' . $rows[$index_row]->thecount . ')';
							}
							?>
						</a>
						<br />
						<?php				
					
					} // end if($view_by == 3)
					
					if($view_by == 4){?>
						<?php
						if( $index_row < $count_categ ) {
							$ref	= JRoute::_( 'index.php?option=com_jbjobs&view=guest&layout=searchbyind&id='.$rows[$index_row]->id);
							?>		
							<a href ="<?php echo $ref;?>">
								<?php echo $rows[$index_row]->industry;?>
								<?php
								if($show_count)
								{
									echo '(' . $rows[$index_row]->thecount . ')';
								}
								?>
							</a>
							<br />
						<?php	
						 }// end if($index_row < $count_categ)						
					} // end if($view_by == 4)

					
					?>					
					</div>				
					
					<?php
					$index_row++;
				}
				
				if($i==$total_column  && ($index_row) < $count_categ){
					
					for($z = $index_row ;$z<$count_categ;$z++){						
					?>
						<div>
						<?php 
						if($view_by == 1){?>
							<p style="font-size:120%; font-weight:600; margin:5px 0; color:#666;  text-decoration:underline;"><?php echo $rows[$index_row]->category;?></p>	
							<?					
							$spec_2 = modJBJobsHelper::getItem($rows[$index_row]->id, $show_empty_count);
							if(count($spec_2) >0){					
								for($k2=0;$k2<count($spec_2);$k2++){
									$row2 = $spec_2[$k2];	
									$ref2	= JRoute::_( 'index.php?option=com_jbjobs&view=guest&layout=searchbyspec&id='.$row2->id);
									?>
									<a href="<?php echo $ref2;?>">
										<?php echo $row2->specialization;?>
										<?php
										if($show_count)
										{
											echo '(' . $row2->thecount . ')';
										}
										?>
									</a>
									<br />
									<?php 		
								}
							} 
						} // end if($view_by == 1)
						
						if($view_by == 2){?>
						<?php
						$ref	= JRoute::_( 'index.php?option=com_jbjobs&view=guest&layout=searchbyloc&id='.$rows[$index_row]->id);
						?>
						<a href ="<?php echo $ref;?>">
							<?php echo $rows[$index_row]->country;?>
							<?php
							if($show_count)
							{
								echo '(' . $rows[$index_row]->thecount . ')';
							}
							?>
						</a>
						<br />
						<?php				
					
					} // end if($view_by == 2)
					
					if($view_by == 3){?>
						<?php
						$ref	= JRoute::_( 'index.php?option=com_jbjobs&view=guest&layout=searchbypos&id='.$rows[$index_row]->id);
						?>						
						<a href ="<?php echo $ref;?>">
							<?php echo $rows[$index_row]->pos_type;?>
							<?php
							if($show_count)
							{
								echo '(' . $rows[$index_row]->thecount . ')';
							}
							?>
						</a>
						<br />
						<?php				
					
					} // end if($view_by == 3)
					
					if($view_by == 4){?>
						<?php
						$ref	= JRoute::_( 'index.php?option=com_jbjobs&view=guest&layout=searchbyind&id='.$rows[$index_row]->id);
						?>		
						<a href ="<?php echo $ref;?>">
							<?php echo $rows[$index_row]->industry;?>
							<?php
							if($show_count)
							{
								echo '(' . $rows[$index_row]->thecount . ')';
							}
							?>
						</a>
						<br />
						<?php				
					} // end if($view_by == 4)
					?>
					</div>
					<?php
						$index_row++;
					}
				}
				?>
			
			</td>
		<?php 
		
	}
	?>
	
</tr>
</table>

<?php 
} 
?>