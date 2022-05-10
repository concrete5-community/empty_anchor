<?php

defined('C5_EXECUTE') or die('Access denied.');

/**
 * @var Concrete\Core\Form\Service\Form $form
 *
 * @var string $rxValidID
 * @var int $idMaxLength
 * @var string $validAnchorMessage
 * 
 * @var string $anchorName
 *
 */
?>
<div class="form-group">
    <?= $form->label('anchorName', t('Anchor Name')) ?>
    <?= $form->text('anchorName', $anchorName, ['required' => 'required', 'maxlength' => $idMaxLength, 'pattern' => $rxValidID]) ?>
    <div class="small text-muted">
        <?= nl2br(h($validAnchorMessage))?>
    </div>
</div>
