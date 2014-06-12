<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/notifications/tmpl/default.php            //
// @implements  :                                                       //
// @description : Template for the Notifications-List-View              //
// Version      : 2.1.0                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC')or die('Restricted access');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
$saveOrder	= $this->listOrder == 'ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_jtodo&task=notifications.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($this->listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_jtodo&view=notifications'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_JTODO_ITEMS_SEARCH_FILTER_DESC');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('COM_JTODO_ITEMS_SEARCH_FILTER'); ?>" />
			</div>
			<div class="btn-group pull-left">
				<button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
			</div>
      <div name="pagination_limiter" id="pagination_limiter" class="btn-group pull-right">
         <?php echo $this->pagination->getLimitBox(); ?>
      </div>
	</div>
    <div class="clearfix"> </div>

		<table class="table table-striped" id="articleList">
        <thead>
            <tr>
				<th width="1%" class="nowrap center hidden-phone">
					<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $this->listDirn, $this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
				</th>
				<th width="1%" class="hidden-phone">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_CATEGORY', 'category', $this->listDirn, $this->listOrder); ?>
                </th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_TODO_JUSER', 'username', $this->listDirn, $this->listOrder); ?>
                </th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_REALNAME', 'name', $this->listDirn, $this->listOrder); ?>
                </th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_EMAIL', 'email', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="5%" align="center">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_PUBLISHED', 'published', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="5">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_ID', 'id', $this->listDirn, $this->listOrder); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($this->items as $i => $item) :
                $link = JRoute::_( 'index.php?option=com_jtodo&task=notification.edit&id='.(int)$item->id );
                ?>
					<tr class="row<?php echo $i % 2; ?>" sortable-group-id="1">
						<td class="order nowrap center hidden-phone">
							<?php
							$iconClass = '';
							if (!$saveOrder)
							{
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							}
							?>
							<span class="sortable-handler<?php echo $iconClass ?>">
								<i class="icon-menu"></i>
							</span>
							<?php if ($saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5"
									value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php endif; ?>
						</td>
                        <td><?php echo JHTML::_('grid.id', $i, $item->id); ?></td>
                        <td><a href="<?php echo $link; ?>"><?php echo $item->category; ?></a></td>
                        <td><a href="<?php echo $link; ?>"><?php echo $item->username; ?></a></td>
                        <td><a href="<?php echo $link; ?>"><?php echo $item->name; ?></a></td>
						<td><a href="<?php echo $link; ?>"><?php echo $item->email; ?></a></td>
                        <td class="center"><?php echo JHTML::_('jgrid.published', $item->published, $i, 'notifications.' ); ?></td>
						<td><?php echo $item->id; ?></td>
                    </tr>

                <?php
                endforeach;
            ?>
        <tbody>
        <tfoot>
            <tr>
                <td colspan="10">
                    <?php echo $this->pagination->getListFooter()
                               .'<br>'
                               . $this->pagination->getResultsCounter();
                    ?>
                    <p>
                    <center>jToDo  v<?php echo _jTODO_VERSION; ?></center>
                    <center>Copyright &copy; 2012-<?php echo date('Y', time() )?> by Hanjo Hingsen, Webmaster of  <a href="http://www.treu-zu-kaarst.de">http://www.treu-zu-kaarst.de</a>, All Rights reserved</center>
                </td>
            </tr>
        </tfoot>
    </table>
    <div>
        <input type="hidden" name="task"             value = "" />
        <input type="hidden" name="boxchecked"       value = "0" />
        <input type="hidden" name="filter_order"     value = "<?php echo $this->listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value = "<?php echo $this->listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
