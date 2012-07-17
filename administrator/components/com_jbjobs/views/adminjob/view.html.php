<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	August 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminjob/view.html.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Entry point for the component (jbjobs)
 ^ 
 * History		:	NONE
 * */
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );

$document = JFactory::getDocument();
$document->addStyleSheet ( JURI::base().'components/com_jbjobs/assets/css/style.css' );
/**
 * Jbjobs view
 *
 * @package    Joomla.Components
 * @subpackage 	Jbjobs
 */
class JbjobsViewAdminjob extends JView{
	/**
	 * display method of Jbjobs view
	 * @return void
	 **/
	function display($tpl = null){		
		$layout =  JRequest::getVar('layout');
		$model		=& $this->getModel(); 

		if($layout == 'dashboard' or $layout == ''){
			$return 	= $model->getDashboard();
			$users 		= $return[0];
			$jobseekers = $return[1];
			$employers 	= $return[2];
			$jobs 		= $return[3];
			
			$this->assignRef('users', $users);
			$this->assignRef('jobseekers', $jobseekers);
			$this->assignRef('employers', $employers);
			$this->assignRef('jobs', $jobs);
		}
		elseif($layout == 'joblist'){
			$return  = $model->getJobList();
			$rows 	 = $return[0];
			$pageNav = $return[1];
			$lists 	 = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef( 'lists', $lists );
		}
		elseif($layout == 'editjob'){
			$return = $model->getEditJob();
			$row = $return[0];
			$lists = $return[1];
			$custom = $return[2];
			
			$this->assignRef('row', $row);
			$this->assignRef('lists', $lists);
			$this->assignRef('custom', $custom);
		}
		elseif($layout == 'publishjob'){
			$row = $model->getPublishJob();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showbilling'){
			$return = $model->getShowBilling();
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'showemployer'){
			$return  = $model->getShowEmployer();
			$rows 	 = $return[0];
			$pageNav = $return[1];
			$lists 	 = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('lists', $lists);
		}
		elseif($layout == 'editemployer'){
			$return = $model->getEditEmployer();
			$row 	= $return[0];
			$lists 	= $return[1];
			$custom = $return[2];
			
			$this->assignRef('row', $row);
			$this->assignRef('lists', $lists);
			$this->assignRef('custom', $custom);
		}
		elseif($layout == 'showjobseeker'){
			$return  = $model->getShowJobSeeker();
			$rows 	 = $return[0];
			$pageNav = $return[1];
			$lists 	 = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('lists', $lists);
		}
		elseif($layout == 'editjobseeker'){
			$return = $model->getEditJobSeeker();
			$row 	= $return[0];
			$lists 	= $return[1];
			$custom = $return[2];
			$exp 	= $return[3];
			
			$this->assignRef('row', $row);
			$this->assignRef('lists', $lists);
			$this->assignRef('custom', $custom);
			$this->assignRef('exp', $exp);
		}
		elseif($layout == 'showsubscr'){
			$return  = $model->getShowSubscr();
			$rows 	 = $return[0];
			$pageNav = $return[1];
			$lists 	 = $return[2];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
			$this->assignRef('lists', $lists);
		}
		elseif($layout == 'editsubscr'){
			$return = $model->getEditSubscr();
			$row = $return[0];
			$users = $return[1];
			$plans = $return[2];
			
			$this->assignRef('row', $row);
			$this->assignRef('users', $users);
			$this->assignRef('plans', $plans);
		}
		elseif($layout == 'showcustomuser'){
			$return = $model->getShowCustomUser();
			
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editcustomuser'){
			$row = $model->getEditCustomUser();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'showcustomjob'){
			$return = $model->getShowCustomJob();
			$rows = $return[0];
			$pageNav = $return[1];
			
			$this->assignRef('rows', $rows);
			$this->assignRef('pageNav', $pageNav);
		}
		elseif($layout == 'editcustomjob'){
			$row = $model->getEditCustomJob();
			$this->assignRef('row', $row);
		}
		elseif($layout == 'about'){
			$parser		=& JFactory::getXMLParser('Simple');
			$xml		= JPATH_COMPONENT . DS . 'com_jbjobs.xml';
			$parser->loadFile( $xml );
	
			$doc		=& $parser->document;
			$element	=& $doc->getElementByPath( 'version' );
			$version	= $element->data();
	
			$this->assign('version', $version);
		}

		parent::display($tpl); ?>
			<table width="100%" style="table-layout:fixed;">
			<tr>
				<td style="vertical-align:top;">
					<?php
						include_once('components/com_jbjobs/views/joombahcr.php');
					?>
				</td>
			</tr>
		</table>
<?php	}
	
}