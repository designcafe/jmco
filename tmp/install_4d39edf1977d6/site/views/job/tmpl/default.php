<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
?>
<?php $layout = JRequest::getVar('lyt', ''); ?>
<?php $this->catid = (!is_int($this->catid) || $this->catid <1)? 1 : $this->catid; ?>
<?php $applink = 'index.php?option=com_jobboard&view=apply&job_id='.$this->id.'&catid='.$this->catid.'&lyt='.$layout; ?>
<?php $back = 'index.php?option=com_jobboard&view=list&catid='.$this->catid.'&layout='.$layout; ?>
<?php $share = 'index.php?option=com_jobboard&view=share&job_id='.$this->id.'&catid='.$this->catid.'&lyt='.$layout; ?>

<?php $registry =& JFactory::getConfig(); ?>
<?php $sitename = $registry->getValue( 'config.sitename' ); ?>

<?php $uri = JRoute::_('http://' . urlencode($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']));    ?>

<?php $job_opng = JText::_('JOB_OPENING').': '; ?>
<?php $title_prefix = urlencode($job_opng);    ?>
<?php $LinkedIn_long = 'http://www.linkedin.com/shareArticle?mini=true&url='.$uri.'&title='.$title_prefix.$this->data->job_title.'&source='.$sitename; ?>
<?php $Twitter_long = 'http://twitter.com/home?status='.$title_prefix.$this->data->job_title.' - '.$uri; ?>
<?php $FB_long = 'http://www.facebook.com/sharer.php?u='.$uri.'&t='.$title_prefix.$this->data->job_title.'&src='.$sitename; ?>

<?php if(strlen($this->data->description) > 250) : ?>
<?php $article_summary = substr($this->data->description, 0, 250) . '...'; ?>
<?php else : $article_summary = '';  ?>
<?php endif; ?>
<?php $return = JText::_("RETURN_TO_LIST"); ?>
<div id="jobcont">
 <?php if($this->config->show_job_summary == 1) :?>
  <div id="jobsumm">
     <small>
       <h3><?php echo JText::_('JOB_SUMMARY'); ?></h3>
       <div class="jsrow">
          <?php echo '<span class="summtitle">'.JText::_('LOCATION').':</span><br />'.$this->data->city.', '.$this->data->country_name.', '.$this->data->country_region; ?>
       </div>
       <div class="jsrow">
          <?php echo '<span class="summtitle">'.JText::_('CAREER_LEVEL').':</span><br />'.$this->data->job_level; ?>
       </div>
       <div class="jsrow">
          <?php echo '<span class="summtitle">'.JText::_('EDUCATION').':</span><br />'.$this->data->education; ?>
       </div>
       <div class="jsrow">
          <?php echo '<span class="summtitle">'.JText::_('JOB_TYPE').':</span><br />'.JText::_($this->data->job_type); ?>
       </div>
       <div class="jsrow">
          <?php echo '<span class="summtitle">'.JText::_('POSITIONS').':</span><br />'.$this->data->positions; ?>
       </div>
       <div class="jsrow">
          <?php $this_salary = (strlen($this->data->salary) < 1)? JText::_('NEGOTIABLE') : $this->data->salary; ?>
          <?php echo '<span class="summtitle">'.JText::_('SALARY').':</span><br /><b>'.$this_salary.'</b>'; ?>
       </div>
       <?php if($this->data->expiry_date <> "0000-00-00 00:00:00"):?>
	       <div class="jsrow">
	       	  <?php $exp_date = new JDate($this->data->expiry_date); ?>
	          <?php echo '<span class="summtitle">'.JText::_('APPLY_BEFORE').':</span><br /><b>'.$exp_date->toFormat("%B %d, %Y").'</b>'; ?>
	       </div>
       <?php endif; ?>
       <div align="center" style="padding: 5px; margin-top: 5px">
       	<?php if($this->config->allow_applications == 1) :?>
          <a href="<?php echo JRoute::_($applink); ?>"> <div class="button applbut">&nbsp;&nbsp;<?php echo JText::_('APPLY_NOW'); ?>&nbsp;&nbsp;</div></a>
        <?php endif; ?>
        <?php if($this->config->send_tofriend == 1) :?>
          <a href="<?php echo JRoute::_($share); ?>">
            <div class="button applbut"><?php echo JText::_('EMAIL_TO_A_FRIEND'); ?></div>
         </a>
        <?php endif; ?>
         <br />
          <small><a href="<?php echo JRoute::_($back) ?>"><b>&#171;&nbsp;</b><?php echo $return; ?></a></small>
       </div>
     </small>
  </div>
  <?php endif; ?>
  <div <?php if($this->config->show_job_summary == 1) echo 'id="jobdet"'; ?>>
    <h3><?php echo $this->data->job_title; ?></h3>
    <div style="width: 100%">
    <?php if($this->config->show_viewcount == 1 || $this->config->show_applcount == 1) :?>
      <div id="hitsumm">
        <small>
        	<?php if($this->config->show_applcount == 1) :?>
	            <?php if($this->data->num_applications == 1) : ?>
	              <?php echo '<b>*</b> '.JText::_('THERE_HAS_BEEN'). ' <span class="hit">'. $this->data->num_applications . '</span>  '. JText::_('APPLICATION_FOR_THIS_POSITION'); ?>
	            <?php else : ?>
	              <?php echo '<b>*</b> '.JText::_('THERE_HAVE_BEEN'). ' <span class="hit">'. $this->data->num_applications . '</span>  '. JText::_('APPLICATIONS_FOR_THIS_POSITION'); ?>
	            <?php endif; ?>
            	<br />
            <?php endif; ?>
            <?php if($this->config->show_viewcount == 1) :?>
            	<?php echo '<b>*</b> '.JText::_('THIS_JOB_OPENING_HAS_BEEN_VIEWED'). ' <span class="hit">'. $this->data->hits . '</span>  '. JText::_('TIMES'); ?>
            <?php endif; ?>
        </small>
        <small id="hsback"><a href="<?php echo JRoute::_($back) ?>"><b>&#171;&nbsp;</b><?php echo $return; ?></a></small>
      </div>      
    <?php endif; ?>
      <div style="padding-top: 10px; clear: both; padding-bottom: 15px">
      <?php echo '<b>'.JText::_('ABOUT_THIS_JOB').'</b>'; ?>
      </div>
      <?php echo $this->data->description; ?> <br />
      <?php if(($job_duties = $this->data->duties) <> '' ) : ?>
        <?php echo '<br /><b>'.JText::_('THIS_JOB_DUTIES').'</b>'; ?> <br />
        <?php echo $job_duties; ?> <br />
      <?php endif; ?>
      <div align="center" id="divbottom">
      	<?php if($this->config->allow_applications == 1) :?>
         <a href="<?php echo JRoute::_($applink); ?>">
            <div class="button applbut" style="width: 20%">&nbsp;&nbsp;<?php echo JText::_('APPLY_NOW'); ?>&nbsp;&nbsp;</div>
         </a>&nbsp;&nbsp;&nbsp;&nbsp;
         <?php endif; ?>
         <?php if($this->config->show_job_summary == 0 && $this->config->send_tofriend == 1) : ?>
         	<a href="<?php echo JRoute::_($share); ?>"><small><?php echo JText::_('EMAIL_TO_A_FRIEND'); ?></small></a>&nbsp;&nbsp;
         <?php endif; ?>
         <small><a href="<?php echo JRoute::_($back) ?>"><b>&#171;&nbsp;</b><?php echo $return; ?></a></small>
         <?php if($this->config->show_social == 1) :?>
            <a target="_blank" href="<?php echo $LinkedIn_long; ?>" title="<?php echo JText::_('LINKEDIN_SHARE') ?>"><div id="linkedin">&nbsp;</div></a>
            <a target="_blank" href="<?php echo $Twitter_long; ?>" title="<?php echo JText::_('TWITTER_SHARE') ?>"><div id="twitter">&nbsp;</div></a>
            <a target="_blank" href="<?php echo $FB_long; ?>" title="<?php echo JText::_('FACEBOOK_SHARE') ?>"><div id="facebook">&nbsp;</div></a>
         <?php endif; ?>
      </div>
    </div>
  </div>
</div>
 <?php echo $this->setstate; ?>