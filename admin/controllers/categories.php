<?php// *************************************************************************//// Project      : jTODO for Joomla                                          //// @package     : com_jtodo                                                 //// @file        : /admin/controllers/categories.php                         //// @implements  : Class jTODOControllerCategories                           //// @description : Controller for editing the categories-List                //// Version      : 1.0.0                                                     //// *************************************************************************//// No direct access.defined('_JEXEC') or die; jimport('joomla.application.component.controlleradmin'); // Eventlist controller class.class jTODOControllercategories extends JControllerAdmin{	// constructor (registers additional tasks to methods)	// @return void	function __construct()	{		parent::__construct();    }    	/**	 * Proxy for getModel.	 * @since	1.6	 */	public function getModel($name = 'Category', $prefix = 'jTODOModel', 							 $config = array('ignore_request' => true))	{		$model = parent::getModel($name, $prefix, $config);        		return $model;	}	  }