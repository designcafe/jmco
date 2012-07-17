<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

   // Protect from unauthorized access
   defined('_JEXEC') or die('Restricted Access');

   class JobboardModelConfig extends JModel
   {

     /**
     * Address ID
     *
     * @var int
     */
       var $_id;


     /**
     * Address action result
     *
     * @var boolean
     */
       var $_result;

     /**
     * Constructor, builds object and determines the ID  (always set to 1)
     *
     */
       function __construct()
       {
         parent :: __construct();

         $id = 1;
         $this->setId($id);
       }

     /**
     * Initialise the ID and data
     *
     * @param integer ID
     */
       function setId($id)
       {
         $this->_id = $id;
         $this->_result = null;
       }

       function getConfig() {
           $db = & $this->getDBO();
           $sql = 'SELECT * FROM #__jobboard_config
                      WHERE id = ' . $this->_id . '';
           $db->setQuery($sql);
           $this->_result = $db->loadObject();
           return $this->_result;
       }

       function getDepts() {
           $db = & $this->getDBO();
           $sql = 'SELECT * FROM #__jobboard_departments';
           $db->setQuery($sql);
           $this->_result = $db->loadObjectlist();
           return $this->_result;
       }

       function getCountries() {
           $db = & $this->getDBO();
           $sql = 'SELECT country_id, country_name FROM #__jobboard_countries';
           $db->setQuery($sql);
           $this->_result = $db->loadObjectlist();
           return $this->_result;
       }

       function getJobtypes() {
           $db = & $this->getDBO();
           $sql = 'SELECT id, type FROM #__jobboard_types';
           $db->setQuery($sql);
           $this->_result = $db->loadObjectlist();
           return $this->_result;
       }

       function getCareers() {
           $db = & $this->getDBO();
           $sql = 'SELECT * FROM #__jobboard_career_levels';
           $db->setQuery($sql);
           $this->_result = $db->loadObjectlist();
           return $this->_result;
       }

       function getEdu() {
           $db = & $this->getDBO();
           $sql = 'SELECT * FROM #__jobboard_education';
           $db->setQuery($sql);
           $this->_result = $db->loadObjectlist();
           return $this->_result;
       }

       function getCategories() {
           $db = & $this->getDBO();
           $sql = 'SELECT * FROM #__jobboard_categories';
           $db->setQuery($sql);
           $this->_result = $db->loadObjectlist();
           return $this->_result;
       }
}

?>