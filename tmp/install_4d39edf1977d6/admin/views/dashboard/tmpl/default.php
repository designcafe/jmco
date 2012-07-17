<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
?>

 <div id="noticebox" style="border: 1px dotted #ccc; width: 40%; padding: 10px; float: right;">
	<p><h3><?php echo JText::_('') ?> </h3></p>
    <p><?php echo JText::_('NOTE_P1') ?>:</p>
    <ul>
        <li><?php echo JText::_('NOTE_P2') ?></li>
        <li><?php echo JText::_('NOTE_P3') ?></li>
    </ul>
    <p><?php echo JText::_('NOTE_P4') ?></p>
    <p><?php echo JText::_('NOTE_P5') ?></p><br />
    <p><?php echo JText::_('NOTE_P6') ?> <a href="http://bit.ly/kon-da" target="_new">Kon</a> &amp; <a href="http://bit.ly/ot-blog" target="_new">Oliver Twardowski</a></p>
</div>

<div style="float:left;clear:none;width:55%">
	<form action="index.php" method="post" name="adminForm">
    <div id="cpanel">
        <div style="float:left;">
			<div class="icon">
				<a href="index.php?option=com_jobboard&amp;view=jobs">
					<img src="components/com_jobboard/images/jobs.png" alt="Manage job postings"><span><?php echo JText::_('JOB_POSTINGS') ?></span></a>
			</div>
		</div>
        <div style="float:left;">
			<div class="icon">
				<a href="index.php?option=com_jobboard&amp;view=applicants">
					<img src="components/com_jobboard/images/applicants.png" alt="Manage job applications"><span><?php echo JText::_('JOB_APPLICANTS') ?></span></a>
			</div>
		</div>
        <div style="float:left;">
			<div class="icon">
				<a href="index.php?option=com_jobboard&amp;view=messages">
					<img src="components/com_jobboard/images/messages.png" alt="Customise email templates"><span><?php echo JText::_('EMAIL_TEMPLATES') ?></span></a>
			</div>
		</div>
        <div style="float:left;">
			<div class="icon">
				<a href="index.php?option=com_jobboard&amp;view=category">
					<img src="components/com_jobboard/images/categories.png" alt="Manage job categories"><span><?php echo JText::_('JOB_CATEGORIES') ?></span></a>
			</div>
		</div>
        <div style="float:left;">
			<div class="icon">
				<a href="index.php?option=com_jobboard&amp;view=careerlevels">
					<img src="components/com_jobboard/images/careers.png" alt="Manage career levels"><span><?php echo JText::_('CAREER_LEVELS') ?></span></a>
			</div>
		</div>
        <div style="float:left;">
			<div class="icon">
				<a href="index.php?option=com_jobboard&amp;view=education">
					<img src="components/com_jobboard/images/education.png" alt="Manage education levels"><span><?php echo JText::_('EDUCATION_LEVELS') ?></span></a>
			</div>
		</div>
        <div style="float:left;">
			<div class="icon">
				<a href="index.php?option=com_jobboard&amp;&view=departments">
					<img src="components/com_jobboard/images/departments.png" alt="Configure organisation departments"><span><?php echo JText::_('DEPARTMENTS') ?></span></a>
			</div>
		</div>
        <div style="float:left;">
			<div class="icon">
				<a href="index.php?option=com_jobboard&amp;&view=config">
					<img src="components/com_jobboard/images/settings.png" alt="Configure your job board"><span><?php echo JText::_('SETTINGS') ?></span></a>
			</div>
		</div>
       </div>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
	</form>
</div>