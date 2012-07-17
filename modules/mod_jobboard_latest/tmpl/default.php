<table border="0" class="tbljoblist">
  <tbody>
    <tr>
      <th><?php echo JText::_('Job Title'); ?></th>
      <th><?php echo JText::_('#Appl.'); ?></th>
    </tr>
    <?php foreach ($latest_jobs as $job) : ?>
      <?php $link = 'index.php?option=com_jobboard&view=job&id='.$job->id; ?>
        <tr>
          <td style="width: 79%;font-weight:bold"><a href="<?php echo JRoute::_($link); ?>"><?php echo $job->job_title.' - '.$job->city; ?></a></td>
          <td style="width: 20%"><?php echo $job->num_applications; ?></td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $jobs_link = 'index.php?option=com_jobboard&view=list&catid=1&layout=list'; ?>
<p class="jlink"><a href="<?php echo JRoute::_($jobs_link); ?>"><?php echo JText::_('View job list').' <strong>&raquo;</strong>'; ?></a></p>
<br style="clear:both" />