<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	11 November 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/guest/tmpl/searchbycomp.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Shows jobs posted by companies (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');

$user = & JFactory::getUser();	
$id   = (int)JRequest::getVar('id', 0, 'get', 'string');	
$post   = JRequest::get('post');
if($id == 0)
	$id= $post['id'];

$action	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=searchbycomp&id='.$id);
?>

<div class="fsl_h3title"><b><?php echo JText::_('JBJOBS_LIST_OF_JOBS'); ?></b></div>

<span class="jbj_jobtitle"><?php echo JText::_('JBJOBS_COMPANY_NAME'); ?> : <b><?php echo $this->compname; ?></b></span>
<div class="sp10">&nbsp;</div>
<form action="<?php echo $action; ?>" method="post" name="userFormJob" enctype="multipart/form-data">	
	<table width="100%" cellpadding="0" cellspacing="0">
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
			
			<th  width="25%" align="left">
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
		<tr>
			<td colspan="6" class="jbj_row3">
				<a href="<?php echo JRoute::_('index.php?option=com_jbjobs&task=jbjobsrss&type=company&id='.$id); ?>"><img src="<?php echo JURI::root(); ?>components/com_jbjobs/images/rss.png" alt="RSS"></a>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count($this->rows); $i < $n; $i++) {
		$row = $this->rows[$i];
		$link_detail	= JRoute::_('index.php?option=com_jbjobs&view=guest&layout=detailjob&id='. $row->id );
		?>
		<tr class="jbj_<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pageNav->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo JHTML::_('date', $row->publish_date, '%Y-%m-%d', false); ?>
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
				<?php echo $row->comp_name; ?>
			</td>				
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	</table>
</form>