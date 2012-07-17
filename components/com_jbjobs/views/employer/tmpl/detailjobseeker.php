<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/employer/tmpl/detailjobseeker.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows the complete details of the jobseeker (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
$jobseeker = $this->data;
$model = $this->getModel();
$id_resume 	 = $model->getActiveResume($jobseeker->jseekerid);
$id_cover 	 = $model->getActiveCoverletter($jobseeker->jseekerid);
$link_resume = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=viewresume&id='.$id_resume);
$link_cover  = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=viewcoverletter&id='.$id_cover);
?>
	
<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_JOBSEEKER_DETAILS'); ?></b></div>
	
<form action="index.php" method="post" name="regJobSeeker" enctype="multipart/form-data">

		<div class="border">
		<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_JOBSEEKER_INFORMATION'); ?></div>

			<table class="admintable">
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_NAME'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->name; ?>
				</td>
			</tr>		
		    </table>
	</div>
	<div class="sp20">&nbsp;</div>
		
		<div class="border">
		<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_EDUCATION'); ?></div>

			<table class="admintable">
			
			<th colspan="2"><?php echo JText::_('JBJOBS_HIGHEST_EDUCATION'); ?></th>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DEGREE_LEVEL'); ?>:</label>
				</td>
				<td><?php echo $jobseeker->degree_level; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_MAJOR'); ?>:</label>
				</td>
				<td><?php echo $jobseeker->major; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_YEAR_GRADUATED'); ?>:</label>
				</td>
				<td><?php echo $jobseeker->ug_graduated; ?>
				</td>
			</tr>	
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COLLEGE/UNIVERSITY'); ?>:</label>
				</td>
				<td><?php echo $jobseeker->ug_university; ?>
				</td>
			</tr>	
			
			<TH colspan="2"><?php echo JText::_('JBJOBS_SECOND_HIGHEST_EDUCATION'); ?></TH>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DEGREE_LEVEL'); ?>:</label>
				</td>
				<td><?php echo ($jobseeker->pg_degree_level != "") ? $jobseeker->pg_degree_level : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_MAJOR'); ?>:</label>
				</td>
				<td><?php echo ($jobseeker->pg_major != "") ? $jobseeker->pg_major : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_YEAR_GRADUATED'); ?>:</label>
				</td>
				<td>
					<?php echo ($jobseeker->pg_graduated != "0000") ? $jobseeker->pg_graduated : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>' ; ?>
				</td>
			</tr>	
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COLLEGE/UNIVERSITY'); ?>:</label>
				</td>
				<td><?php echo ($jobseeker->pg_university != "") ? $jobseeker->pg_university : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?>
				</td>
			</tr>

		    </table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
		<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_ATTACHED_RESUME_COVER'); ?></div>

			<table class="admintable">
			<tr>
				<td class="key">
					<label for="name"><?php echo JText::_('JBJOBS_RESUME'); ?>:</label>
				</td>
				<td><?php if($id_resume){ ?>
					<input type="button" value="<?php echo JText::_('JBJOBS_VIEW'); ?>" onclick="location.href ='<?php echo $link_resume; ?>'"  class="button"/>
					<?php
						}
						else{ ?>
							<i><?php echo JText::_('JBJOBS_RESUME_NOT_FOUND'); ?></i>
					<?php	}
					?>	
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="name"><?php echo JText::_('JBJOBS_COVER'); ?>:</label>
				</td>
				<td><?php if($id_cover){ ?>
					<input type="button" value="<?php echo JText::_('JBJOBS_VIEW'); ?>" onclick="location.href ='<?php echo $link_cover; ?>';"  class="button"/>
					<?php
						}
						else{ ?>
							<i><?php echo JText::_('JBJOBS_COVER_NOT_FOUND'); ?></i>
					<?php	}
					?>	
				</td>
			</tr>
		    </table>
	</div>
	<div class="sp20">&nbsp;</div>
		
		<div class="border">
		<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_EXPERIENCE'); ?></div>

			<table class="admintable">
			
			<th colspan="2"><?php echo JText::_('JBJOBS_CURRENT_EMPLOYMENT'); ?></th>  
			<tr>
				<td class="key">
					<label for="name"><?php echo JText::_('JBJOBS_CURRENT_EMPLOYER'); ?>:</label>
				</td>
				<td><?php echo ($jobseeker->current_employer != "") ? $jobseeker->current_employer : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?></td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name"><?php echo JText::_('JBJOBS_CURRENT_POSITION'); ?>:</label>
				</td>
				<td><?php echo $jobseeker->current_position; ?></td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_AREA_OF_SPECIALIZATION'); ?>:</label>
				</td>
				<td><?php echo $jobseeker->specialization; ?>
				</td>
			</tr>	
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_EXPERIENCE'); ?>:</label>
				</td>
				<td>
				<?php echo $jobseeker->exp_name; ?>
				</td>
			</tr>	
			
			<th colspan="2"><?php echo JText::_('JBJOBS_PREVIOUS_EMPLOYMENT'); ?></th> 
			<tr>
				<td class="key">
					<label for="name"><?php echo JText::_('JBJOBS_PREVIOUS_EMPLOYER'); ?>:</label>
				</td>
				<td><?php echo ($jobseeker->prev_employer != "") ? $jobseeker->prev_employer : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?></td>
			</tr>
			
			<tr>
				<td class="key">
					<label for="name"><?php echo JText::_('JBJOBS_DESIGNATION'); ?>:</label>
				</td>
				<td><?php echo ($jobseeker->designation != "") ? $jobseeker->designation : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?></td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_EXPERIENCE'); ?>:</label>
				</td>
				<td><?php 
					if($jobseeker->from_date == "0000-00-00" && $jobseeker->to_date == "0000-00-00")
						echo '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>';
					else
						echo $jobseeker->from_date.' -- '.$jobseeker->to_date; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_JOB_PROFILE'); ?>:</label>
				</td>
				<td>
					<?php echo ($jobseeker->job_profile != "") ? $jobseeker->job_profile : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?>
				</td>
			</tr>
												
		    </table>
	</div>
	<div class="sp20">&nbsp;</div>
	
	<div class="border">
	<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_SKILLS'); ?></div>

		<table class="admintable">
		<tr>
			<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SKILLS_SUMMARY'); ?>:</label>
			</td>
			<td>
				<?php echo ($jobseeker->skill_summary != "") ? $jobseeker->skill_summary : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?>
			</td>
		</tr>
	    </table>
	</div>
	<div class="sp20">&nbsp;</div>
		
		<div class="border">
		<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_DESIRED_EMPLOYMENT'); ?></div>

			<table class="admintable">
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_PRIMARY_INDUSTRY'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->primary_industry; ?>
				</td>
			</tr>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_SECONDARY_INDUSTRY'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->secondary_industry; ?>
				</td>
			</tr>
				
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_POSITION_TYPE'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->position_type; ?>
				</td>
			</tr>
			
				<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_MINIMUM_SALARY'); ?>:</label>
				</td>
				<td nowrap="nowrap">
					<?php echo $jobseeker->min_salary; ?> - <?php echo $jobseeker->salary_type; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_IN_CURRENCY'); ?>:</label>
				</td>
				<td nowrap="nowrap">
					<?php echo $jobseeker->currency_salary; ?>
				</td>
			</tr>

		    </table>
	</div>
	<div class="sp20">&nbsp;</div>
		
		<div class="border">
		<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_PERSONAL_DETAILS'); ?></div>

			<table class="admintable">
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DATE_OF_BIRTH'); ?>:</label>
				</td>
				<td><?php echo ($jobseeker->personal_birthday != "0000-00-00") ? $jobseeker->personal_birthday : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_GENDER'); ?>:</label>
				</td>
				<td><?php echo JText::_(($jobseeker->personal_gender == 'M')?  'JBJOBS_MALE':  'JBJOBS_FEMALE' );?>
				</td>
			</tr>
				
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_STATUS'); ?>:</label>
				</td>
				<td>
					<?php echo ($jobseeker->personal_status != "0") ? $jobseeker->personal_status : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_NATIONALITY'); ?>:</label>
				</td>
				<td nowrap="nowrap">
					<?php echo ($jobseeker->personal_nationality != "") ? $jobseeker->personal_nationality : '<span class="redfont">'.JText::_('JBJOBS_NOT_MENTIONED').'</span>'; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name">	<?php echo JText::_('JBJOBS_PHOTO'); ?>:</label>
				</td>
				<td nowrap="nowrap">
				  <?php
					$switch = $model->whichUse($jobseeker->user_id);
					switch($switch)
					{
						case 1:
							$query = "SELECT avatar FROM #__comprofiler WHERE avatarapproved='1' AND user_id='$jobseeker->user_id'";
							$db->setQuery($query);
							$i = $db->loadResult();
							if($i)
							{
								$img = JPATH_SITE.DS.'images'.DS.'comprofiler'.DS.$i;
								$pimg = JURI::base().'images/comprofiler/'.$i.'?'.time();
							}
							else
							{
								$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$jobseeker->user_id.'.jpg';
								$pimg = JURI::base().'images/jbjobs/'.$jobseeker->user_id.'.jpg?'.time();
							}
						break;
						case 2:
							$query = "SELECT avatar FROM #__community_users WHERE userid='$jobseeker->user_id'";
							$db->setQuery($query);
							$i = $db->loadResult();
							if($i)
							{
								$img = JPATH_SITE.DS.$i;
								$pimg = JURI::base().$i.'?'.time();
							}
							else
							{
								$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$jobseeker->user_id.'.jpg';
								$pimg = JURI::base().'images/jbjobs/'.$jobseeker->user_id.'.jpg?'.time();
							}
						break;
						default:
							$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$jobseeker->jseekerid.'.jpg'; 
							$pimg = JURI::base().'images/jbjobs/'.$jobseeker->jseekerid.'.jpg?'.time();
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
		    </table>
	</div>
	<div class="sp20">&nbsp;</div>
		
		<div class="border">
		<div class="shade"><div class="arrow"></div><?php echo JText::_('JBJOBS_CONTACT_INFO'); ?></div>

			<table class="admintable">
			<?php 
				$user	=& JFactory::getUser();
				$uid 	= $user->id;
				//show the jobseeker contact info either he is referred by none or the referrer itself
				if($jobseeker->agent_name == "" or $jobseeker->id_job_agency == $uid){ ?>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ADDRESS'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->street_addr; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CITY'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->city; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_DISTRICT/STATE'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->district; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_ZIP'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->zip; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_COUNTRY'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->country; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_CONTACT_NO'); ?>:</label>
				</td>
				<td>
					<?php echo $jobseeker->contactno; ?>
				</td>
			</tr>
			
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_REFERRED_BY'); ?>:</label></td>
				<td>
					<b><?php echo ($jobseeker->agent_name == '') ? JText::_('JBJOBS_NONE') : $jobseeker->agent_name.' '.JText::_('JBJOBS_MY_REFERRAL'); ?>
						<input type="hidden" name="contactid" value="<?php echo $jobseeker->jseekerid; ?>" />
						<input type="hidden" name="send" value="newnoreferral" />
				 	</b>
				</td>
			</tr>
			<?php 
			$contactButton = JText::_('JBJOBS_CONTACT_JOBSEEKER');
			} 
			else {?>
			<tr>
				<td class="key"><label for="name"><?php echo JText::_('JBJOBS_REFERRED_BY'); ?>:</label></td>
				<td><b>
				<?php 
					$contactButton = JText::_('JBJOBS_CONTACT_JOB_AGENT');
					echo $jobseeker->agent_name; ?>
					<input type="hidden" name="contactid" value="<?php echo $jobseeker->companyid; ?>" />
					<input type="hidden" name="send" value="new" />
					<input type="hidden" name="candidatename" value="<?php echo $jobseeker->name; ?>" />
			
				 </b></td>
				
				<?php	}
				 ?>
			</tr>
			<tr>
				<?php $link_print = JRoute::_('index.php?option=com_jbjobs&view=employer&layout=detailjobseeker&id='.$jobseeker->jseekerid.'&tmpl=component&print=1'); ?>
				<td class="key" colspan="2" align="center" style="text-align:center">
					<input onclick="contact1()" type="button" name="contact" value="<?php echo $contactButton; ?>"  class="button" >
 					<input onclick="window.open('<?php echo $link_print; ?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480'); return false;" type="button" value="<?php echo JText::_('JBJOBS_PRINT'); ?>"  class="button" >
				</td>
			</tr>
		</table>
	</div>
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="view" value="messaging" />
	<input type="hidden" name="layout" value="message" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_('form.token'); ?>	
</form>
	<div class="sp20">&nbsp;</div>
	
	<script language="javascript" type="text/javascript">

		function contact1(){
			var form = document.regJobSeeker;
			form.action = "index.php?option=com_jbjobs&view=messaging&layout=message";
			form.submit();
		}
	</script>
			
	<?php $model->showCustomFieldValue($this->custom, $jobseeker->jseekerid);
	?>