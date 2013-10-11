<?php 
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : site/views/jtodo/tmpl/default.php                     //
// @implements  :                                                       //
// @description : Entry-File for the jToDo-Standard-View                //
// Version      : 1.0.3                                                 //
// *********************************************************************//

//Aufruf nur durch Joomla! zulassen
defined('_JEXEC')or die('Restricted access'); 
// get document to add scripts or StyleSheets
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jtodo/assets/css/jtodo.css');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?> 
<div>
    <?php
    if ( $this->params->get('show_logo') == 1) 
    {
        echo '<img style="float:right;" src="' . $this->baseurl . '/media/com_jtodo/images/logos/' . $this->params->get('logo_image') . '" alt="" title=""/>';
    }
    if ( $this->params->get('show_page_heading') == 1) 
    {
        if ($this->params->get('show_logo') == 1) 
        {
            echo '<h1  style="float:left; margin-top:70px;">' . $this->params->get('page_heading') .'</h1>';
        } else {
            echo '<h1  style="float:left;">' . $this->params->get('page_heading') .'</h1>';
        }
    echo '<p style="clear:both;"></p>';
    echo '<p style="float:left;">' . $this->project->preamble . '</p>';
    }    
    ?>
</div>
<div class="page_body"> 
<?php  
    $user    = JFactory::getUser(); 
  	$isGuest = $user->guest;
    $language = $user->getParam('language', 'de-DE');
	$now = date('Y-m-d', time() );
    
    // Nur Besuche von registrierten Usern merken - von G�sten ergibt das keinen Sinn
    if (!$isGuest){
        $this->setLastVisitTimestamp($user, $now);
    };
 ?>    
    
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="siteForm">

    <?php
    foreach($this->categories as $i => $category) : 
        echo "<h2 align=\"left\">$category->name</h2>"
    ?>
        <table class="adminlist">
            <thead>
                <tr>
                    <th width="5%" align="left">
                        <?php // echo JText::_('COM_JTODO_STATUS'); ?>
                   </th>
                    <th  width="90%" align="left">
                        <?php echo JText::_( 'COM_JTODO_TODO' ); ?>
                    </th>
                    <th width="5%" align="center">
                        <?php echo JText::_('COM_JTODO_TARGETDATE'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php  
                foreach($this->todos as $i => $item) : 
                if ($category->id == $item->fk_category) {
                    $link = JRoute::_( 'index.php?option=com_jtodo&task=jtodo.submit&id='.(int)$item->id );
                    ?>
                        <tr  class="HiliteMe_future">
                            <td align="left"><?php echo $this->getStatusImage( $item->status, $link, $isGuest ); ?></td>
                            <td><?php echo $item->name; ?></td>
                            <td align="center"><?php echo JHTML::_('date', $item->targetdate,   JText::_('COM_JTODO_DATE_FORMAT_1'), 'UTC');?></td>
                        </tr>
                    <?php 
                }
                endforeach; 
                ?>
            <tbody>
        </table> 
    <?php 
    endforeach; 
    ?>
    <div>
        <input type="hidden" name="task"             value = "" />
        <input type="hidden" name="boxchecked"       value = "0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>

<br><br>        
<center>jToDo (ToDo-List for Joomla) v<?php echo _JTODO_VERSION; ?></center>
<center>Copyright &copy; <?php echo date('Y', time() )?> by Hanjo Hingsen, Webmaster of  <a href="http://www.treu-zu-kaarst.de">http://www.treu-zu-kaarst.de</a>, All Rights reserved</center>
</div>