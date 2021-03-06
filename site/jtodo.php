<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : site/jtodo.php (Joomla-Entry-File)                    //
// @implements  :                                                       //
// @description : Main-Frontend-Entry-File for the jToDo-Component      //
// Version      : 2.1.3                                                 //
// *********************************************************************//

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
define('_JTODO_VERSION','2.1.3');

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by jtodo
$controller = JControllerLegacy::getInstance('jtodo');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

?>
