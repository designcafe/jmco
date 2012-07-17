<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/detailjob.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows details of job (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

$user =& JFactory::getUser();
$model = $this->getModel();	
$id 	= JRequest::getVar('id', 0, 'get', 'string');
$is_jobseeker = $model->isJobSeeker($user->id);
$job = $this->data;
$link_comp_job = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=searchbycomp&id='.$job->employer_id);

$config =& JTable::getInstance('config','Table');
$config->load(1);
$show_bookmark = $config->get('showbookmark');

	switch($model->whichUse($job->employer_id)){
		case 1:
			$link_detail_comp = JRoute::_('index.php?option=com_comprofiler&task=userProfile&user='.$job->employer_id);
		break;
		case 2:
			$link_detail_comp = JRoute::_('index.php?option=com_community&view=profile&userid='.$job->employer_id);
		break;
		default:
			$link_detail_comp = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailcomp&id='.$job->employer_id);
		break;
	}
	
	$link_regjseekernew = JRoute::_('index.php?option=com_jbjobs&view=jobseeker&layout=regjobseekernew');
	
	//return to same page after login
	$uri 	= JFactory::getURI();
	$url	= $uri->toString();
	$link_login  = 'index.php?option=com_user&view=login';
	$link_login .= '&return='.base64_encode($url);
	$encoded = urlencode($url);
	$jobtitle = urlencode($job->job_title);
	
	$db	=& JFactory::getDBO();
	?>
	<script language="javascript" type="text/javascript">
	<!--
		function apply(apply,choice) {			
			var form = document.userFormJob;			
				form.task.value = apply;
				form.isapply.value = choice;			
				form.submit();			
		}
	//-->
	</script>
	
	<div align="left" style="float:left">
		<h3><?php echo $job->job_title; ?> <img src="components/com_jbjobs/images/fj<?php echo $job->is_featured;?>.png" alt="" width="22"/></h3>
	</div>
	
	<div align="right" style="float:right">
	<?php $link_print = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$job->id.'&tmpl=component&print=1'); ?>
	<?php if($show_bookmark){ ?>
		<a target="_blank" rel="nofollow" href="<?php echo $link_print; ?>" title="Print" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480'); return false;" ><img src="components/com_jbjobs/images/bookmark/print.png" alt="Print"></a>
		<a target="_blank" rel="nofollow" href="index.php?option=com_mailto&tmpl=component&link=<?php echo base64_encode($url); ?>" title="E-mail" onclick="window.open(this.href,'win2','width=400,height=350,menubar=yes,resizable=yes'); return false;"><img src="components/com_jbjobs/images/bookmark/email_link.png" alt="E-mail"></a>
		<a target="_blank" rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo $encoded; ?>&amp;t=<?php echo $jobtitle; ?>"><img title="Facebook" border="0" src="components/com_jbjobs/images/bookmark/facebook.png" alt="Facebook" /></a>
		<a target="_blank" rel="nofollow" href="http://www.myspace.com/Modules/PostTo/Pages/?l=3&amp;u=<?php echo $encoded; ?>&amp;title=<?php echo $jobtitle; ?>"><img title="MySpace" border="0" src="components/com_jbjobs/images/bookmark/myspace.png" alt="MySpace" /></a>
		<a target="_blank" rel="nofollow" href="http://twitter.com/home?status=<?php echo $encoded; ?>&amp;title=<?php echo $jobtitle; ?>"><img title="Twitter" border="0" src="components/com_jbjobs/images/bookmark/twitter.png" alt="Twitter" /></a>
		<a target="_blank" rel="nofollow" href="http://digg.com/submit?phase=2&amp;url=<?php echo $encoded; ?>&amp;title=<?php echo $jobtitle; ?>"><img title="Digg" border="0" src="components/com_jbjobs/images/bookmark/digg.png" alt="Digg" /></a>
		<a target="_blank" rel="nofollow" href="http://del.icio.us/post?url=<?php echo $encoded; ?>&amp;title=<?php echo $jobtitle; ?>"><img title="Delicious" border="0" src="components/com_jbjobs/images/bookmark/delicious.png" alt="Delicious" /></a>
		<a target="_blank" rel="nofollow" href="http://www.stumbleupon.com/submit?url=<?php echo $encoded; ?>&amp;title=<?php echo $jobtitle; ?>"><img title="Stumbleupon" border="0" src="components/com_jbjobs/images/bookmark/stumbleupon.png" alt="Stumbleupon" /></a>
		<a target="_blank" rel="nofollow" href="http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=<?php echo $encoded; ?>&amp;title=<?php echo $jobtitle; ?>"><img title="Google Bookmarks" border="0" src="components/com_jbjobs/images/bookmark/google.png" alt="Google Bookmarks" /></a>
		<a target="_blank" rel="nofollow" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $encoded; ?>&amp;title=<?php echo $jobtitle; ?>"><img title="Linked in" border="0" src="components/com_jbjobs/images/bookmark/linkedin.png" alt="Linked in" /></a>
	<?php 
	}
	?>
    </div><div style="clear:both;"></div>
	
	<div class="border">	
	<form action="index.php" method="post" name="userFormJob" enctype="multipart/form-data">
		
	<table width="100%" cellpadding="0" cellspacing="0" >
	
		<tr class="jbj_row1">

			<td align="right" >
				<strong><?php echo JText::_('JBJOBS_JOBID'); ?></strong>&nbsp;:&nbsp;<?php echo $job->id; ?> - 
				<strong><?php echo JText::_('JBJOBS_ADVERTISED'); ?> </strong>: <?php echo JHTML::_('date',$job->publish_date, '%Y-%m-%d', false); ?> - 
				<strong><?php echo JText::_('JBJOBS_CLOSING_DATE'); ?></strong>: <?php echo JHTML::_('date',$job->expire_date, '%Y-%m-%d', false); ?>
			</td>
			<td align="right" valign="bottom" style="text-align:right;">
				<?php 
					if($user->guest){ ?>
						<input type="button" Onclick="location.href='<?php echo $link_regjseekernew; ?>';" value="<?php echo JText::_('JBJOBS_REGISTER'); ?>"  class="button"/> or 
						<input type="button" Onclick="location.href='<?php echo JRoute::_($link_login); ?>';" value="<?php echo JText::_('JBJOBS_LOGIN'); ?>" class="button"/> to apply
				<?php	}
				?>
				<?php if($is_jobseeker == 1){
						$query = "select count(*) from #__jbjobs_save_job".
			        		 " where is_apply ='y' and id_job = ".$job->id.				 
					 		 " and jseeker_id =".$user->id;
						$db->setQuery( $query );
						$cek_apply = $db->loadResult();	
	
						$query = "select count(*) from #__jbjobs_save_job".
			        		 " where is_view ='y' and id_job = ".$job->id.				 
					 		 " and jseeker_id =".$user->id;
						$db->setQuery( $query );
						$cek_view = $db->loadResult();	
				
						if($cek_view == 0){
						?>
							<input type="button" Onclick="javascript:apply('applyJobByJS','false')" value="<?php echo JText::_('JBJOBS_SAVE_JOB'); ?>"  class="button"/>&nbsp; 
						<?php
						}
						else{
							echo "<b>".JText::_('JBJOBS_ALREADY_SAVED')."</b>"; 
						}
						if($cek_apply == 0){
						?>
							<input type="button" Onclick="javascript:apply('applyJobByJS','true')" value="<?php echo JText::_('JBJOBS_APPLY_JOB'); ?>" class="button" />
						<?php 
						}else{
							echo " & <b>".JText::_('JBJOBS_ALREADY_APPLIED')."</b>"; 
						}
				
				 } ?>
			</td>
		</tr>
	</table>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="isapply" value="" />
	<input type="hidden" name="id_job" value="<?php echo $job->id; ?>" />
	<input type="hidden" name="return" value="detailjob" />
	</form>
	
	<table width="100%">
		<tr class="jbj_row0">
			<td align="right" width="15%" nowrap="nowrap" valign="top">				
				
				 <b><?php echo JText::_('JBJOBS_COMPANY_NAME'); ?> :</b>
			</td>
			<td align="left" width="45%"valign="top">
				<?php 
					switch($model->whichUse($job->employer_id))
					{
						case 1:
							$link_company = JRoute::_('index.php?option=com_comprofiler&task=userProfile&user='.$job->employer_id);
						break;
						case 2:
							$link_company = JRoute::_('index.php?option=com_community&view=profile&userid='.$job->employer_id);
						break;
						default:
							$link_company = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailcomp&id='.$job->employer_id);
						break;
					}

			    ?>
				<a href="<?php echo $link_company; ?>"><?php echo $job->comp_name; ?></a>
				<br />
				<?php
						$switch = $model->whichUse($job->employer_id);
						switch($switch)
						{
							case 1:
								$query = "SELECT avatar FROM #__comprofiler WHERE avatarapproved='1' AND user_id='$job->employer_id'";
								$db->setQuery($query);
								$i = $db->loadResult();
								if($i)
								{
									$img = JPATH_SITE.DS.'images'.DS.'comprofiler'.DS.$i;
									$pimg = JURI::base().'images/comprofiler/'.$i.'?'.time();
								}
								else
								{
									$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$job->employer_id.'.jpg';
									$pimg = JURI::base().'images/jbjobs/'.$job->employer_id.'.jpg?'.time();
								}
							break;
							case 2:
								$query = "SELECT avatar FROM #__community_users WHERE userid='$job->employer_id'";
								$db->setQuery($query);
								$i = $db->loadResult();
								if($i)
								{
									$img = JPATH_SITE.DS.$i;
									$pimg = JURI::base().$i.'?'.time();
								}
								else
								{
									$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$job->employer_id.'.jpg';
									$pimg = JURI::base().'images/jbjobs/'.$job->employer_id.'.jpg?'.time();
								}
							break;
							default:
								$img = JPATH_SITE.DS.'images'.DS.'jbjobs'.DS.$job->employer_id.'.jpg';
								$pimg = JURI::base().'images/jbjobs/'.$job->employer_id.'.jpg?'.time();
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
			<td width="5%" valign="top">&nbsp;</td>
			<td width="15%" valign="top" nowrap="nowrap"><b><?php echo JText::_('JBJOBS_APROXIMATE_SALARY'); ?>:</b></td>
			<?php if($job->salary == 0){ ?>
				<td width="20%" align="left" valign="top"><i>Negotiable</i></td>
			<?php }else{ ?>
			<td width="20%" align="left" valign="top"><?php echo $job->currency_salary; ?> &nbsp;<?php echo number_format($job->salary,2,'.',','); ?>&nbsp;/ <?php echo $job->type_salary; ?> </td>
			<?php } ?>
		</tr>
		
		<tr class="jbj_row1">
			<td align="right" nowrap="nowrap" valign="top">
				 <b><?php echo JText::_('JBJOBS_LOCATION'); ?> :</b>
			</td>
			<td align="left" valign="top">
				<?php echo $job->city; ?>,<?php echo $job->state; ?>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top" align="right">
			<b><?php echo JText::_('JBJOBS_COUNTRY'); ?> :</b>
			</td>
			<td align="left" valign="top">	
			<?php echo $job->country; ?> 
			</td>
		</tr>
		
		<tr class="jbj_row0">
			<td align="right" nowrap="nowrap" valign="top">
				 <b><?php echo JText::_('JBJOBS_INDUSTRY'); ?> :</b>
			</td>
			<td align="left" valign="top">
				<?php echo $job->industry; ?>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top" align="right">
			<b><?php echo JText::_('JBJOBS_POSITION_TYPE'); ?> :</b>
			</td>
			<td align="left" valign="top">	
			<?php echo $job->pos_type; ?> 
			</td>
		</tr>
		
		<tr class="jbj_row1">
			<td align="right" nowrap="nowrap" valign="top">
				<b><?php echo JText::_('JBJOBS_EXPERIENCE_LEVEL'); ?> :</b>
			</td>
			<td align="left" width="20%" valign="top">
				<?php echo $job->exp_name; ?>
			</td>
			<td valign="top">&nbsp;</td>
			<td valign="top" align="right">
			<b><?php echo JText::_('JBJOBS_EDUCATION_LEVEL'); ?> :</b>
			</td>
			<td align="left" valign="top">	
			<?php echo $job->degree_level; ?> 
			</td>
		</tr>
		<tr class="jbj_row0">
			<td colspan="5"><?php echo JText::sprintf('JBJOBS_MORE_JOBS_BY_EMPLOYER', $link_comp_job); ?></td>
		</tr>
	</table>
	</div>
	<br />

	<table width="100%" >
		<tr>
			<td>
				<div class="shortdesc">
					<?php echo $job->short_desc; ?>
				</div>
			</td>
		</tr>

		<tr>
			<td>
				<?php echo $job->long_desc; ?>
			</td>
		</tr>
	</table>

	<?php $model->showCustomFieldValue($this->custom, $job->id, 'jobs'); ?>
