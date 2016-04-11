<?php
/*
  Field Name: Product working hours
 */
?>
<?php
global $product;
$days = array(
    '1' => esc_html__('Monday', 'sport-ak'),
    '2' => esc_html__('Tuesday', 'sport-ak'),
    '3' => esc_html__('Wednesday', 'sport-ak'),
    '4' => esc_html__('Thursday', 'sport-ak'),
    '5' => esc_html__('Friday', 'sport-ak'),
    '6' => esc_html__('Saturday', 'sport-ak'),
    '7' => esc_html__('Sunday', 'sport-ak'),
);

$working_hours = get_post_meta($product->id, 'working-hours', true);

$options = get_option(AZEXO_THEME_NAME);
$caption = (isset($options['product-working-hours_prefix']) && !empty($options['product-working-hours_prefix'])) ? '<caption>' . esc_html($options['product-working-hours_prefix']) . '</caption>' : '';


$not_empty = array_filter((array) $working_hours);

if (!empty($not_empty)):
    ?>
    <table class="working-hours">
        <?php print $caption; ?>
        <thead>
            <tr>
                <th><?php esc_attr_e('Day', 'sport-ak'); ?></th>
                <th><?php esc_attr_e('Open', 'sport-ak'); ?></th>
                <th><?php esc_attr_e('Close', 'sport-ak'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($days as $day => $day_name) {
                ?>
                <tr>
                    <td><label><?php print $day_name; ?></label></td>
                    <?php
                    if (empty($working_hours['open-' . $day]) || empty($working_hours['close-' . $day])) {
                        ?>
                        <td class="closed" colspan="2"><?php esc_attr_e('Closed', 'sport-ak'); ?></td>
                        <?php
                    } else {
                        ?>
                        <td class="open">
                            <?php
                            print esc_html($working_hours['open-' . $day]);
                            ?>
                        </td>
                        <td class="close">
                            <?php
                            print esc_html($working_hours['close-' . $day]);
                            ?>
                        </td>
                        <?php
                    }
                    ?>

                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php



endif;