<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
?>

<?php $document =& JFactory::getDocument(); ?>
<?php $daterange = $this->daterange; ?>
<?php $selcat = $this->selcat; ?>

<?php $seldesc = ''; ?>
<?php $link = 'index.php?option=com_jobboard&view=list'; ?>
  <form id="category_list" name="category_list" method="post" action="<?php echo JRoute::_($link); ?>">
          <?php $all_jobs = 'index.php?option=com_jobboard&view=list&catid=1&daterange=&search=&keysrch=&locsrch='; ?>
          <?php $link = 'index.php?option=com_jobboard&view=list'; ?>
               <div align="center" style="width:auto">
                <div valign="top" style="padding-bottom:5px;margin-left:19px" align="left"><select name="catid" onchange="this.form.submit()" class="inputbox">
                    <?php foreach($this->categories as $cat) : ?>
                      <option class="catitem" value="<?php echo $cat->id; ?>" <?php if($cat->id == $this->selcat) {$selcat = $cat->id; $seldesc = $cat->type; echo ' selected="selected"';}?>>
                          <?php echo $cat->type;?>
                      </option>
                    <?php endforeach; ?>
                    <!-- add the header links -->
                    <?php $document->setTitle(JText::_('JOBS IN').': '.$seldesc); ?>
                    <?php $document->setMetaData('keywords', JText::_('JOBLISTMETAKEY').', '.$seldesc); ?>
                    <?php $document->setMetaData('description', JText::_('JOBLISTMETADESC').': '.$seldesc); ?>
                  </select><label for="daterange" id="drcapt"><small><?php echo JText::_('POSTED FROM') ?></small></label>
                  <select id="daterange" name="daterange" onchange="this.form.submit()" class="inputbox">
                      <option class="catitem" value="0" <?php if($daterange == 0) echo ' selected="selected"';?>>
                          <?php echo JText::_('ALL_POST_DATES');?>
                      </option>
                      <option class="catitem" value="1" <?php if($daterange == 1) echo ' selected="selected"';?>>
                          <?php echo JText::_('TODAY');?>
                      </option>
                      <option class="catitem" value="2" <?php if($daterange == 2) echo ' selected="selected"';?>>
                          <?php echo JText::_('YESTERDAY');?>
                      </option>
                      <option class="catitem" value="3" <?php if($daterange == 3) echo ' selected="selected"';?>>
                          <?php echo JText::_('LAST_3_DAYS');?>
                      </option>
                      <option class="catitem" value="7" <?php if($daterange == 7) echo ' selected="selected"';?>>
                          <?php echo JText::_('LAST_7_DAYS');?>
                      </option>
                      <option class="catitem" value="14" <?php if($daterange == 14) echo ' selected="selected"';?>>
                          <?php echo JText::_('LAST_14_DAYS');?>
                      </option>
                      <option class="catitem" value="30" <?php if($daterange == 30) echo ' selected="selected"';?>>
                          <?php echo JText::_('LAST_30_DAYS');?>
                      </option>
                      <option class="catitem" value="60" <?php if($daterange == 60) echo ' selected="selected"';?>>
                          <?php echo JText::_('LAST_60_DAYS');?>
                      </option>
                  </select>
                  <?php if($this->config->allow_unsolicited) : ?>
                    <?php $unsolicited_link = 'index.php?option=com_jobboard&view=unsolicited&catid='.$selcat; ?>
                    <a id="unsolLink" href="<?php echo JRoute::_($unsolicited_link); ?>"><button class="button" id="topSubmitCV" ><?php echo JText::_('SUBMIT_CV_RESUME');?></button></a>
                  <?php endif; ?>
                  </div><br style="clear:both" />
        		<div align="center">
        				<div class="filterset"><label for="search"><small><?php echo JText::_('JOB TITLE');?>&nbsp;</small></label><br /> <input class="inputbox" type="text" name="search" value="<?php echo $this->search ?>" id="search" /></div>
        				<div class="filterset"><label for="keysrch"><small><?php echo JText::_('SKILLS/KEYWORDS');?>&nbsp;</small></label><br /> <input class="inputbox" type="text" name="keysrch" value="<?php echo $this->keysrch ?>" id="keysrch" /></div>
        				<div class="filterset"><label for="locsrch"><small><?php echo JText::_('LOCATION');?>&nbsp;</small></label><br /> <input class="inputbox" type="text" name="locsrch" value="<?php echo $this->locsrch ?>" id="locsrch" /></div>
        				<div class="filterset"><input style="margin-top:8px" class="button" class="filterSub" type="submit" value="<?php echo JText::_('SHOW JOBS');?>" /></div>
        			</div>
                    <div valign="bottom" align="center">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><a href="<?php echo JRoute::_($all_jobs); ?>" class="JobLink" target="_top"><strong><?php echo JText::_('VIEW ALL JOBS'); ?></strong></a></small>
                    </div>
             </div>
  <input type="hidden" name="layout" value="<?php echo $this->layout; ?>" />
  <?php echo JHTML::_('form.token'); ?>
 </form>
 <?php echo $this->setstate; ?>