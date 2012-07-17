<?php
/**
* @package Admin-User-Access (mod_admin_user_access_frontend)
* @version 2.1.2
* @copyright Copyright (C) 2007-2008 Carsten Engel. All rights reserved.
* @license GPL available versions: free, trial and pro
* @author http://www.pages-and-items.com
* @joomla Joomla is Free Software
*/

//no direct access
if(!defined('_VALID_MOS') && !defined('_JEXEC')){
	die('Restricted access');
}

if(!defined('class_mod_aua_defined')){

	//ensure that is only called and used once
	define( 'class_mod_aua_defined', 1 );

	class class_mod_aua{
	
		var $user_id;
		var $user_type;
		var $id;
		var $Itemid;
		var $path_to_root;
		var $db;
		var $ua_config;
		var $framework;
		var $class_ua;
	
		//constructor
		function class_mod_aua(){		
			
			//get more vars
			if(defined('_JEXEC')){
				//joomla 1.5
				$user =& JFactory::getUser();			
				$this->user_id = $user->get('id');
				$this->user_type = $user->get('usertype');
				$this->view = JRequest::getVar('view', '');					
				$this->id = JRequest::getVar('id', '');	
				if(strpos($this->id, ':')){
					$pos_item_id = strpos($this->id, ':');
					$this->id = intval(substr($this->id, 0, $pos_item_id));	
				}			
				$this->path_to_root = '/../../';	
				$this->framework = '1.5.x';
				$this->db = JFactory::getDBO();	
			}else{
				//joomla 1.0.x			
				$this->user_id = $my->id;				
				$this->user_type = $my->usertype;
				$this->view = mosGetParam( $_REQUEST, 'view', '' );					
				$this->id = mosGetParam( $_REQUEST, 'id', '' );
				$this->Itemid = mosGetParam( $_REQUEST, 'Itemid', '' );	
				$this->path_to_root = '/../';	
				$this->framework = '1.0.x';
				global $database;
				$this->db = $database;				
			}	
			
			require_once(dirname(__FILE__).$this->path_to_root.'administrator/components/com_pi_admin_user_access/class.php');	
			$this->class_ua = new class_ua();		
			$this->ua_config = $this->class_ua->get_config();
			
				
		}
			
		function mod_admin_user_access() {		
			
			//get vars
			if( defined('_JEXEC') ){
				//joomla 1.5			
				$option = JRequest::getVar('option', '');		
				$task = JRequest::getVar('task', '');
				$layout = JRequest::getVar('layout', '');			
			}else{
				//joomla 1.0.x			
				$option = mosGetParam( $_REQUEST, 'option', '' );
				$task = mosGetParam( $_REQUEST, 'task', '' );					
			}
			
			//only if something is being editted
			if(($this->framework=='1.5.x' && 
			//com_content
			($option=='com_content' && ($task=='edit' || $layout=='form' || $task=='new')) ||
			//com_weblinks
			($option=='com_weblinks' && $layout=='form')
			) ||
			$this->framework=='1.0.x' && 
			//com_content
			($option=='com_content' && ($task=='new' || $task=='edit')) ||
			//com_weblinks
			($option=='com_weblinks' && $task=='new')
			){
				
				
				global $my;
				
				//get more vars
				if(defined('_JEXEC')){
					//joomla 1.5
					$user =& JFactory::getUser();			
					$user_id = $user->get('id');
					$user_type = $user->get('usertype');
					$view = JRequest::getVar('view', '');					
								
				}else{
					//joomla 1.0.x			
					$user_id = $my->id;				
					$user_type = $my->usertype;
					$view = mosGetParam( $_REQUEST, 'view', '' );				
					$Itemid = mosGetParam( $_REQUEST, 'Itemid', '' );						
				}	
				
				//only do restrictions when not super-administrator
				if($user_type!='Super Administrator'){				
					
					//get usergroup					
					$this->db->setQuery("SELECT group_id FROM #__pi_aua_userindex WHERE user_id='$user_id' LIMIT 1 ");		
					$rows_group = $this->db->loadObjectList();			
					$row_group = $rows_group[0];
					$usergroup = $row_group->group_id;		
					
					//check item new 
					//frontend workflow			
					if(($this->framework=='1.5.x' && $option=='com_content' && $view=='article' && $layout=='form') ||
					($this->framework=='1.0.x' && $option=='com_content' && $task=='new')
					){	
						
						$this->check_access_item_frontend($usergroup, 'new');				
					}
					
					//check item new when in section list
					if($this->framework=='1.5.x' && $option=='com_content' && $task=='new'){								
						$this->check_access_item_frontend($usergroup, 'new');					
					} 
					
					//check item edit 
					//frontend workflow
					if(($this->framework=='1.5.x' && $option=='com_content' && $view=='article' && $task=='edit') ||
					($this->framework=='1.0.x' && $option=='com_content' && $task=='edit')
					){				
										
						//$this->check_item_access($usergroup);
						$this->check_access_item_frontend($usergroup, 'edit');
					}
					
					
					
					
				}//end if no-super-admin
			}//end if do something			
		}//end bot function
		
		
		
		function check_workflow($right, $usergroup){		
			
			
					return true;
				
		}
		
		function check_item_access($usergroup){		
					
			
			
			
		}
		
		function unlock_item($item_id){
			$this->db->setQuery( "UPDATE #__content SET checked_out='0', checked_out_time='0' WHERE id='$item_id' "	);
			$this->db->query();
		}
		
		
		
		function do_alert($message){
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script>alert('".addslashes(html_entity_decode($message))."'); window.history.go(-1); </script>";
			exit('<html><body><noscript>'.$message.'</noscript></body></html>');
		}	
		
		
		
		function check_access_item_frontend($usergroup, $new_or_edit){		
		
			
			
				
			//if page access or category access restrictions are activated
			if(($this->ua_config['active_pagesaccess'] || $this->ua_config['active_categories'])){				
				
				if($this->ua_config['com_content_access']=='page_access'){
					//if category access is checked with page-access
					
					//get page access data
					$this->db->setQuery("SELECT pageid_usergroupid FROM #__pi_aua_access_pages");
					$pages_access_rights = $this->db->loadResultArray();		
						
					//make array of pages which user has access to		
					$user_page_access_array = '';
					$first = true;		
					for($n = 0; $n < count($pages_access_rights); $n++){
						$right = $pages_access_rights[$n];			
						$right = explode('_', $right);			
						if($right[1]==$usergroup){				
							if(!$first){
								$user_page_access_array .= ',';				
							}
							$user_page_access_array .= $right[0];
							if($first){
								$first = false;					
							}
						}
					}	
					
					//check page access	if edit item
					if($new_or_edit=='edit'){			
						if( defined('_JEXEC') ){
							//joomla 1.5
							$page_id = JRequest::getVar('Itemid', '');			
						}else{
							//joomla 1.0.x
							$page_id = mosGetParam( $_REQUEST, 'Itemid', '' );			
						}		
						$temp = explode(',',$user_page_access_array);		
						if(!in_array($page_id,$temp)){
														
							$item_id = $this->id;
							//unlock item	
							$this->unlock_item($item_id);				
							$message = JText::_('MOD_ADMIN_USER_ACCESS_FRONTEND_NO_PAGE_ITEM_ACCESS');									
							$this->do_alert($message);	
						}
					}
					//print_r( $temp);
					//echo $page_id;
					
					//get page data
					$this->db->setQuery("SELECT id, link, componentid, type FROM #__menu WHERE id in ($user_page_access_array)");
					$all_menuitems = $this->db->loadObjectList();		
					
					$all_menuitems_with_categories = array();
					//make a new array from all categories which are used as category-blog-pages in menu
					foreach($all_menuitems as $menuitem){
						if(((strstr($menuitem->link, 'index.php?option=com_content&view=category&layout=blog') && $menuitem->type=='url') || !strstr($menuitem->link, 'index.php?option=com_content&view=category&layout=blog')) && $menuitem->type!='content_blog_category'){
							//something else	
						}else{
							//category-blog-page
							array_push($all_menuitems_with_categories, $menuitem->id);		
						}
					}		
					
					//get categories from menuitems
					$all_categories_access = array();		
					foreach($all_menuitems as $menuitem){
						if(in_array($menuitem->id,$all_menuitems_with_categories)){			
							if(defined('_JEXEC')){
								//joomla 1.5
								$cat_id = str_replace('index.php?option=com_content&view=category&layout=blog&id=','',$menuitem->link);				
							}else{	
								//joomla 1.0.x
								$cat_id = $menuitem->componentid;				
							}
							array_push($all_categories_access, $cat_id);				
						}							
					} 	
					
					//end if category access is checked with page-access
				}elseif($this->ua_config['com_content_access']=='category_access' && $this->ua_config['active_categories']){
					//category access is checked with category-access
					
					//get category access data
					$this->db->setQuery("SELECT category_groupid FROM #__pi_aua_categories");
					$category_access_rights = $this->db->loadResultArray();
					
					//print_r($category_access_rights);
					
					//clean item_id									
					$item_id = $this->id;	
									
					//check category access right, only when editting
					if($new_or_edit=='edit'){
					
						//get category from id
						//get items cat id		
						$this->db->setQuery("SELECT catid FROM #__content WHERE id='$item_id' LIMIT 1 ");
						$rows = $this->db->loadResultArray();
						$cat_id = $rows[0];
						
						//echo 'catid='.$cat_id;
						//echo 'item_id='.$item_id;
						//echo 'new-or-edit=='.$new_or_edit;
						
						$category_right = $cat_id.'__'.$usergroup;				
					
						//echo $section_right;
						
						//if user has no item-access-permission
						if(!in_array($category_right, $category_access_rights)){		
												
								
							//unlock item	
							$this->unlock_item($item_id);			
							$message = JText::_('MOD_ADMIN_USER_ACCESS_FRONTEND_NO_CATEGORY_ITEM_ACCESS');									
							$this->do_alert($message);														
						}	
					
					}
					
					//get categories
					$this->db->setQuery("SELECT id FROM #__categories");
					$all_categories = $this->db->loadResultArray();	
								
					//make array from categories which user has access to
					$all_categories_access = array();		
					for($n = 0; $n < count($category_access_rights); $n++){
						$right = $category_access_rights[$n];			
						$right = explode('__', $right);			
						if($right[1]==$usergroup){
							array_push($all_categories_access, $right[0]);
						}
					}
				
					//end if category access is checked with category-access
				}	
				
				
				echo '<script language="javascript" type="text/javascript">'."\n";			
				
				//make javascript array of categories which user has access to
				$javascript_array_category_access = 'var categories_with_access = new Array(';		
				$first = true;	
				foreach($all_categories_access as $category){
					if($first){
						$first = false;
					}else{
						$javascript_array_category_access .= ',';
					}			
					$javascript_array_category_access .= '"'.$category.'"';
				}		
				$javascript_array_category_access .= ');';
				echo $javascript_array_category_access."\n\n";		
					
				//javascript in_array function
				echo 'Array.prototype.in_array = function (element){'."\n";
					echo 'var retur = false;'."\n";
					echo 'for (var values in this){'."\n";
						echo 'if (this[values] == element){'."\n";
							echo 'retur = true;'."\n";
							echo 'break;'."\n";
						echo '}'."\n";
					echo '}'."\n";
					echo 'return retur;'."\n";
				echo '};'."\n\n"; 
				
				if( defined('_JEXEC') ){
					//joomla 1.5
						
					//javascript function to rip categories out of category-array of dynamic select
					echo 'function filter_categories(){'."\n";			
						//echo 'if(document.adminForm.catid){'."\n";	
						
						//if edit get selected cat
						if($new_or_edit=='edit'){			
							echo 'var selected_category = document.adminForm.catid.value;'."\n";	
							//echo 'alert(selected_category);'."\n";						
						}			
						
						//take categories out of array
						echo 'for (i = 0; i < sectioncategories.length; i++){'."\n";											
							echo 'if(!categories_with_access.in_array(sectioncategories[i][1])){'."\n";								
								echo 'sectioncategories.splice(i,1);'."\n";														
								echo 'i = i-1;'."\n";																	
							echo '}'."\n";																	
						echo '}'."\n";
						
						if($new_or_edit=='edit'){
						
							//refresh category select by changing the section select and back again
							echo 'var selected_section = document.adminForm.sectionid.selectedIndex;'."\n";
							echo 'changeDynaList("catid", sectioncategories, document.adminForm.sectionid.options[0].value, 0, 0);'."\n";
							echo 'changeDynaList("catid", sectioncategories, document.adminForm.sectionid.options[selected_section].value, 0, 0);'."\n";				
							
							//select the category innitialy selected	
							echo 'if(selected_category){'."\n";								
								echo 'for(index = 0; index < document.adminForm.catid.length; index++){'."\n";	
									echo 'if(document.adminForm.catid[index].value == selected_category){'."\n";	
										echo 'document.adminForm.catid.selectedIndex = index;'."\n";	
									echo '}'."\n";	
								echo '}'."\n";							
							echo '}'."\n";
							
						}//end if edit page
						
						if($new_or_edit=='new'){
							//set section select to default 0 so the categories get reloaded when the new section is choosen					
							echo 'document.getElementById("sectionid").options[0].selected = true;'."\n";
						}
						
					echo '}'."\n\n";//end function
						
				}else{
					//joomla 1.0.x
					
					//javascript function to filter categories out of select
					echo 'function filter_categories(){'."\n";			
						echo "var elSel = document.adminForm.catid;\n";				
						echo 'var i;'."\n";			
						echo 'for (i = elSel.length - 1; i>=0; i--){'."\n";							
								echo 'if(!categories_with_access.in_array(elSel.options[i].value)){'."\n";								
									echo 'elSel.remove(i);'."\n";										
								echo '}'."\n";							
						echo '}'."\n";		
					echo '}'."\n";	
					
				}//end if joomla 1.0.x		
							
																		
					
				
				//call onload event
				echo 'if(window.addEventListener)window.addEventListener("load",filter_categories,false);'."\n";
				echo 'else if(window.attachEvent)window.attachEvent("onload",filter_categories);'."\n";
				
				echo '</script>';
			
			}//end if page access
			
			
		
			
			
			
		}//end item frontend
		
		
	
	
	}
	$class_object = new class_mod_aua();
	$class_object->mod_admin_user_access();
}

?>