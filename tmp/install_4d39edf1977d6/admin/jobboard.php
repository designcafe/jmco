<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted Access');


JToolBarHelper::title(JText::_('Job Board'), 'generic.png');
jimport('joomla.application.component.controller');

// Get the view and controller from the request, or set to default if they weren't set
JRequest::setVar('view', JRequest::getCmd('view','dashboard'));
JRequest::setVar('cont', JRequest::getCmd('view','dashboard')); // Get controller based on the selected view

jimport('joomla.filesystem.file');

// Load the appropriate controller
$cont = JRequest::getCmd('cont','dashboard');
$path = JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.$cont.'.php';
$jb_version = '1.5.0f';
if(JFile::exists($path))
{
	// The requested controller exists and there you load it...
	require_once($path);
}
else
{
	// Invalid controller was passed
	JError::raiseError('500',JText::_('Unknown controller' . $path));
}
// echo '<div align="center" style="clear: both;padding-top: 15px"><small>developed by&nbsp;<a href="http://figo.tandolin.co.za" target="_blank">Figo&nbsp;Mago</a>,&nbsp;r&d @ <a href="http://www.tandolin.co.za" target="_blank">www.tandolin.co.za</a></small></div>';

$url = "http://www.tandolin.co.za";
$img_file = "tandolin_logo.png";
$img_path = "components/com_jobboard/images";
?>
<table style="margin-bottom: 5px; width: 100%; border-top: thin solid #e5e5e5;">
	<tbody>
	<tr>
		<td style="text-align: left; width: 33%;">
            <strong><?php echo JText::_('REF_LINKS'); ?></strong>
            <br />
			&nbsp;&nbsp;&nbsp;<a href="http://demo.tandolin.co.za/tandolin-forum.html" target="_blank"><?php echo JText::_( "Forum" ); ?></a>
			<br />
			&nbsp;&nbsp;&nbsp;<a href="http://bit.ly/tandolin-twitter" target="_blank"><?php echo JText::_( "Twitter" ); ?></a>
			<br/>
			&nbsp;&nbsp;&nbsp;<a href="http://bit.ly/tandolin-linkedin" target="_blank"><?php echo JText::_( "LinkedIN" ); ?></a>
			<br/>
			&nbsp;&nbsp;&nbsp;<a href="http://bit.ly/tandolin-fb" target="_blank"><?php echo JText::_( "Facebook" ); ?></a>
			<br/>
		</td>
		<td style="text-align: center; width: 33%;">
			<?php echo JText::_( "JOB_BOARD" ).' - '.JText::_('COMP_VER').' '.$jb_version; ?>: <?php echo JText::_( "JOOM_JOB_COMP" ); ?>
			<br/>
			<small><?php echo JText::_('DEV_BY')?>&nbsp;<a href="http://figo.tandolin.co.za" target="_blank">Figo&nbsp;Mago</a>,&nbsp;r&d @ <a href="<?php echo $url; ?>" target="_blank">Tandolin</a></small>
            <br/><?php echo JText::_( "COPYR" ); ?>: &copy; <a href="<?php echo $url; ?>" target="_blank">Tandolin Consultants cc</a>
		</td>
		<td style="text-align: right; width: 33%;padding-top:5px">
			<?php echo JText::_('PAYP_TXT')?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_donations">
				<input type="hidden" name="business" value="dev@tandolin.co.za">
				<input type="hidden" name="item_name" value="Donation to Tandolin.co.za">
				<input type="hidden" name="no_shipping" value="0">
				<input type="hidden" name="no_note" value="1">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="tax" value="0">
				<input type="hidden" name="bn" value="PP-DonationsBF">
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</td>
	</tr>
	</tbody>
</table>

