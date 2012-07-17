<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

   // Protect from unauthorized access
   defined('_JEXEC') or die('Restricted Access');

   JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
   // Load framework base classes
   jimport('joomla.application.component.controller');

   class JobboardControllerShare extends JController
   {

     function display()
     {
       global $option;
       $id = JRequest :: getVar('job_id', '', '', 'int');
       $this->getSharingForm($id);
     }

     function getSharingForm($id)
     {

       $job_model =& $this->getModel('Apply');
       $job_data = $job_model->getJobData($id);
       $catid = JRequest :: getVar('catid', '', '', 'int');

       $messg_model =& $this->getModel('Message');
       $msg_id = $messg_model->getMsgID('sharejob');
       $msg = $messg_model->getMsg($msg_id);
       $config_model =& $this->getModel('Config');
       $config = $config_model->getShareConfig();
       //echo json_encode($msg);

       //set the view parameters
       JRequest :: setVar('job_id', $id);
       JRequest :: setVar('catid', $catid);
       JRequest :: setVar('data', $job_data);
       JRequest :: setVar('msg', $msg->body);  
       JRequest :: setVar('config', $config);    

       JRequest :: setVar('view', 'share');
       parent :: display();
     }
   }

   $controller = new JobboardControllerShare();
   $controller->execute($task);
   $controller->redirect();
?>
