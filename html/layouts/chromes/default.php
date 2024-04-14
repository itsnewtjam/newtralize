<?php

defined('_JEXEC') or die;

$module = $displayData['module'];
$params = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content === null || $module->content === '') return;

$modulePos = $module->position;
$moduleTag = $params->get('module_tag', 'div');
?>

<<?= $moduleTag; ?> class="<?= htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8'); ?>" data-module="<?= $module->id; ?>">
  <?= $module->content; ?>
</<?= $moduleTag; ?>>
