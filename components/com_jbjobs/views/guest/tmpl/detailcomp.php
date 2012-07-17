<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 * Tested by	:	Zaki
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/detailcomp.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

$user   =& JFactory::getUser();		
$model = $this->getModel();
$id 	= JRequest::getVar('id', 0, 'get', 'string');
$company = $this->data[0];
?>
		<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_COMPANY_DETAILS'); ?></b></div>
	
	<table width="100%" class="jbj_tblborder">
		<tr>
			<td>
				<b><?php echo JText::_('JBJOBS_COMPANY_NAME'); ?>:</b>
			</td>
			<td align="80%">
				<?php 
				 if($company->show_name =='y'){
				 	echo $company->comp_name;
				 }else{
				 	echo JText::_('JBJOBS_NOT_DISPLAYED');
				 }
				 echo '<br />';

						$switch = $model->whichUse($id);
						switch($switch)
						{
							case 1:
								$query = "SELECT avatar FROM #__comprofiler WHERE avatarapproved='1' AND user_id='$id'";
								$db->setQuery($query);
								$i = $db->loadResult();
								if($i)
								{
									$img = JPATH_SITE.DS.'images'.DS.'comprofiler'.DS.$i;
									$pimg = JURI::base().'images/comprofiler/'.$i.'?'.time();
								}
								else
								{
									$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$id.'.jpg';
									$pimg = JURI::base().'images/jbjobs/'.$id.'.jpg?'.time();
								}
							break;
							case 2:
								$query = "SELECT avatar FROM #__community_users WHERE userid='$id'";
								$db->setQuery($query);
								$i = $db->loadResult();
								if($i)
								{
									$img = JPATH_SITE.DS.$i;
									$pimg = JURI::base().$i.'?'.time();
								}
								else
								{
									$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$id.'.jpg';
									$pimg = JURI::base().'images/jbjobs/'.$id.'.jpg?'.time();
								}
							break;
							default:
								$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$id.'.jpg';
								$pimg = JURI::base().'images/jbjobs/'.$id.'.jpg?'.time();
							break;
						}

					if(file_exists($img)) {
						echo '<img src="'.$pimg.'">';
					}
					else
					{
						$img = JURI::base().'components/com_jbjobs/images/nophoto.gif';
						echo '<img src="'.$img.'">';
					}
				 ?>
			</td>
			
		</tr>	
		<tr>
			<td>
				<b><?php 
				echo JText::_('JBJOBS_ADDRESS'); ?></b>
			</td>
			<td>
			
				<?php 
				 if($company->show_addr =='y'){
					echo $company->street_addr;
				}else{
				 	echo JText::_('JBJOBS_NOT_DISPLAYED');
				}	
					?>
			</td>
			
		</tr>	
		
		<tr>
			<td>
				<b><?php echo JText::_('JBJOBS_LOCATION'); ?>:</b>
			</td>
			<td>
				<?php 
				if($company->show_location =='y'){
					echo $company->city; ?>,<?php echo $company->state; ?><?php echo $company->country;
				}else{
				 	echo JText::_('JBJOBS_NOT_DISPLAYED');
				}						
				?>
			</td>
			
		</tr>	
		
			
		<tr>
			<td>
				<b><?php echo JText::_('JBJOBS_PHONE'); ?>:</b>
			</td>
			<td>
				<?php 
				if($company->show_phone =='y'){
					echo $company->primary_phone;
				}else{
				 	echo JText::_('JBJOBS_NOT_DISPLAYED');
				}	
				?>
			</td>
			
		</tr>	
		
		<tr>
			<td>
				<b><?php echo JText::_('JBJOBS_FAX'); ?>:</b>
			</td>
			<td>
				<?php 
				if($company->show_fax =='y'){
					echo $company->fax_number;
				}else{
				 	echo JText::_('JBJOBS_NOT_DISPLAYED');
				}		
				?>
			</td>
			
		</tr>	
		
		<tr>
			<td>
				<b><?php echo JText::_('JBJOBS_EMAIL'); ?>:</b>
			</td>
			<td>
				<?php 
				if($company->show_email =='y'){
					echo $company->email;
				}else{
				 	echo JText::_('JBJOBS_NOT_DISPLAYED');
				}		
					
					?>
			</td>
			
		</tr>			
	</table>
	<?php
	$model->showCustomFieldValue($this->custom, $id); ?>