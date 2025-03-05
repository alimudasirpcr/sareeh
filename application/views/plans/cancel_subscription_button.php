<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if (empty($invoice->subscription_id)) : ?>
<a href="<?= erp_server_url('clients/my_account/cancel_subscription'); ?>" class="btn btn-danger mtop10">
    <i class="fa fa-times"></i>
    <?= lang('perfex_saas_pricing_cancel'); ?>
</a>

<?php else : ?>

<?php if (!empty($invoice->stripe_subscription_id) && $invoice->status != 'canceled' && !empty($invoice->subscription_ends_at)) : ?>
<a class="btn btn-warning mtop10" href="<?php echo erp_server_url('clients/my_account/resume_subscription'); ?>">
    <?= lang('resume_now'); ?>
</a>
<?php else : ?>
<div class="btn-group">
    <a href="#" class="btn btn-danger mtop10 dropdown-toggle tw-w-full" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <?php echo lang('cancel'); ?> <span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right">
        <li><a onclick="return confirm('<?= e(lang('perfex_saas_pricing_cancel_confirmation')); ?>')"
                href="<?php echo erp_server_url('clients/my_account/cancel_subscription?type=immediately'); ?>">
                <?php echo lang('cancel_immediately'); ?></a></li>
        <li><a onclick="return confirm('<?= e(lang('perfex_saas_pricing_cancel_confirmation')); ?>')"
                href="<?php echo erp_server_url('clients/my_account/cancel_subscription?type=at_period_end'); ?>">
                <?php echo lang('cancel_at_end_of_billing_period'); ?>
            </a>
    </ul>
</div>
<?php endif ?>
<?php endif ?>