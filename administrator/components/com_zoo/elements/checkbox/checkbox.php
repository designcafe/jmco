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

// register parent class
JLoader::register('ElementSimple', ZOO_ADMIN_PATH.'/elements/simple/simple.php');

/*
	Class: ElementCheckbox
		The checkbox element class
*/
class ElementCheckbox extends ElementSimple {

	/** @var array */
	var $options;

	/*
	   Function: Constructor
	*/
	function ElementCheckbox() {

		// call parent constructor
		parent::ElementSimple();
		
		// init vars
		$this->type  = 'checkbox';
		$this->_table_columns = array('_value' => 'TEXT');		

		// set defaults
		$this->options = array();
	
		// set callbacks
		$this->registerCallback('configEditOption');		
	}

	/*
		Function: getValue
			Gets the value.

		Returns:
			String - Value
	*/
	function getValue() {
		
		// init vars
		$values = new JParameter($this->value);
		$values = $values->toArray();
		$count  = count($values);

		if ($count == 1) {
			return $values[0];
		}

		if ($count) {
			return $values;
		}

		return null;
	}

	/*
		Function: render
			Renders the element.

	   Parameters:
            $view - current view

		Returns:
			String - html
	*/
	function render($view = ZOO_VIEW_ITEM) {

		$options = array();
		$values  = $this->getValue();

		if (!is_array($values)) {
			$values = array($values);
		}

		foreach ($this->options as $option) {
			if (in_array($option['value'], $values)) {
				$options[] = $option;
			}
		}

		// render layout
		if ($layout = $this->getLayout()) {
			return Element::renderLayout($layout, array('options' => $options));
		}
		
		return $this->getValue();
	}

	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	function edit() {

		// set default, if item is new
		if ($this->default != '' && $this->_item != null && $this->_item->id == 0) {
			$this->value = '0='.$this->default;
		}

		// init vars
		$i       = 0;
		$html    = array();
		$options = array();
		$values  = (array) $this->getValue();
		
		foreach ($this->options as $option) {
			$id      = $this->name.'_value'.$i++;
			$checked = in_array($option['value'], $values) ? ' checked="checked"' : null;
			$html[]  = '<input id="'.$id.'" type="checkbox" name="'.$this->name.'_value[]" value="'.$option['value'].'"'.$checked.'><label for="'.$id.'">'.$option['name'].'</label>';
		}

		$html[] = '<input type="hidden" name="'.$this->name.'_check" value="1">';

		return implode("\n", $html);
	}

	/*
    	Function: bind
    	  Binds a named array/hash to this object.
		
		Parameters:
	      $data - An associative array or object.
	
	   Returns:
	      Void	
 	*/
	function bind($data) {
		
		parent::bind($data);

		// init vars
		$values = new JParameter('');

		if (isset($data[$this->name.'_value'])) {
			$value = $data[$this->name.'_value'];

			if (!is_array($value)) {
				$value = array($value);
			}

			$values->loadArray($value);
		}

		$this->value = $values->toString();
	}

	/*
		Function: configLoadAssets
			Load elements css/js config assets.

		Returns:
			Void
	*/
	function configLoadAssets() {
		JHTML::script('checkbox.js', 'administrator/components/com_zoo/elements/checkbox/');
		JHTML::stylesheet('checkbox.css', 'administrator/components/com_zoo/elements/checkbox/');
	}

	/*
		Function: configBindArray
			Binds the data array.

		Parameters:
			$data - data array
	        $ignore - An array or space separated list of fields not to bind

		Returns:
			Void
	*/
	function configBindArray($data, $ignore = array()) {

		parent::configBindArray($data, $ignore);

		if (!isset($data['options'])) {
			$this->options = array();
		}
	}
	
	/*
	   Function: configBindXML
	       Converts the XML to a Dataarray and calls the bind method.

	   Parameters:
	      XML - The XML for this Element
	*/
	function configBindXML($xml) {

		parent::configBindXML($xml);
				
		if (isset($xml->option)) {
			foreach ($xml->option as $option) {
				$this->options[] = array(
					'name'  => $option->attributes('name'),
					'value' => $option->attributes('value'));
			}
		}
	}
		
	/*
	   Function: configToXML
   	      Get elements XML.

	   Returns:
	      Object - JSimpleXMLElement
	*/
	function configToXML() {

		$xml = parent::configToXML(array('options'));
		
		foreach ($this->options as $option) {
			if ($option['name'] != '' || $option['value'] != '') {
				$xml->addChild('option', array(
					'name'  => $option['name'],
					'value' => $option['value']));	
			}
		}
		
		return $xml;
	}

	/*
		Function: configParams
			Get elements params.

		Returns:
			Object - JParameter
	*/
	function &configParams() {
		
		$params = new ElementParameter('');
		$params->setElement($this);

		// set data
		foreach ($this->getProperties() as $name => $value) {
			if ($name != 'options') {
				$params->set($name, $value);
			}
		}
		
		return $params;
	}

	/*
	   Function: configEditOptions
	      Renders elements options for form input.

	   Parameters:
	      $var - form var name

	   Returns:
		  String
	*/
	function configEditOptions($var){
	
		// init vars
		$option     = JRequest::getCmd('option');
		$controller = JRequest::getWord('controller');
		$id         = str_replace(array('[', ']'), '_', $var).'options';		
		$i          = 0;

		// create options
		$options  = '<div id="'.$id.'" class="select-options">';
		$options .= '<ul>';
		foreach ($this->options as $opt) {
			$options .= '<li>'.$this->configEditOption($var, $i++, $opt['name'], $opt['value']).'</li>';
		}
		$options .= '</ul>';
		$options .= '<div class="option-add">'.JText::_('Add Option').'</div>';
		$options .= '</div>';

		// create js
		$javascript  = "var c = new ElementCheckbox('$id', '".JRoute::_('index.php?option='.$option.'&controller='.$controller.'&view=type&format=raw', false)."', { variable: '$var' });";
		$javascript .= "c.attachEvents();";
		$javascript  = "<script type=\"text/javascript\">\n// <!--\n$javascript\n// -->\n</script>\n";

		return $options.$javascript;
	}

	/*
	   Function: configEditOption
	      Renders elements options for form input.

	   Parameters:
	      $var - form var name
	      $num - option order number

	   Returns:
		  Array
	*/
	function configEditOption($var, $num, $name = null, $value = null){

		$html  = '<div><label for="name">Name</label>';
		$html .= JHTML::_('control.text', $var.'[options]['.$num.'][name]', $name, 'id="name"').'</div>';
		$html .= '<div><label for="value">Value</label>';
		$html .= JHTML::_('control.text', $var.'[options]['.$num.'][value]', $value, 'id="value"').'</div>';
		$html .= '<div class="option-delete" title="'.JText::_('Delete option').'"><img src="'.ZOO_ADMIN_URI.'assets/images/delete.png"/></div>';

		return $html;
	}

}