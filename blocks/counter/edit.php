<?php

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Form\Service\Form;
use Concrete\Core\Support\Facade\Application;

/** @var int $duration */
/** @var string $description */
/** @var int $value */

$app = Application::getFacadeApplication();
/** @var Form $form */
/** @noinspection PhpUnhandledExceptionInspection */
$form = $app->make(Form::class);
?>

<div class="form-group">
    <?php echo $form->label("duration", t("Duration")); ?>
    
    <div class="input-group">
        <?php echo $form->number("duration", $duration, ["min" => 0, "class" => "form-control"]); ?>

        <div class="input-group-text">
            <?php echo t("ms"); ?>
        </div>
    </div>
</div>

<div class="form-group">
    <?php echo $form->label("value", t("Value")); ?>
    <?php echo $form->number("value", $value, ["min" => 0]); ?>
</div>

<div class="form-group">
    <?php echo $form->label("description", t("Description")); ?>
    <?php echo $form->text("description", $description); ?>
</div>