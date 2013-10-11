<?php// *************************************************************************//// Project      : jTODO for Joomla                                          //// @package     : com_jtodo                                                 //// @file        : /admin/controllers/todos.php                              //// @implements  : Class jTODOControllerToDos                                //// @description : Controller for editing the Todo-List                      //// Version      : 1.0.6                                                     //// *************************************************************************//// No direct access.defined('_JEXEC') or die; jimport('joomla.application.component.controlleradmin'); // Eventlist controller class.class jTODOControllerToDos extends JControllerAdmin{	// constructor (registers additional tasks to methods)	// @return void	function __construct()	{		parent::__construct();		// Register Extra tasks		$this->registerTask( 'tagAsDone'    , 'setDoneStatus');		$this->registerTask( 'tagAsNotDone' , 'setDoneStatus');    }    	/**	 * Proxy for getModel.	 * @since	1.6	 */	public function getModel($name = 'ToDo', $prefix = 'jTODOModel', 							 $config = array('ignore_request' => true))	{		$model = parent::getModel($name, $prefix, $config);		return $model;	}	      public function setDoneStatus()    {		// Check for request forgeries		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));		// Get items to publish from the request.		$cid = JRequest::getVar('cid', array(), '', 'array');		if (empty($cid))		{			JError::raiseWarning(500, JText::_($this->text_prefix . '_NO_ITEM_SELECTED'));		}		else		{			// Get the model.			$model = $this->getModel();			// Make sure the item ids are integers			JArrayHelper::toInteger($cid);            $task = $this->getTask();                        if ($task=='tagAsDone')            {                // tag the items as DONE.                if (!$model->setItemDoneStatus($cid, 1))                {                    JError::raiseWarning(500, $model->getError());                }            } else {                // tag the items as NOT DONE.                if (!$model->setItemDoneStatus($cid, 0))                {                    JError::raiseWarning(500, $model->getError());                }            }        }        $this->setRedirect(JRoute::_('index.php?option=com_jtodo&view=todos', false));    }}