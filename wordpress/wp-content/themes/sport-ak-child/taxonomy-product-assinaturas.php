<?php 
global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user;

$pmpro_levels = pmpro_getAllLevels(false, true);

$pmpro_level_order = pmpro_getOption('level_order');

if(!empty($pmpro_level_order))
{
	$order = explode(',',$pmpro_level_order);

	//reorder array
	$reordered_levels = array();
	foreach($order as $level_id) {
		foreach($pmpro_levels as $key=>$level) {
			if($level_id == $level->id)
				$reordered_levels[] = $pmpro_levels[$key];
		}
	}

	$pmpro_levels = $reordered_levels;
}

$pmpro_levels = apply_filters("pmpro_levels_array", $pmpro_levels);

if($pmpro_msg)
{
?>

<div class="pmpro_message <?php echo $pmpro_msgt?>"><?php echo $pmpro_msg?></div>
<?php
}
?>
	<div class="pricing-table-container container">
        <div class="row">
            <article class="pricing-table">
            	<?php	
					$count = 0;
					foreach($pmpro_levels as $level)
					{

					  if(isset($current_user->membership_level->ID))
						  $current_level = ($current_user->membership_level->ID == $level->id);
					  else
						  $current_level = false;
					?>
                <div id="layers-widget-pricing-table-4-1" class="pricing-plan pricing-plan-horizontal">
                    <header class="pricing-plan-header column-flush span-3">
                        <h2 class="pricing-plan-title"><?php echo $level->name; ?></h2>
                        <h1 class="pricing-plan-price">
                            <sup class="pricing-plan-currency">R$</sup><span class="pricing-plan-number"><?php echo $level->billing_amount ?></span>
                            <sup class="pricing-plan-period">/ Mês</sup>
                        </h1>
                    </header>
                    <section class="pricing-plan-body column-flush span-6">
	                    <ul class="pricing-plan-items">
	                    	<?php echo $level->description; ?>   
	                    </ul>
                    </section>
                    <footer class="pricing-plan-footer column-flush span-3">
                    	<?php if(empty($current_user->membership_level->ID)) { ?>
								<a class="button btn-regular btn-regular pricing-button"  data-vc-tabs="" data-vc-container=".vc_tta" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'pmpro');?></a>
							<?php echo do_shortcode('[add_to_cart id="1274"]' );} elseif ( !$current_level ) { ?>                	
								<a class="button btn-regular btn-regular pricing-button"  data-vc-tabs="" data-vc-container=".vc_tta" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'pmpro');?></a>
							<?php echo do_shortcode('[add_to_cart id="1274"]' );} elseif($current_level) { ?>      
								
								<?php
									//if it's a one-time-payment level, offer a link to renew				
									if( pmpro_isLevelExpiringSoon( $current_user->membership_level) && $current_user->membership_level->allow_signups ) {
										?>
											<a class="button btn-regular btn-regular pricing-button"  data-vc-tabs="" data-vc-container=".vc_tta" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Renew', 'pmpro');?></a>

										<?php
										echo do_shortcode('[add_to_cart id="1274"]' );
									} else {
										?>
											<a class="button btn-regular btn-regular pricing-button disabled" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'pmpro');?></a>
										<?php
									}
								?>
							<?php } ?>
                    </footer>
                </div>
                <?php
					}
				?>
			</article>
        </div>
    </div>

