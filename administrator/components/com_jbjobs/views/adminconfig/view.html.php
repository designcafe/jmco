<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/view.html.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );

$styles = <<<EOF
#submenu-box {
	display: none !important;
}
EOF;

$document = JFactory::getDocument();
$document->addStyleDeclaration($styles);
$document->addStyleSheet ( JURI::base().'components/com_jbjobs/assets/css/style.css' );

class JbjobsViewAdminconfig extends JView {
	/**
	 * display method of Jbjobs view
	 * @return void
	 **/
	function display($tpl = null) { ?>


		<?php	
		$link_dashboard 	= JRoute::_('index.php?option=com_jbjobs');
		$link_compsetting	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=config');
		$link_memberplan	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showplan');
		$link_country		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showcountry');
		$link_degree 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showdeglevel');
		$link_employer 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showuniversity');
		$link_major			= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showmajor');
		$link_university 	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showuniversity');
		$link_salary 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showsaltype');
		$link_jobexp 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showjobexp');
		$link_company 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showcomptype');
		$link_salutation	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showsalutation');
		$link_position 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showpostype');
		$link_jobspecial	= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showjobspec');
		$link_jobcateg 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showjobcateg');
		$link_industry 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showindcomp');
		$link_frontpage		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=showtext');
		$link_message 		= JRoute::_('index.php?option=com_jbjobs&view=adminconfig&layout=msgsettings');		
		?>
<!--[if IE]>
<style type="text/css">

table.jbadmin-stat caption {
	display:block;
	font-size:12px !important;
	padding-top: 10px !important;
}

</style>
<![endif]-->

<div id="jbadmin">
	<div class="jbadmin-left">
		<div id="jbadmin-menu">
			<?php $stask = JRequest::getVar ( 'task', null ); ?>
				<a class="jbadmin-mainmenu icon-db-sm" href="<?php echo $link_dashboard; ?>"><?php echo JText::_('JoomBah Dashboard'); ?></a>
				<a class="jbadmin-mainmenu icon-component-sm" href="<?php echo $link_compsetting; ?>"><?php echo JText::_('Component Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-membership-sm" href="<?php echo $link_memberplan; ?>"><?php echo JText::_('Membership Plans'); ?></a>
				<a class="jbadmin-mainmenu icon-country-sm" href="<?php echo $link_country; ?>"><?php echo JText::_('Country Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-major-sm" href="<?php echo $link_major; ?>"><?php echo JText::_('Study of Major Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-degree-sm" href="<?php echo $link_degree; ?>"><?php echo JText::_('Degree Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-university-sm" href="<?php echo $link_university; ?>"><?php echo JText::_('University Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-salary-sm" href="<?php echo $link_salary; ?>"><?php echo JText::_('Salary Type Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-jobexp-sm" href="<?php echo $link_jobexp; ?>"><?php echo JText::_('Job Experience Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-company-sm" href="<?php echo $link_company; ?>"><?php echo JText::_('Company Type Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-salutation-sm" href="<?php echo $link_salutation; ?>"><?php echo JText::_('Salutation Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-position-sm" href="<?php echo $link_position; ?>"><?php echo JText::_('Position Type Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-jobspecial-sm" href="<?php echo $link_jobspecial; ?>"><?php echo JText::_('Job Specialization Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-jobcateg-sm" href="<?php echo $link_jobcateg; ?>"><?php echo JText::_('Job Category Settings'); ?></a>
                <a class="jbadmin-mainmenu icon-industry-sm" href="<?php echo $link_industry; ?>"><?php echo JText::_('Industry Type Settings'); ?></a>
				<a class="jbadmin-mainmenu icon-frontpage-sm" href="<?php echo $link_frontpage; ?>"><?php echo JText::_('Frontpage Text'); ?></a>
				<a class="jbadmin-mainmenu icon-message-sm" href="<?php echo $link_message; ?>"><?php echo JText::_('Private Message Settings'); ?></a>
		</div>
	</div>
	
		<?php	
		$layout =  JRequest::getVar('layout');
		$model		=& $this->getModel(); 
		
		if($layout == 'config'){
			$return = $model->getConfig();
			$row = $return[0];
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showplan'){
			$return = $model->getShowMemberPlan();
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editplan'){
			$row = $model->getEditMemberPlan();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showcountry'){
			$return = $model->getShowCountry();
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editcountry'){
			$row = $model->getEditCountry();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showuniversity'){
			$return = $model->getShowUniversity();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'edituniversity'){
			$row = $model->getEditUniversity();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showmajor'){
			$return = $model->getShowMajor();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editmajor'){
			$row = $model->getEditMajor();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showdeglevel'){
			$return = $model->getShowDegLevel();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editdeglevel'){
			$row = $model->getEditDegLevel();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showsaltype'){
			$return = $model->getShowSalType();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editsaltype'){
			$row = $model->getEditSalType();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showjobexp'){
			$return = $model->getShowJobExp();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editjobexp'){
			$row = $model->getEditJobExp();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showcomptype'){
			$return = $model->getShowCompType();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editcomptype'){
			$row = $model->getEditCompType();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showsalutation'){
			$return = $model->getShowSalutation();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editsalutation'){
			$row = $model->getEditSalutation();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showpostype'){
			$return = $model->getShowPosType();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editpostype'){
			$row = $model->getEditPosType();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showjobspec'){
			$return = $model->getShowJobSpec();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editjobspec'){
			$row = $model->getEditJobSpec();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showjobcateg'){
			$return = $model->getShowJobCateg();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editjobcateg'){
			$row = $model->getEditJobCateg();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showindcomp'){
			$return = $model->getShowIndComp();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editindcomp'){
			$row = $model->getEditIndComp();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showtext'){
			$rows = $model->getShowText();
			$this->assignRef('rows', $rows);
		}
		elseif($layout == 'edittext'){
			$row = $model->getEditText();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'msgsettings'){
			$return = $model->getMsgSettings();
			
			// Get data from the model
			$messageLimits	= $return[0];
			$nameSuggestion	= $return[1];
			$sendNotify		= $return[2];
			$limitAddress	= $return[3];
			$types = array( JText::_( "SUPERADMINISTRATOR" ), JText::_( "ADMINISTRATOR" ), JText::_( "MANAGER" ), JText::_( "PUBLISHER" ), JText::_( "EDITOR" ), JText::_( "AUTHOR" ), JText::_( "REGISTERED" ) );
	
			$this->assignRef('messageLimits', $messageLimits);
			$this->assignRef('nameSuggestion', $nameSuggestion);
			$this->assignRef('sendNotify', $sendNotify);
			$this->assignRef('limitAddress', $limitAddress);
			$this->assignRef('types', $types);
		}?>
	<div class="jbadmin-right">
		<?php	parent::display($tpl);?>
		
		<table width="100%" style="table-layout:fixed;">
			<tr>
				<td style="vertical-align:top;">
					<?php
						include_once('components/com_jbjobs/views/joombahcr.php');
					?>
				</td>
			</tr>
		</table>
	</div>
</div>	
<?php	
	}
	
	
	
	
}