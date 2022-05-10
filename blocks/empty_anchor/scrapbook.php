<?php

defined('C5_EXECUTE') or die('Access Denied.');

/**
 * @var Concrete\Core\Block\View\BlockView $view
 * @var string $anchorName
 */

?>
<div style="transform: scale(2.2); transform-origin: top left;">
    <?php
    $view->inc('view.php', ['isPageInEditMode' => true]);
    ?>
</div>
