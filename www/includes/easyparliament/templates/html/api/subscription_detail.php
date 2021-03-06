<?php

$quota_status = $subscription->quota_status();
$account_balance = $subscription->stripe->customer->account_balance;
if ($subscription->upcoming) {
    if ($subscription->upcoming->total < 0) {
        # Going to be credited
        $account_balance += $subscription->upcoming->total;
    }
}

?>

    <section class="account-form">
        <h2>Subscription</h2>

        <?php if ($quota_status['blocked']) { ?>
          <?php if ($quota_status['quota'] > 0 && $quota_status['count'] > $quota_status['quota']) { ?>
            <p class="attention-box warning">
                You have used up your quota for the <?= $subscription->stripe->plan->interval ?>.
                Please <a href="/api/update-plan">upgrade</a>
                or <a href="/contact/">contact us</a>.
            </p>
          <?php } else { ?>
            <p class="attention-box warning">
                Your account is currently suspended. Please
                <a href="/contact/">contact us</a>.
            </p>
          <?php } ?>
        <?php } ?>

        <?php if ($subscription->stripe->plan) { ?>

            <p>Your current plan is <strong><?= $subscription->stripe->plan->nickname ?></strong>.</p>

            <p>It costs you £<?= $subscription->actual_paid ?>/<?= $subscription->stripe->plan->interval ?>.
            <?php if ($subscription->stripe->discount) { ?>
                (£<?= $subscription->stripe->plan->amount ?>/<?= $subscription->stripe->plan->interval ?> with
                <?= $subscription->stripe->discount->coupon->percent_off ?>% discount applied.)
            <?php } ?>
            </p>

            <?php if ($subscription->stripe->discount && $subscription->stripe->discount->end) { ?>
                <p>Your discount will expire on <?= $subscription->stripe->discount->end ?>.</p>
            <?php } ?>

            <p>Subscription created on <?= date('d/m/Y', $subscription->stripe->created) ?>;
            <?php if ($subscription->stripe->cancel_at_period_end) { ?>
                <strong>it expires on <?= date('d/m/Y', $subscription->stripe->current_period_end) ?>.</strong>
            <?php } elseif ($subscription->actual_paid > 0) { ?>
                your next payment
                <?php
                if ($subscription->upcoming) {
                    echo 'of £' . number_format($subscription->upcoming->amount_due / 100, 2);
                }
                ?> will be taken on <?= date('d/m/Y', $subscription->stripe->current_period_end) ?>.
            <?php } else { ?>
                your next invoice date is <?= date('d/m/Y', $subscription->stripe->current_period_end) ?>.
            <?php } ?>

            <?php if ($account_balance) { ?>
                <br>Your account has a balance of £<?= number_format(-$account_balance / 100, 2); ?>.
            <?php } ?>
            </p>

            <ul class="unstyled-list inline-list">
                <li><a href="/api/update-plan" class="btn btn--small btn--primary">Change plan</a></li>
              <?php if (!$subscription->stripe->cancel_at_period_end) { ?>
                <li><a href="/api/cancel-plan" class="btn btn--small btn--danger">Cancel subscription</a></li>
              <?php } ?>
            </ul>

            <hr>

            <h3>Your usage</h3>

            <p>
                This <?= $subscription->stripe->plan->interval ?>:
                <?= number_format($quota_status['count']) ?>
              <?php if ($quota_status['quota'] > 0) { ?>
                out of <?= number_format($quota_status['quota']) ?>
              <?php } ?>
                API calls
            </p>

            <?php if ($quota_status['quota'] > 0) { ?>
                <meter class="subscription-quota-meter"
                    value="<?= $quota_status['count'] ?>"
                    min="0"
                    max="<?= $quota_status['quota'] ?>">
                    <?= number_format($quota_status['count']) ?> out of
                    <?= number_format($quota_status['quota']) ?> API calls
                </meter>
            <?php } ?>

            <hr>

            <h3>Your payment details</h3>

            <?php if ($subscription->stripe->customer->default_source) { ?>
                <p>Payment details we hold: <?= $subscription->stripe->customer->default_source->brand ?>,
                last four digits <code><?= $subscription->stripe->customer->default_source->last4 ?></code>.</p>
            <?php } else { ?>
                <p>We do not currently hold any payment details for you.</p>
            <?php } ?>

            <form action="/api/update-card" method="POST">
                <?= \Volnix\CSRF\CSRF::getHiddenInputString() ?>
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="<?= STRIPE_PUBLIC_KEY ?>"
                    data-image="https://s3.amazonaws.com/stripe-uploads/acct_19EbqNIbP0iBLddtmerchant-icon-1479145884111-mysociety-wheel-logo.png"
                    data-name="mySociety"
                    data-panel-label="Update Card Details"
                    data-label="Update Card Details"
                    data-allow-remember-me=false
                    data-zip-code=true
                    data-locale="auto"
                    data-email="<?= $THEUSER->email() ?>">
              </script>
            </form>

        <?php } else { ?>
            <p>You are not currently subscribed to a plan.</p>
            <p>
                <a href="/api/update-plan" class="btn btn--primary">Subscribe to a plan</a></p>
            </p>

        <?php } ?>

    </section>
