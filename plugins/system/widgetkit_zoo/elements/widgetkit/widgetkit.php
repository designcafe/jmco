<?php
/**
* @package   Widgetkit
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   YOOtheme Proprietary Use License (http://www.yootheme.com/license)
*/

/*
   Class: ElementWidgetkit
       The Widgetkit wapper element class
*/
class ElementWidgetkit extends Element {

	protected $widgetkit;

	public function __construct() {
		parent::__construct();

		// load widgetkit
		require_once(JPATH_ADMINISTRATOR.'/components/com_widgetkit/widgetkit.php');

		$this->widgetkit = Widgetkit::getInstance();

	}

	/*
		Function: hasValue
			Checks if the element's value is set.

	   Parameters:
			$params - render parameter

		Returns:
			Boolean - true, on success
	*/
	public function hasValue($params = array()) {
		$value = (int) $this->get('value', $this->config->get('default'));
		return !empty($value);
	}

	/*
		Function: render
			Renders the element.

	   Parameters:
            $params - render parameter

		Returns:
			String - html
	*/
	public function render($params = array()) {

		// render widget
		if ($widget_id = (int) $this->get('value', $this->config->get('default'))) {

			// render output
			$output = $this->widgetkit['widget']->render($widget_id);
			return ($output === false) ? JText::printf("Could not load widget with the id %s.", $widget_id) : $output;

		}
	}

	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit() {
		return $this->widgetkit['field']->render('widget', $this->getControlName('value'), $this->get('value', $this->config->get('default')), null);
	}

	/*
		Function: getConfigForm
			Get parameter form object to render input form.

		Returns:
			Parameter Object
	*/
	public function getConfigForm() {
		return parent::getConfigForm()->addElementPath(dirname(__FILE__));
	}

}