<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */
defined('_JEXEC') or die('Restricted access');
?>

<?php $sortlink = JFilterOutput::ampReplace('index.php?option=com_jobboard&view=list&Itemid='.JRequest::getVar('Itemid','')); ?>
<?php $document =& JFactory::getDocument(); ?>

<!--sort order-->
<?php $sort = $app->getUserStateFromRequest('jb_list.sort','sort','d'); ?>
<?php $order = $app->getUserStateFromRequest('jb_list.order','order','date'); ?>
<?php $sortlink = ($sort=='a')? $sortlink.'&sort=d' : $sortlink.'&sort=a'; ?>

<!--Pagination-->
<?php $pagination =& $this->get('Pagination'); ?>
<?php $this->assignRef('pagination', $pagination); ?>

<!--display page title if configured-->
<?php $params =& $app->getParams('com_content'); ?>
<?php $this->assignRef('params' , $params); ?>
<?php $selcat = $this->selcat; ?>   
<?php $seldesc = ''; ?>
  <form id="category_list" name="category_list" method="post" action="<?php echo JRoute::_($link); ?>">
          <?php $all_jobs = 'index.php?option=com_jobboard&view=list&catid=1&search='; ?>
          <?php $link = 'index.php?option=com_jobboard&view=list'; ?>
               <div align="center" style="width:auto">
                <div valign="top" style="padding-bottom:5px" align="center"><select name="catid" class="inputfield ">
                    <?php foreach($this->categories as $cat) : ?>
                      <option class="catitem" value="<?php echo $cat->id; ?>" <?php if($cat->id == $this->selcat) {$selcat = $cat->id; $seldesc = $cat->type; echo ' selected="selected"';}?>>
                          <?php echo $cat->type;?>
                      </option>
                    <?php endforeach; ?>
                    <?php  $feed_title = $seldesc.' '.JText::_('FEED'); ?>
                    <?php  $rss = array('type' => 'application/rss+xml', 'title' => $feed_title.' (RSS)' ); ?>
                    <?php  $atom = array('type' => 'application/atom+xml', 'title' => $feed_title. ' (Atom)' ); ?>
                    <?php $all_cat_feedlink = 'index.php?option=com_jobboard&view=list&catid=1&format=feed'; ?>
                    <?php $feedlink = 'index.php?option=com_jobboard&view=list&catid='.$selcat.'&format=feed'; ?>
                    <!-- add the header links -->
                     <?php $document->addHeadLink(JRoute::_($feedlink.'&type=rss'), 'alternate', 'rel', $rss); $document->addHeadLink(JRoute::_($feedlink.'&type=atom'), 'alternate', 'rel', $atom); ?>
                    <?php $document->setTitle(JText::_('JOBS IN').': '.$seldesc); ?>
                    <?php $document->setMetaData('keywords', JText::_('JOBLISTMETAKEY').', '.$seldesc); ?>
                    <?php $document->setMetaData('description', JText::_('JOBLISTMETADESC').': '.$seldesc); ?>
                  </select></div>
        		<div align="center">
        				<label for="search"><small><?php echo JText::_('FILTER_BY_KEYWORD');?>:</small></label> <input class="inputfield " type="text" name="search" value="<?php echo $this->search ?>" id="search" />
        				<input style="margin-left:7px" class="button" type="submit" value="<?php echo JText::_('SHOW_JOBS');?>" />
        			</div>
                    <div valign="bottom" align="center">
                      <?php if ($selcat <> 1) : ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><a href="<?php echo JRoute::_($all_jobs); ?>" class="JobLink" target="_top"><strong><?php echo JText::_('VIEW_ALL_JOBS'); ?></strong></a></small>
                      <?php endif; ?>
                    </div>
             </div>
  <?php $count = count($this->data); ?>

  <div id="itsthetable">
    <table width="96%" cellspacing="0" cellpadding="5" align="center" class="text">
     <?php $tbl_view_link = 'index.php?option=com_jobboard&view=list&catid='.$selcat.'&layout=table'; ?>
     <?php $list_view_link = 'index.php?option=com_jobboard&view=list&catid='.$selcat.'&layout=list'; ?>
    <div class="pagination" align="right" ><?php echo $this->pagination->getResultsCounter().$this->pagination->getPagesLinks();?>&nbsp;&nbsp;<a href="<?php echo JRoute::_($tbl_view_link) ?>" title="Table view" class="tableView"></a><a href="<?php echo JRoute::_($list_view_link) ?>" title="List view" class="listView"></a></div>
      <tbody>
        <tr>
          <td></td>
        </tr>

        <tr valign="top" class="headbg">
          <?php $date_sort = $sortlink.'&order=date' ?>

          <td height="18" align="left" class="jtitle"><a href=
          "<?php echo JRoute::_($date_sort); ?>" target="_top"><?php echo JText::_('POSTED') ?></a></td><?php $title_sort = $sortlink.'&order=title' ?>

          <td align="left" class="jtitle"><a href="<?php echo JRoute::_($title_sort); ?>" target=
          "_top"><?php echo JText::_('TITLE'); ?></a></td><?php $level_sort = $sortlink.'&order=level' ?>

          <td align="left" class="jtitle"><a href="<?php echo JRoute::_($level_sort); ?>" target=
          "_top"><?php echo JText::_('CAREER_LEVEL'); ?></a></td><?php $city_sort = $sortlink.'&order=city' ?>

          <td align="left" class="jtitle"><a href="<?php echo JRoute::_($city_sort); ?>" target=
          "_top"><?php echo JText::_('LOCATION'); ?></a></td><?php $type_sort = $sortlink.'&order=type' ?>

          <td align="left" class="jtitle"><a href="<?php echo JRoute::_($type_sort); ?>" target=
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
              <?php $link = 'index.php?option=com_jobboard&view=job&id='.$row->id.'&catid='.$this->selcat; ?>
              <td class="<?php echo $row_style?>">
                <a href="<?php echo JRoute::_($link); ?>" class="JobLink" target="_top">
                    <?php if(strlen($this->search) > 0) : ?>
                        <?php $pattern = $this->search; $replacement = '<span class="highlight">'.$this->search.'</span>'; ?>
                        <?php $job_title_h = str_ireplace ( $pattern, $replacement, $row->job_title); ?>
                        <?php $city_h = str_ireplace ( $pattern, $replacement, $row->city); ?>
                    <?php else : ?>
                        <?php $job_title_h = $row->job_title; ?>
                        <?php $city_h = $row->city; ?>
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
    <div class="pagination" align="right" style="padding-top:7px"><?php echo JText::_('RESULTS_PER_PAGE').':&nbsp;&nbsp;'.$this->pagination->getLimitBox();?></div>
    <div align="center" id="feedarea">
       <?php echo '<b>'.JText::_('RSS'). ' </b>' .JText::_('FEED'); ?>: <a class="feedicon" href="<?php echo JRoute::_($feedlink) ?>"><?php echo $seldesc; ?></a>
       <?php if (intval($selcat) <> 1) : ?>
        &nbsp;&nbsp;<a class="feedicon" href="<?php echo JRoute::_($all_cat_feedlink) ?>"><?php echo JText::_('ALL_CATEGORIES'); ?></a>
      <?php endif; ?>
    </div>
  </div>
  <input type="hidden" name="layout" value="table" />
  <input type="hidden" name="catid" value="<?php echo $selcat; ?>" />
  <?php echo JHTML::_('form.token'); ?>
 </form>
 <?php echo $this->setstate; ?>