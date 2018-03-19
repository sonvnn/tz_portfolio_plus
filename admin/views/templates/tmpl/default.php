<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

//no direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('formbehavior.chosen', 'select');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$user		= JFactory::getUser();
$lang       = JFactory::getLanguage();
$lang -> load('com_installer');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<style>
    .tz_portfolio_plus-templates .thumbnail > img{
        max-width: 80px;
    }
</style>

<form action="index.php?option=com_tz_portfolio_plus&view=templates" method="post" name="adminForm"
      class="tz_portfolio_plus-templates"
      id="adminForm">
    <?php if(!empty($this -> sidebar) AND COM_TZ_PORTFOLIO_PLUS_JVERSION_COMPARE):?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this -> sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <?php else:?>
        <div id="j-main-container">
    <?php endif;?>

        <div class="tpContainer">
            <?php
            // Search tools bar
            echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
            ?>

            <?php if (empty($this->items)){ ?>
                <div class="alert alert-no-items">
                    <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                </div>
            <?php }else{ ?>

            <table class="table table-striped" id="templatesList">
                <thead>
                <tr>
                    <th width="1%">
                    </th>
                    <th class="col1template hidden-phone">
                        <?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_THUMBNAIL');?>
                    </th>
                    <th class="title">
                        <?php echo JHtml::_('searchtools.sort','COM_TZ_PORTFOLIO_PLUS_TEMPLATE_LABEL','name', $listDirn, $listOrder);?>
                    </th>
                    <th width="10%" class="nowrap center">
                        <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'published', $listDirn, $listOrder); ?>
                    </th>
                    <th class="nowrap center" width="10%">
                        <?php echo JText::_('JVERSION'); ?>
                    </th>
                    <th class="nowrap center" width="15%">
                        <?php echo JText::_('JDATE'); ?>
                    </th>
                    <th class="nowrap" width="25%">
                        <?php echo JText::_('JAUTHOR'); ?>
                    </th>
                    <th class="nowrap" width="1%">
                        <?php echo JHtml::_('searchtools.sort','JGRID_HEADING_ID','id', $listDirn, $listOrder);?>
                    </th>
                </tr>
                </thead>

                <?php if($this -> items):?>
                    <tbody>
                    <?php foreach($this -> items as $i => $item):

                        $canCreate = $user->authorise('core.create',     'com_tz_portfolio_plus.template');
                        $canCheckin = $user->authorise('core.manage',     'com_tz_portfolio_plus')
                            || $item->checked_out == $user->get('id') || $item->checked_out == 0;
                        $canChange = $user->authorise('core.edit.state', 'com_tz_portfolio_plus.template') && $canCheckin;

                    ?>
                        <tr class="<?php echo ($i%2==0)?'row0':'row1';?>">
                            <td class="center">
                                <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                            </td>
                            <td class="center hidden-phone">
                                <?php echo JHtml::_('templates.thumb', $item->name); ?>
                            </td>
                            <td class="nowrap has-context">
                                <div class="pull-left">
                                    <?php echo $item->name; ?>
                                </div>
                            </td>

                            <td class="center">
                                <div class="btn-group">
                                <?php
                                $states	= array(
                                    2 => array(
                                        '',
                                        'COM_INSTALLER_EXTENSION_PROTECTED',
                                        '',
                                        'COM_INSTALLER_EXTENSION_PROTECTED',
                                        true,
                                        'protected',
                                        'protected',
                                    ),
                                    1 => array(
                                        'unpublish',
                                        'COM_INSTALLER_EXTENSION_ENABLED',
                                        'COM_INSTALLER_EXTENSION_DISABLE',
                                        'COM_INSTALLER_EXTENSION_ENABLED',
                                        true,
                                        'publish',
                                        'publish',
                                    ),
                                    0 => array(
                                        'publish',
                                        'COM_INSTALLER_EXTENSION_DISABLED',
                                        'COM_INSTALLER_EXTENSION_ENABLE',
                                        'COM_INSTALLER_EXTENSION_DISABLED',
                                        true,
                                        'unpublish',
                                        'unpublish',
                                    ),
                                );

                                echo JHtml::_('jgrid.state', $states, $item->published, $i, 'templates.', $canChange, true, 'cb');
                                if($item ->protected) {
                                    echo JHtml::_('jgrid.state', $states, 2, $i, 'template.', false, true, 'cb');
                                }
                                ?>
                                </div>
                            </td>
                            <td class="center hidden-phone">
                                <?php echo @$item -> version != '' ? $item -> version : '&#160;';?>
                            </td>
                            <td class="center hidden-phone">

                                <?php echo @$item-> creationDate != '' ? $item-> creationDate : '&#160;'; ?>
                            </td>
                            <td class="hidden-phone">
                                <?php if ($author = $item-> author) : ?>
                                    <p><?php echo $this->escape($author); ?></p>
                                <?php else : ?>
                                    &mdash;
                                <?php endif; ?>
                                <?php if ($email = $item->authorEmail) : ?>
                                    <p><?php echo $this->escape($email); ?></p>
                                <?php endif; ?>
                                <?php if ($url = $item->authorUrl) : ?>
                                    <p><a href="<?php echo $this->escape($url); ?>">
                                            <?php echo $this->escape($url); ?></a></p>
                                <?php endif; ?>
                            </td>

                            <td align="center hidden-phone"><?php echo $item -> id;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                <?php endif;?>

                <tfoot>
                <tr>
                    <td colspan="11">
                        <?php echo $this -> pagination -> getListFooter();?>
                    </td>
                </tr>
                </tfoot>

            </table>
            <?php } ?>

            <input type="hidden" name="task" value="">
            <input type="hidden" name="boxchecked" value="0">
            <?php echo JHtml::_('form.token');?>

        </div>
    </div>
</form>