<?php

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Page\Page;

/** @var int $duration */
/** @var string $description */
/** @var int $value */

$c = Page::getCurrentPage();

?>

<?php if ($c instanceof Page && $c->isEditMode()): ?>
    <div class="ccm-edit-mode-disabled-item">
        <?php echo t('Counter is disabled in edit mode.') ?>
    </div>
<?php else: ?>

    <div class="counter-container" data-duration="<?php echo h($duration); ?>">
        <div class="counter">
            <h2 class="counter-value" data-target-value="<?php echo h($value); ?>">
                0
            </h2>

            <p>
                <?php echo $description; ?>
            </p>
        </div>
    </div>

<?php endif; ?>