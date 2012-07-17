<?php
/**
 * @package JobBoard
 * @copyright Copyright (c)2010 Tandolin
 * @license GNU General Public License version 2, or later
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JobboardModelJob extends JModel
{
	var $_total;
    var $_id;
	var $_query;
	var $_data;

	function __construct()
	{
		parent::__construct();

	    $cid = JRequest::getVar('cid', false, 'DEFAULT', 'array');
        if($cid){
          $id = $cid[0];
        }
        else $id = JRequest::getInt('id', 0);
        $this->setId($id);
	}

    function setId($id=0)
    {
      $this->_id = $id;
      $this->_query = null;
      $this->_data = null;
      $this->_total = null;
    }

	function getJob()
	{

		if(empty($this->_data))
		{
            $db = JFactory::getDBO();
			$this->_query = 'SELECT j.post_date
					  , j.expiry_date
                      , j.job_title
                      , j.job_type
                      , j.country
                      , j.salary
                      , c.id AS catid
                      , c.type AS category
                      , jc.country_name
                      , jc.country_region
                      , cl.description AS job_level
                      , j.id AS job_id
                      , j.description
                      , j.positions
                      , j.city
                      , j.num_applications
                      , j.hits
                      , e.level AS education
                  FROM
                      #__jobboard_jobs AS j
                      INNER JOIN #__jobboard_categories  AS c
                          ON (j.category = c.id)
                      INNER JOIN #__jobboard_career_levels AS cl
                          ON (j.career_level = cl.id)
                      INNER JOIN #__jobboard_education AS e
                          ON (e.id = j.education)
                      INNER JOIN #__jobboard_countries AS jc
                          ON (j.country = jc.country_id)
                      WHERE j.id = ' . $this->_id;
            $db->setQuery($this->_query);
            $this->_data = $db->loadObject();
		}

		return $this->_data;
	}

    function update($data) {
        $db = JFactory::getDBO();
		$this->_query = "UPDATE #__jobboard_applicants
                     SET email ='".$data->email."'
                     , tel ='".$data->tel."'
                 WHERE id=".$data->id;
        $db->setQuery($this->_query);
        return $db->query();
    }

    function save($job) {
       $db =& $this->getDBO();
		$this->_query = "UPDATE ".$db->nameQuote('#__jobboard_jobs')."
                     SET ".$db->nameQuote('job_title')."=".$db->Quote($job->job_title)."
                     , ".$db->nameQuote('expiry_date')."='".$job->expiry_date."'
                     , ".$db->nameQuote('job_type')." =".$db->Quote($job->job_type)."
                     , ".$db->nameQuote('category')." =".$db->Quote($job->category)."
                     , ".$db->nameQuote('career_level')." =".$db->Quote($job->career_level)."
                     , ".$db->nameQuote('education')." =".$db->Quote($job->education_level)."
                     , ".$db->nameQuote('positions')." =".$db->Quote($job->positions)."
                     , ".$db->nameQuote('country')." =".$db->Quote($job->country_name)."
                     , ".$db->nameQuote('department')." =".$db->Quote($job->department)."
                     , ".$db->nameQuote('published')." =".$db->Quote($job->published)."
                     , ".$db->nameQuote('city')." =".$db->Quote($job->city)."
                     , ".$db->nameQuote('salary')." =".$db->Quote($job->salary)."
                     , ".$db->nameQuote('description')." =".$db->Quote($job->job_description)."
                     , ".$db->nameQuote('duties')." =".$db->Quote($job->duties)."
                     , ".$db->nameQuote('job_tags')." =".$db->Quote($job->job_tags)."
                 WHERE  ".$db->nameQuote('id')."=".intval($job->id);
        $db->setQuery($this->_query);
        return $db->query();
    }
    function savenew($job) {
       $db =& $this->getDBO();
		$this->_query = "INSERT INTO #__jobboard_jobs
                    (post_date, job_title, expiry_date, job_type, category, career_level, education, positions, country, department, published, city, salary, description, duties, job_tags)
                     VALUES (UTC_TIMESTAMP, '".$db->getEscaped($job->job_title, true)."'
                     , '".$db->getEscaped($job->expiry_date, true)."'
                     , '".$job->job_type."'
                     , ".$db->getEscaped($job->category, true)."
                     , ".$db->getEscaped($job->career_level, true)."
                     , ".$db->getEscaped($job->education_level, true)."
                     , ".$db->getEscaped($job->positions, true)."
                     , ".$db->getEscaped($job->country_name, true)."
                     , ".$db->getEscaped($job->department, true)."
                     , ".$db->getEscaped($job->published, true)."
                     , '".$db->getEscaped($job->city, true)."'
                     , '".$db->getEscaped($job->salary, true)."'
                     , '".$db->getEscaped($job->job_description, true)."'
                     , '".$db->getEscaped($job->duties, true)."'
                     , '".$db->getEscaped($job->job_tags, true)."'
                 )";
        $db->setQuery($this->_query);
        return $db->query();
    }

}
?>