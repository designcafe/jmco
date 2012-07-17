<?php
/**
* @package   Zoo Component
* @version   1.0.3 2009-03-28 16:17:52
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2009 YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

/*
   Class: TypeViewType
   The View Class for type (html)
*/
class TypeViewType extends JView {

	function display($tpl = null) {

		switch ($this->getLayout()) {
			case 'editelements':
				$this->editElements($tpl);
				break;

			case 'add':
			case 'edit':
			default:
				$this->edit($tpl);
				break;
		}

	}

	function edit($tpl = null) {
		
		$db   =& JFactory::getDBO();
		$user =& JFactory::getUser();

		// get request vars
		$option     = JRequest::getCmd('option');
		$controller = JRequest::getWord('controller');
		$cid        = JRequest::getVar('cid', array(0), '', 'array');
		$edit       = intval($cid[0]) > 0;

		// get type
		$type =& Type::getInstance(intval($cid[0]));

		// set toolbar items
		JToolBarHelper::title(JText::_('Type').': '.$type->name.' <small><small>[ '.($edit ? JText::_('Edit') : JText::_('New')).' ]</small></small>', ZOO_ICON);
		JToolBarHelper::save();
		JToolBarHelper::apply();
		$edit ?	JToolBarHelper::cancel('cancel', 'Close') : JToolBarHelper::cancel();
		ZooHelper::toolbarHelp();

		// set template vars
		$this->assignRef('user', $user);
		$this->assignRef('option', $option);
		$this->assignRef('controller', $controller);
		$this->assignRef('type', $type);

		parent::display($tpl);
	}

	function editElements($tpl = null) {
		
		$db   =& JFactory::getDBO();
		$user =& JFactory::getUser();

		// get request vars
		$option     = JRequest::getCmd('option');
		$controller = JRequest::getWord('controller');
		$cid        = JRequest::getVar('cid', array(0), '', 'array');

		// get type
		$type =& Type::getInstance(intval($cid[0]));

		// set toolbar items
		JToolBarHelper::title(JText::_('Type').': '.$type->name.' <small><small>[ '.JText::_('Edit').' ]</small></small>', ZOO_ICON);
		JToolBarHelper::save('saveelements');
		JToolBarHelper::apply('applyelements');
		JToolBarHelper::cancel('cancel', 'Close');
		ZooHelper::toolbarHelp();
		
		// sort elements by group
		foreach (ElementHelper::getAll() as $element) {
			$metadata = $element->configMetaData();
			$elements[$metadata['group']][] = $element;
		}
		ksort($elements);

		// set template vars
		$this->assignRef('user', $user);
		$this->assignRef('option', $option);
		$this->assignRef('controller', $controller);
		$this->assignRef('type', $type);
		$this->assignRef('elements', $elements);

		parent::display($tpl);
	}

}