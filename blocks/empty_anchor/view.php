<?php

defined('C5_EXECUTE') or die('Access denied.');

/**
 * @var bool $isPageInEditMode
 * @var string $anchorName
 * @var int $offsetY
 */

if ($isPageInEditMode) {
    ?>
    <span><i class="fas fa fa-anchor"></i> <?= h($anchorName)?></span>
    <?php
} else {
    $htmlAnchorName = h($anchorName);
    echo '<a name="', $htmlAnchorName, '" id="', $htmlAnchorName, '" style="width:0!important;height:0!important;opacity:0!important;';
    if ($offsetY !== 0) {
        echo "position:relative;top:{$offsetY}px;"; 
    }
    echo '"></a>';
}
