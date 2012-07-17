<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/simplesearch.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Search for jobs (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

$user =& JFactory::getUser();
$model = $this->getModel();
$post   	  = JRequest::get('post');
$id_job_spec  = (!empty($post['id_job_spec'])) ?(int) $post['id_job_spec'] : (int) JRequest::getVar('id_job_spec', 0, 'get', 'string');
$id_country   = (!empty($post['id_country'])) ?(int) $post['id_country'] :(int) JRequest::getVar('id_country', 0, 'get', 'string');
$keyword  	  = (!empty($post['keyword'])) ? $post['keyword'] : JRequest::getVar('keyword','', 'get', 'string');
$city  	  	  = (!empty($post['city'])) ? $post['city'] : JRequest::getVar('city', '', 'get', 'string');

$action	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=simplesearch');
?>

<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">
	<div class="border">
		<table width="100%">
			<tr>
				<td width="40%"><strong><?php echo JText::_('JBJOBS_ENTER_KEYWORD'); ?></strong></td>
				<td width="60%"><strong><?php echo JText::_('JBJOBS_JOB_SPECIALIZATION'); ?></strong></td>
			</tr>
			<tr>
				<td><input type="text" name="keyword" id="keyword" size="20" class="inputbox tooltip" title="<?php echo JText::_('JBJOBS_TT_SEARCH_KEYWORD'); ?>" value="<?php echo $keyword; ?>" /> <em><?php //echo JText::_('JBJOBS_KEYWORD_JOB_TITLE'); ?></em></td>
				<td><?php $list_job_spec = $model->getSelectJobSpec('id_job_spec', $id_job_spec, '');
					 echo $list_job_spec;?>
				</td>
			</tr>
			<tr>
				<td><strong><?php echo JText::_('JBJOBS_CITY'); ?></strong></td>
				<td><strong><?php echo JText::_('JBJOBS_LOCATION'); ?></strong></td>
			</tr>
			<tr>
				<td><input type="text" name="city" id="city" size="20" class="inputbox" value="<?php echo $city; ?>" /></td>
				<td><?php $list_country = $model->getSelectCountry('id_country', $id_country, '');	   					   		
					 echo $list_country; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="<?php echo JText::_('JBJOBS_SEARCH'); ?>" class="button" /><br />
			<?php
				$link_adv_search	=  JRoute::_('index.php?option=com_jbjobs&view=guest&layout=advsearch'); 
			?>
				<small><a href="<?php echo $link_adv_search; ?>"><?php echo JText::_('JBJOBS_ADVANCED_JOB_SEARCH'); ?></a></small>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_SEARCH_RESULTS'); ?></b></div>
		<img src="components/com_jbjobs/images/fj1.png" class="featured" alt="" width="22" vspace="10"> = <?php echo JText::_('JBJOBS_FEATURED_JOBS'); ?>
	<div class="border">
		<table width="100%" cellpadding="0" cellspacing="0">
		<?php
		$k = 0;
		if(count($this->rows)){
		?>
		<thead>
			<tr class="jbj_rowhead">
				<th width="10">
					<?php echo JText::_('#'); ?>
				</th>
				<th width="15%" align="left">
					<?php echo JText::_('JBJOBS_DATE'); ?>
				</th>
				<th width="1%">&nbsp;</th>
				<th width="35%" align="left">
					<?php echo JText::_('JBJOBS_JOB_TITLE'); ?>
				</th>
				<th width="25%" align="left">
					<?php echo JText::_('JBJOBS_LOCATION'); ?>
				</th>
				<th width="25%">
					<?php echo JText::_('JBJOBS_COMPANY_NAME'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6" class="jbj_row3">
					<?php echo $this->pageNav->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php
			for ($i=0, $n=count($this->rows); $i < $n; $i++) {
				$row = $this->rows[$i];
				$link_detail	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='.$row->id );
				$link_comp = JRoute::_('index.php?option=com_jbjobs&view=guest&layout=searchbycomp&id='.$row->employer_id);
				?>
				<tr class="jbj_<?php echo "row$k"; ?>">
					<td>
						<?php echo $this->pageNav->getRowOffset( $i ); ?>
					</td>
					<td>
						<?php echo JHTML::_('date', $row->publish_date, '%Y-%m-%d', false, false); ?>
					</td>
					<td>
						<img src="components/com_jbjobs/images/fj<?php echo $row->is_featured;?>.png" alt="" width="16">
					</td>
					<td>
						<a href="<?php echo $link_detail; ?>"><?php echo $row->job_title; ?></a>					
					</td>
					<td>
						<?php echo $row->state; ?> , <?php echo $row->country; ?>
					</td>
					<td>
						<a href="<?php echo $link_comp; ?>"><?php echo $row->comp_name; ?></a>
					</td>				
				</tr>
				<?php
				$k = 1 - $k;
			}
			}
			else
			{
			?>
			<tr>
				<td colspan="6"><?php echo JText::_('JBJOBS_SORRY_SEARCH_RETURNED_NO_RESULT'); ?></td>
			</tr>
			<?php
			}
			?>
		</tbody>
		</table>
	</div>
	<input type="hidden" name="option" value="com_jbjobs">
	<input type="hidden" name="task" value="">
	
</form>