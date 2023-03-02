<?php

defined('_JEXEC') or die;

function modChrome_default($module, &$params, &$attribs) {
  if (!empty($module->content)) {
    echo $module->content;
  }
}