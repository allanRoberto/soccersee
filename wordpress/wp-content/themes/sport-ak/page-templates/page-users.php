<?php
/*
  Template Name: Page users
 */


 $info_user = get_user_meta( $_GET['user_id'] );
?>

<?php get_header(); ?>
<div id="middle" class="sidebar-container " role="complementary">
    <div class="sidebar-inner">
        <div class="widget-area clearfix">
            <div id="vc_widget-5" class="widget-3 widget-last widget-odd widget widget_vc_widget">
                <div class="scoped-style">
                    <style type="text/css" data-type="vc_shortcodes-custom-css" scoped="">.vc_custom_1445850341128{margin-bottom: 30px !important;background-image: url(http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-6.png?id=431) !important;}.vc_custom_1444660966900{margin-bottom: 0px !important;}</style>
                    <div class="vc_row wpb_row vc_row-fluid player-bio vc_custom_1445850341128">
                        <div class="row">
                            <div class="h-padding-0 wpb_column vc_column_container col-sm-12">
                                <div class="wpb_wrapper">
                                    <div class="vc_row wpb_row vc_inner vc_row-fluid container vc_custom_1444660966900">
                                        <div class="row">
                                            <div class="wpb_column vc_column_container col-sm-offset-2 col-sm-3">
                                                <div class="wpb_wrapper">
                                                    <div class="field ">
                                                        <div class="entry-thumbnail">
                                                                <div class="image col-jjj" style="
                                                                background-image: url('<?php echo content_url($info_user['user_avatar'][0]); ?>');
                                                                 height: 170px; width: 170px;" data-width="470" data-height="484">
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="position-relative wpb_column vc_column_container col-sm-4 col-offset-2">
                                                <div class="wpb_wrapper">
                                                    <div class="field ">
                                                        <h2 class="entry-title"><?php echo $info_user['first_name'][0]; ?> <?php echo $info_user['last_name'][0]; ?></h2>
                                                    </div>
                                                    <div class="panel  player-data">
                                                        <div class="panel-content">
                                                            <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Apelido</label><?php echo $info_user['nickname'][0]; ?>
                                                                </span>
                                                            </div>
                                                            <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Sexo</label><?php echo $info_user['user-genre'][0]; ?>
                                                                </span>
                                                            </div>
                                                            <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Data de nascimento</label><?php echo $info_user['user-date-of-birth'][0]; ?>
                                                                </span>
                                                            </div>
                                                            <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Escolaridade</label><?php echo $info_user['user-schooling'][0]; ?>
                                                                </span>
                                                            </div>
                                                             <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Nacionalidade</label><?php echo $info_user['user-nationality'][0]; ?>
                                                                </span>
                                                            </div>
                                                            <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Idiomas</label><?php echo $info_user['user-first-language'][0]; ?> <?php echo $info_user['user-second-language'][0]; ?> <?php echo $info_user['user-third-language'][0]; ?>
                                                                </span>
                                                            </div>
                                                            <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Posição 1</label><?php echo $info_user['user-first-position'][0]; ?>
                                                                </span>
                                                            </div>
                                                            <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Posição 2</label><?php echo $info_user['user-second-position'][0]; ?>
                                                                </span>
                                                            </div>
                                                            <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Posição 3</label><?php echo $info_user['user-third-position'][0]; ?>
                                                                </span>
                                                            </div>
                                                             <div class="field ">
                                                                <span class="player-position">
                                                                    <label>Interesse em jogar fora ?</label><?php echo $info_user['user-play-out-contry'][0]; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .widget-area -->
    </div>
    <!-- .sidebar-inner -->
</div>

<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
        <div class="entry azsc-player post-696 azsc_player type-azsc_player status-publish has-post-thumbnail hentry position-sriker pmpro-has-access">
            <div class="entry-data">
                <div class="entry-header">
                    <h2 class="text-player">Fotos</h2>
                    <div class="container-images">
                        <?php echo do_shortcode('[sui_table_images id="'.$_GET['user_id'].'"]');?>
                    </div>
                </div>
                <div class="entry-content">
                    <p class="text-center"><?php echo $info_user['habilidades'][0]; ?></p>
                </div>
                <div class="entry-header">
                    <h2 class="text-player">Vídeos</h2>
                </div>
                <div class="entry-content">
                    <p class="text-center"><?php echo $info_user['habilidades'][0]; ?></p>
                </div>
                <div class="entry-header">
                    <h2 class="text-player">Habilidades</h2>
                </div>
                <div class="entry-content">
                    <p class="text-center"><?php echo $info_user['user-skills'][0]; ?></p>
                </div>
                <div class="entry-header">
                    <h2 class="text-player">Clubes em que jogou </h2>
                </div>
                <div class="player-bio player-club col-sm-8 col-sm-offset-2" style="margin-top: 0px;">
                    <div class="wpb_wrapper">
                        <div class="panel  player-data">
                            <div class="panel-content">
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Nome do clube</label><?php echo $info_user['user-name-first-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Posição em que jogava</label><?php echo $info_user['user-position-first-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Cidade:</label><?php echo $info_user['user-city-first-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Estado: </label><?php echo $info_user['user-state-first-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>País</label><?php echo $info_user['user-country-first-club'][0]; ?>
                                    </span>
                                </div>
                                 <div class="field ">
                                    <span class="player-position">
                                        <label>Títulos e prêmios</label><br><?php echo $info_user['user-premium-first-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Informações complementares</label><br>
                                        <?php echo $info_user['user-information-additional-first-club'][0];?> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="player-bio player-club col-sm-8 col-sm-offset-2" style="margin-top: 0px;">
                    <div class="wpb_wrapper">
                        <div class="panel  player-data">
                            <div class="panel-content">
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Nome do clube</label><?php echo $info_user['user-name-second-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Posição em que jogava</label><?php echo $info_user['user-position-second-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Cidade:</label><?php echo $info_user['user-city-second-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Estado: </label><?php echo $info_user['user-state-second-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>País</label><?php echo $info_user['user-country-second-club'][0]; ?>
                                    </span>
                                </div>
                                 <div class="field ">
                                    <span class="player-position">
                                        <label>Títulos e prêmios</label><br><?php echo $info_user['user-premium-second-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Informações complementares</label><br>
                                        <?php echo $info_user['user-information-additional-second-club'][0];?> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="player-bio player-club col-sm-8 col-sm-offset-2" style="margin-top: 0px;">
                    <div class="wpb_wrapper">
                        <div class="panel  player-data">
                            <div class="panel-content">
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Nome do clube</label><?php echo $info_user['user-name-third-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Posição em que jogava</label><?php echo $info_user['user-position-third-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Cidade:</label><?php echo $info_user['user-city-third-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Estado: </label><?php echo $info_user['user-state-third-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>País</label><?php echo $info_user['user-country-third-club'][0]; ?>
                                    </span>
                                </div>
                                 <div class="field ">
                                    <span class="player-position">
                                        <label>Títulos e prêmios</label><br><?php echo $info_user['user-premium-third-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Informações complementares</label><br>
                                        <?php echo $info_user['user-information-additional-third-club'][0];?> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="player-bio player-club col-sm-8 col-sm-offset-2" style="margin-top: 0px;">
                    <div class="wpb_wrapper">
                        <div class="panel  player-data">
                            <div class="panel-content">
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Nome do clube</label><?php echo $info_user['user-name-four-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Posição em que jogava</label><?php echo $info_user['user-position-four-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Cidade:</label><?php echo $info_user['user-city-four-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Estado: </label><?php echo $info_user['user-state-four-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>País</label><?php echo $info_user['user-country-four-club'][0]; ?>
                                    </span>
                                </div>
                                 <div class="field ">
                                    <span class="player-position">
                                        <label>Títulos e prêmios</label><br><?php echo $info_user['user-premium-four-club'][0]; ?>
                                    </span>
                                </div>
                                <div class="field ">
                                    <span class="player-position">
                                        <label>Informações complementares</label><br>
                                        <?php echo $info_user['user-information-additional-four-club'][0];?> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
