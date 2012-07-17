<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
$app=JFactory::getApplication();
?>

<?php $sortlink = JFilterOutput::ampReplace('index.php?option=com_jobboard&view=list&Itemid='.JRequest::getVar('Itemid','')); ?>
<?php $document =& JFactory::getDocument(); ?>

<!--sort order-->
<?php $sort = $app->getUserStateFromRequest('jb_list.sort','sort','d'); ?>
<?php $order = $app->getUserStateFromRequest('jb_list.order','order','date'); ?>
<?php $sortlink = ($sort=='a')? $sortlink.'&sort=d' : $sortlink.'&sort=a'; ?>
<?php if($sort=='a') : ?>
	<?php $sortimage = 'sup';  ?>
<?php else :  ?>
	<?php $sortimage = 'sdown';  ?>
<?php endif;  ?>

<?php $daterange = $this->daterange; ?>

<!--Pagination-->
<?php $pagination =& $this->get('Pagination'); ?>
<?php $this->assignRef('pagination', $pagination); ?>

<!--display page title if configured-->
<?php $params =& $app->getParams('com_content'); ?>
<?php $this->assignRef('params' , $params); ?><?php $selcat = $this->selcat; ?>
<?php $link = 'index.php?option=com_jobboard&view=list'; ?>
<?php $seldesc = ''; ?>
<!-- feed prefix (SEF dependent) -->
<?php $feedPrefix =  ($app->getCfg( 'sef' ) == 1)? '?': '&' ?>

  <form id="category_list" name="category_list" method="post" action="<?php echo JRoute::_($link); ?>">
          <?php $all_jobs = 'index.php?option=com_jobboard&view=list&catid=1&daterange=&jobsearch=&keysrch=&locsrch='; ?>
                <div id="listWrapper" align="left">
                <select name="catid" id="fcats" onchange="this.form.submit()" class="inputfield ">
                    <?php foreach($this->categories as $cat) : ?>
                      <option class="catitem" value="<?php echo $cat->id; ?>" <?php if($cat->id == $this->selcat) {$selcat = $cat->id; $seldesc = $cat->type; echo ' selected="selected"';}?>>
                          <?php echo $cat->type;?>
                      </option>
                    <?php endforeach; ?>
                    <?php  $feed_title = $seldesc.' '.JText::_('FEED'); ?>
                    <?php  $rss = array('type' => 'application/rss+xml', 'title' => $feed_title.' (RSS)' ); ?>
                    <?php  $atom = array('type' => 'application/atom+xml', 'title' => $feed_title. ' (Atom)' ); ?>
                    <?php $all_cat_feedlink = 'index.php?option=com_jobboard&view=list&catid=1'; ?>
                    <?php $feedlink = 'index.php?option=com_jobboard&view=list&catid='.$selcat; ?>
                    <!-- add the header links -->
                    <?php $document->addHeadLink(JRoute::_($feedlink.'&type=rss').$feedPrefix.'format=feed', 'alternate', 'rel', $rss); $document->addHeadLink(JRoute::_($feedlink.'&type=atom').$feedPrefix.'format=feed', 'alternate', 'rel', $atom); ?> 
                    <?php $document->setTitle(JText::_('JOBS_IN').': '.$seldesc); ?>
                    <?php $document->setMetaData('keywords', JText::_('JOBLISTMETAKEY').', '.$seldesc); ?>
                    <?php $document->setMetaData('description', JText::_('JOBLISTMETADESC').': '.$seldesc); ?>
                  </select><label for="daterange" id="drcapt"><small><?php echo JText::_('JOBS_FROM') ?></small></label>
                  <select id="daterange" name="daterange" onchange="this.form.submit()" class="inputfield ">
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
        				<div class="filterset"><label for="jobsearch"><small><?php echo JText::_('JOB_TITLE');?>&nbsp;</small></label><br /> <input class="inputfield " type="text" name="jobsearch" value="<?php echo $this->jobsearch ?>" id="jobsearch" /></div>
        				<div class="filterset"><label for="keysrch"><small><?php echo JText::_('SKILLS_KNOWLEDGE_ETC');?>&nbsp;</small></label><br /> <input class="inputfield " type="text" name="keysrch" value="<?php echo $this->keysrch ?>" id="keysrch" /></div>
        				<div class="filterset"><label for="locsrch"><small><?php echo JText::_('LOCATION');?>&nbsp;</small></label><br /> <input class="inputfield " type="text" name="locsrch" value="<?php echo $this->locsrch ?>" id="locsrch" /></div>
        				<div class="filterset"><input class="button filterSub" type="submit" id="filtrsubmt" value="<?php echo JText::_('SHOW_JOBS');?>" /><span id="loadr" class="hidel"></span></div>
        			</div>
                    <?php if ($selcat <> 1) : ?>
                      <div align="center">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><a id="jall" href="<?php echo JRoute::_($all_jobs); ?>" class="JobLink" target="_top"><strong><?php echo JText::_('VIEW_ALL_JOBS'); ?></strong></a></small>
                      </div>
                    <?php endif; ?>

  <?php $count = count($this->data); ?>

  <div id="jobtable">
     <?php $list_view_link = 'index.php?option=com_jobboard&view=list&catid='.$selcat.'&layout=list'; ?>
    <div class="pagination" align="right" ><?php echo $this->pagination->getResultsCounter();?>&nbsp;&nbsp;<a title="Table view (current)" class="tableView"></a><a href="<?php echo JRoute::_($list_view_link) ?>" title="List view" id="listView" class="listView"></a></div><br style="clear:both" />
    <table width="100%" cellspacing="0" cellpadding="5" align="center" class="text">
      <tbody>
        <tr valign="top" class="headbg">
          <?php $date_sort = $sortlink.'&order=date' ?>

          <td height="18" align="left" class="jtitle"><a <?php if($order=='date') echo 'class="'.$sortimage.'"';?> href=
          "<?php echo JRoute::_($date_sort); ?>" target="_top"><?php echo JText::_('POSTED_ON') ?></a></td><?php $title_sort = $sortlink.'&order=title' ?>

          <td align="left" class="jtitle"><a <?php if($order=='title') echo 'class="'.$sortimage.'"';?> href="<?php echo JRoute::_($title_sort); ?>" target=
          "_top"><?php echo JText::_('TITLE'); ?></a></td><?php $level_sort = $sortlink.'&order=level' ?>

          <td align="left" class="jtitle"><a <?php if($order=='level') echo 'class="'.$sortimage.'"';?> href="<?php echo JRoute::_($level_sort); ?>" target=
          "_top"><?php echo JText::_('CAREER_LEVEL'); ?></a></td><?php $city_sort = $sortlink.'&order=city' ?>

          <td align="left" class="jtitle"><a <?php if($order=='city') echo 'class="'.$sortimage.'"';?> href="<?php echo JRoute::_($city_sort); ?>" target=
          "_top"><?php echo JText::_('LOCATION'); ?></a></td><?php $type_sort = $sortlink.'&order=type' ?>

          <td align="left" class="jtitle"><a <?php if($order=='type') echo 'class="'.$sortimage.'"';?> href="<?php echo JRoute::_($type_sort); ?>" target=
          "_top"><?php echo JText::_('CATEGORY'); ?></a></td>
        </tr><?php if ($count < 1) : ?>

        <tr valign="top">
          <td><?php echo JText::_('NO_JOBS_LISTED'); ?></td>
        </tr><?php else: ?><? $rt = 0; ?>
        <?php foreach($this->data as $row) : ?>
            <?php $row_style = ($rt == 0)? 'bgwhite' : 'bggrey'; ?>
            <?php $rt = ($rt == 0)? 1 : 0; ?>

            <tr valign="top">
              <?php $date = new JDate($row->post_date); ?>

              <td class="<?php echo $row_style?>">
                <?php echo $date->toFormat("%B %d, %Y"); ?>
              </td>
              <?php $job_link = 'index.php?option=com_jobboard&view=job&id='.$row->id.'&catid='.$this->selcat.'&lyt=table'; ?>
              <td class="<?php echo $row_style?>">
                <a href="<?php echo JRoute::_($job_link); ?>" class="JobLink" target="_top">
                    <?php if(strlen($this->jobsearch) > 0) : ?>
                        <?php $pattern = $this->jobsearch; $replacement = '<span class="highlight">'.$this->jobsearch.'</span>'; ?>
                        <?php $job_title_h = str_ireplace ( $pattern, $replacement, $row->job_title); ?>
                    <?php else : ?>
                        <?php $job_title_h = $row->job_title; ?>
                    <?php endif; ?>
                    <?php $city_h = $row->city; ?>
                    <?php if(strlen($this->keysrch) > 0) : ?>
                        <?php $skillsets = explode(',', $this->keysrch); ?>
                        <?php foreach ($skillsets as $keywd) : ?>
                          <?php $pattern = $keywd; $replacement = '<span class="highlight">'.$keywd.'</span>'; ?>
                          <?php $job_title_h = str_ireplace ( $pattern, $replacement, $job_title_h); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(strlen($this->locsrch) > 0) : ?>
                        <?php $pattern = $this->locsrch; $replacement = '<span class="highlight">'.$this->locsrch.'</span>'; ?>
                        <?php $job_title_h = str_ireplace ( $pattern, $replacement, $job_title_h); ?>
                        <?php $city_h = str_ireplace ( $pattern, $replacement, $city_h); ?>
                    <?php endif; ?>   
                        <strong><?php echo $job_title_h; ?></strong>
                </a>
              </td>
              <td class="<?php echo $row_style?>"><?php echo $row->job_level; ?></td>
              <td class="<?php echo $row_style?>"><?php echo $city_h; ?></td>
              <td class="<?php echo $row_style?>"><?php echo $row->category; ?></td>
            </tr>
        <?php endforeach; ?><?php endif; ?>
      </tbody>
    </table>
    <div class="pagination botpagi" align="right"><?php echo $this->pagination->getPagesLinks().'<br />'.JText::_('RESULTS_PER_PAGE').':&nbsp;&nbsp;'.$this->pagination->getLimitBox();?></div>
    <div align="center" id="feedarea">
       <?php echo '<b>'.JText::_('RSS'). ' </b>' .JText::_('FEED'); ?>: <a class="feedicon" href="<?php echo JRoute::_($feedlink).$feedPrefix.'format=feed' ?>"><?php echo $seldesc; ?></a>
       <?php if (intval($selcat) <> 1) : ?>
        &nbsp;&nbsp;<a class="feedicon" href="<?php echo JRoute::_($all_cat_feedlink).$feedPrefix.'format=feed' ?>"><?php echo JText::_('ALL_CATEGORIES'); ?></a>
      <?php endif; ?>
    </div>
  </div>
  <input type="hidden" name="layout" value="table" />
  <?php echo JHTML::_('form.token'); ?>
 </form>
 <?php echo $this->setstate; ?>