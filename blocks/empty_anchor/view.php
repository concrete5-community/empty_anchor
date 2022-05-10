<?php

defined('C5_EXECUTE') or die('Access denied.');

/**
 * @var bool $isPageInEditMode
 * @var string $anchorName
 */

if ($isPageInEditMode) {
    ?>
    <span><i class="fas fa fa-anchor"></i> <?= h($anchorName)?></span>
    <?php
} else {
    echo '<a name="' . h($anchorName) . '" id="' . h($anchorName) . '" style="width:0!important;height:0!important;opacity:0!important;"></a>';
}
