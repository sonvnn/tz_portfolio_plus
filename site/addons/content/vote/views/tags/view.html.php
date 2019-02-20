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

// No direct access.
defined('_JEXEC') or die;

class PlgTZ_Portfolio_PlusContentVoteViewTags extends JViewLegacy{
    protected $item     = null;
    protected $params   = null;
    protected $audio    = null;
    protected $head     = false;

    public function display($tpl = null){
        $this -> item   = $this -> get('Item');
        $state          = $this -> get('State');
        $params         = $state -> get('params');
        $this -> params = $params;

        if(!isset($this -> head['display'])){
            $this -> head['display']    = false;
        }
        if(!isset($this -> head['layout_'.$this -> getLayout()])){
            $this -> head['layout_'.$this -> getLayout()]    = false;
        }

        if(!$this -> head['display']) {
            $this -> document -> addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/css/ns-default.min.css',
                array('version' => 'auto'));

            switch ($params -> get('ct_vote_notice_layout', 'growl')){

                case 'growl':
                    $this -> document -> addStyleSheet(TZ_Portfolio_PlusUri::root(true)
                        . '/css/ns-style-growl.min.css', array('version' => 'auto'));
                    break;
                case 'attached':
                    $this -> document -> addStyleSheet(TZ_Portfolio_PlusUri::root(true)
                        . '/css/ns-style-attached.min.css', array('version' => 'auto'));
                    break;
                case 'bar':
                    $this -> document -> addStyleSheet(TZ_Portfolio_PlusUri::root(true)
                        . '/css/ns-style-bar.min.css', array('version' => 'auto'));
                    break;
                case 'other':
                    $this -> document -> addStyleSheet(TZ_Portfolio_PlusUri::root(true)
                        . '/css/ns-style-other.min.css', array('version' => 'auto'));
                    break;
            }

            $this -> document -> addScript(TZ_Portfolio_PlusUri::root(true) . '/js/modernizr.custom.js',
                array('version' => 'auto', 'relative' => true));
            $this -> document -> addScript(TZ_Portfolio_PlusUri::root(true) . '/js/classie.min.js',
                array('version' => 'auto', 'relative' => true));
            $this -> document -> addScript(TZ_Portfolio_PlusUri::root(true) . '/js/notificationfx.min.js',
                array('version' => 'auto', 'relative' => true));

            $this -> document -> addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/addons/content/vote/css/vote.css',
                array('version' => 'auto'));


            $this -> document -> addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/vote/js/vote.min.js',
                array('version' => 'auto', 'relative' => true));

            $this -> head['display']   = true;
        }

        parent::display($tpl);
    }
}