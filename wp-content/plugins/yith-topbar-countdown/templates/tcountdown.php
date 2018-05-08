<?php
/**
 * Topbar Countdown page
 *
 * @author Your Inspiration Themes
 * @package YITH Topbar Countdown
 * @version 1.0.0
 */
;?>


<?php if(get_option('yith_tcountdown_enable')) : ?>
    <!-- START YITH-TOPBAR-COUNTDOWN -->
    <div id="yith-topbar-countdown" class="topbar-countdown-container">
        <div class="wrapper_inner">
            <?php if(get_option('yith_tcountdown_icon')) :?>
                <img src="<?php echo get_option('yith_tcountdown_icon') ?>">
            <?php endif; ?>


            <div class="countdown_information">

                <?php if(get_option('yith_tcountdown_slogan')) :?>
                    <?php $slogan =  get_option('yith_tcountdown_slogan'); ?>
                    <?php $slogan = str_replace('[','<strong>',$slogan ) ?>
                    <?php $slogan = str_replace(']','</strong>',$slogan ) ?>
                    <span class="countdown_slogan"><?php echo $slogan ?></span>
                <?php endif; ?>

                <?php if(get_option('yith_tcountdown_date')) :?>

                    <?php $date = yith_get_countdown(yith_countdown_unixstamp(get_option('yith_tcountdown_date'))); ?>

                    <span class="countdown">

                        <span class="num days"><?php echo $date['days'] ?></span>
                        <span class="countdown-label"><?php _e( 'Days', 'yith-topbar-countdown' ) ?></span>

                        <span class="num hours"><?php echo $date['hours'] ?></span>
                        <span class="countdown-label"><?php _e( 'Hours', 'yith-topbar-countdown' ) ?></span>

                        <span class="num minutes"><?php echo $date['minutes'] ?></span>
                        <span class="countdown-label"><?php _e( 'Minutes', 'yith-topbar-countdown' ) ?></span>

                        <span class="num seconds"><?php echo $date['seconds'] ?></span>
                        <span class="countdown-label no-margin"><?php _e( 'Seconds', 'yith-topbar-countdown' ) ?></span>
                    </span>

                    <?php if(get_option('yith_tcountdown_message')) :?>
                        <span class="message"><?php echo get_option('yith_tcountdown_message') ?></span>
                    <?php endif; ?>

                <?php endif; ?>

            </div>

             <?php if(get_option('yith_tcountdown_button_text') && get_option('yith_tcountdown_link')) : ?>

                <span class="countdown_button">
                    <a href="<?php echo get_option('yith_tcountdown_link') ?>">
                        <?php echo get_option('yith_tcountdown_button_text') ?>
                    </a>
                </span>

            <?php endif; ?>
        </div>
    </div>

    <script type="text/javascript">
            jQuery(document).ready(function($){
                var countdown_html = $('.countdown').clone();

                $('.num.days', countdown_html).text('{dn}');
                $('.num.hours', countdown_html).text('{hnn}');
                $('.num.minutes', countdown_html).text('{mnn}');
                $('.num.seconds', countdown_html).text('{snn}');

                $('.countdown').countdown({until: <?php echo $date['to'] ?>, layout: countdown_html.html() });
            });
    </script>
    <!-- END YITH-TOPBAR-COUNTDOWN -->
<?php endif; ?>