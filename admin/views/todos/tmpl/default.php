<?php
// *********************************************************************//
// Project      : jTODO for Joomla                                      //
// @package     : com_jtodo                                             //
// @file        : admin/views/todos/tmpl/default.php                    //
// @implements  :                                                       //
// @description : Template for the ToDos-List-View                      //
// Version      : 2.0.2                                                 //
// *********************************************************************//

// Check to ensure this file is included in Joomla!
defined('_JEXEC')or die('Restricted access');
JHTML::_('behavior.multiselect');
JHtml::_('bootstrap.tooltip');
JHtml::_('formbehavior.chosen', 'select');

$saveOrder	= $this->listOrder == 'todos.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_jtodo&task=todos.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($this->listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();

?>
<form action="<?php echo JRoute::_('index.php?option=com_jtodo&view=todos'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php endif;?>
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
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_TODO', 'name', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="10%" class="nowrap center hidden-phone">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_TARGETDATE', 'targetdate', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="5%" class="nowrap center hidden-phone">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_PUBLISHED', 'published', $this->listDirn, $this->listOrder); ?>
               </th>
                <th width="5%" class="nowrap center hidden-phone">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_STATUS', 'status', $this->listDirn, $this->listOrder); ?>
               </th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_PROJECT', 'project', $this->listDirn, $this->listOrder); ?>
                </th>
                <th  class="title">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_CATEGORY', 'category', $this->listDirn, $this->listOrder); ?>
                </th>
                <th width="5">
                    <?php echo JHTML::_('grid.sort', 'COM_JTODO_ID', 'id', $this->listDirn, $this->listOrder); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
				$n = count($this->items);
                foreach($this->items as $i => $item) :
                $link           = JRoute::_( 'index.php?option=com_jtodo&task=todo.edit&cid[]='.(int)$item->id );
                $singleItemLink = JRoute::_( 'index.php?option=com_jtodo&task=todo.edit&id='.(int)$item->id );
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
							<span class="sortable-handler <?php echo $iconClass ?>">
								<i class="icon-menu"></i>
							</span>
							<?php if ($saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5"
									value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php endif; ?>
						</td>
						<td class="center hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
                        <td><a href="<?php echo $singleItemLink; ?>"><?php echo $item->name; ?></a></td>
                        <td class="center hidden-phone"><?php echo JHTML::_('date', $item->targetdate,   JText::_('DATE_FORMAT1'), 'UTC');?></td>
                        <td class="center hidden-phone"><?php echo JHTML::_('jgrid.published', $item->published, $i, 'todos.' ); ?></td>
                        <td class="center hidden-phone"><?php echo JHTML::_('jgrid.published', $item->status, $i, 'todos.setStatus_'); ?></td>
                        <td class="nowrap hidden-phone"><?php echo $item->project;?></td>
                        <td class="center hidden-phone"><?php echo $item->category;?></td>
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
	<?php //Load the batch processing form. ?>
	<?php echo $this->loadTemplate('batch'); ?>
    <div>
        <input type="hidden" name="task"             value = "" />
        <input type="hidden" name="boxchecked"       value = "0" />
        <input type="hidden" name="filter_order"     value = "<?php echo $this->listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value = "<?php echo $this->listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
