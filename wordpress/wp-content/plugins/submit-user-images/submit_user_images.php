<?php 
/*
Plugin Name: Upload de imagens 
Plugin URI: http://www.showy.com.br/
Description: Upload de imagens
Author: Showy
Version: 1.0
Author URI: http://showy.com.br
*/

// If this file is called directly, abort.
define('MAX_UPLOAD_SIZE', 900000);
define('TYPE_WHITELIST', serialize(array(
  'image/jpeg',
  'image/png',
  'image/gif'
  )));



add_action('init', 'sui_plugin_init');

function sui_plugin_init(){
 
  $image_type_labels = array(
    'name' => _x('Fotos dos jogadores', 'post type general name'),
    'singular_name' => _x('User Image', 'post type singular name'),
    'add_new' => _x('Add New User Image', 'image'),
    'add_new_item' => __('Add New User Image'),
    'edit_item' => __('Edit User Image'),
    'new_item' => __('Add New User Image'),
    'all_items' => __('View User Images'),
    'view_item' => __('View User Image'),
    'search_items' => __('Search User Images'),
    'not_found' =>  __('No User Images found'),
    'not_found_in_trash' => __('No User Images found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Foto dos jogadores'
  );
   
  $image_type_args = array(
    'labels' => $image_type_labels,
    'public' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'map_meta_cap' => true,
    'menu_position' => null,
    'supports' => array('title', 'editor', 'author', 'thumbnail')
  ); 
   
  register_post_type('user_images', $image_type_args);
  
  $video_type_labels = array(
    'name' => _x('Vídeos dos jogadores', 'post type general name'),
    'singular_name' => _x('Video', 'post type singular name'),
    'add_new' => _x('Adicionar novo vídeo', 'image'),
    'add_new_item' => __('Adicionar novo video'),
    'edit_item' => __('Editar video'),
    'new_item' => __('Adicionar novo video'),
    'all_items' => __('Ver videos'),
    'view_item' => __('Ver video'),
    'search_items' => __('Procurar videos'),
    'not_found' =>  __('Nenhum videos encontrado'),
    'not_found_in_trash' => __('Nenhum videos encontrado na lixeira'), 
    'parent_item_colon' => '',
    'menu_name' => 'Vídeos dos jogadores'
  );
   
  $video_type_args = array(
    'labels' => $video_type_labels,
    'public' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'map_meta_cap' => true,
    'menu_position' => null,
    'supports' => array('title', 'author')
  ); 

  register_post_type('user_videos', $video_type_args);


}

add_shortcode('sui_form', 'sui_form_shortcode');

add_shortcode('sui_form_video', 'sui_form_shortcode_video');

add_shortcode('sui_table_images', 'sui_table_shortcode' );

add_shortcode('sui_table_videos', 'sui_table_video_shortcode' );


function sui_table_shortcode() {

  $atts = shortcode_atts(
    array(
      'id' => '',
    ), $atts );


    $args = array(
      'author' => $id,
      'post_type' => 'user_images',
      'post_status' => 'publish'   
    );
     
    $user_images = new WP_Query($args);
   
    if(!$user_images->post_count) return false;
     
    $out = '';
     
    $out .= '<form method="post" action="">';
     
    $out .= wp_nonce_field('sui_form_delete', 'sui_form_delete_submitted');  
     
    $out .= '<div class="row">';
    $out .= '<p class="text-center">Clique na imagem para visualizar</p>';
    foreach($user_images->posts as $user_image){
      $post_thumbnail_id = get_post_thumbnail_id($user_image->ID);   
      $out .= wp_nonce_field('sui_image_delete_' . $user_image->ID, 'sui_image_delete_id_' . $user_image->ID, false); 
          
      $out .= '<div class="col-lg-4 col-xs-12 grid-image">';
      $out .=  wp_get_attachment_link($post_thumbnail_id, 'thumbnail');    
      $out .= '</div>';
       
    }
    $out .= "</div>";       
    $out .= '</form>';  
     
    return $out;

}

function sui_table_video_shortcode() {

  $atts = shortcode_atts(
    array(
      'id' => '',
    ), $atts );


    $args = array(
      'author' => $id,
      'post_type' => 'user_videos',
      'post_status' => 'publish'   
    );
     
    $user_videos = new WP_Query($args);
   
    if(!$user_videos->post_count) return false;
     
    $out = '';
     
    $out .= '<form method="post" action="">'; 
    $out .= '<div class="row">';
    foreach($user_videos->posts as $user_video){

      $wp_embed = new WP_Embed(); 

      $post_video_link = get_field('link', $user_video->ID );  

      $out .= $wp_embed->run_shortcode('[embed]'.$post_video_link.'[/embed]');                     
    }
    $out .= "</div>";       
    $out .= '</form>';  
     
    return $out;

}

function sui_form_shortcode(){

  global $current_user;

  if(!is_user_logged_in()){
   
    return '<p>Você precisa estar logado para enviar fotos.</p>';    
 
  }
 
  if(isset( $_POST['sui_upload_image_form_submitted'] ) && wp_verify_nonce($_POST['sui_upload_image_form_submitted'], 'sui_upload_image_form') ){  
 
    $result = sui_parse_file_errors($_FILES['sui_image_file'], 'imagem');
   
    if($result['error']){
     
      echo '<p>ERROR: ' . $result['error'] . '</p>';
     
    }
    else{
 
      $user_image_data = array(
        'post_title' => 'img-'.$current_user->first_name,
        'post_status' => 'pending',
        'post_author' => $current_user->ID,
        'post_type' => 'user_images'    
      );    
      if($post_id = wp_insert_post($user_image_data)){
     
        sui_process_image('sui_image_file', $post_id, 'img-'.$current_user->ID);

        $admin_email = get_option('admin_email');

        $subject = 'Foto aguardando aprovação.';
        $message = 'Uma nova foto foi inserida, <a href="'.site_url('/wp-admin/post.php?post='.$post_id.'&action=edit').'">Clique aqui</a> para aprova-la';
        $to = array($admin_email);
         
        $headers = array();
        $headers[] = 'From:Soccersee <noreply@soccersee.com>';
   
        $headers[] = 'categories: category1, category2';
        $headers[] = 'template: c0caa1f3-16b6-4c5a-a6a0-017b3e357b06';
         
         
        add_filter('wp_mail_content_type', 'set_html_content_type');
        $mail = wp_mail($to, $subject, $message, $headers, $attachments);
         
        remove_filter('wp_mail_content_type', 'set_html_content_type');
          
      }
    }
  }

  if (isset( $_POST['sui_form_delete_submitted'] ) && wp_verify_nonce($_POST['sui_form_delete_submitted'], 'sui_form_delete')){
 
    if(isset($_POST['sui_image_delete_id'])){
     
      if($user_images_deleted = sui_delete_user_images($_POST['sui_image_delete_id'])){        
       
        echo '<p class="msg-sucess-sui-form">' . $user_images_deleted . ' foto(s) foram delatadas com sucesso !</p>';
         
      }
    }
  }

  echo sui_get_upload_image_form($sui_image_caption = 'img-'.$current_user->ID);
 
  
}

function sui_form_shortcode_video(){

  global $current_user;

  if(!is_user_logged_in()){
   
    return '<p>Você precisa estar logado para enviar vídeos.</p>';    
 
  }
 
  if(isset( $_POST['sui_upload_video_form_submitted'] ) && wp_verify_nonce($_POST['sui_upload_video_form_submitted'], 'sui_upload_video_form') ){  
 
    $link_video = $_REQUEST['sui_video_link'];

   
    if($result['error']){
     
      echo '<p>ERROR: ' . $result['error'] . '</p>';
     
    }
    else{
 
      $user_video_data = array(
        'post_title' => 'video-'.$current_user->first_name,
        'post_status' => 'pending',
        'post_author' => $current_user->ID,
        'post_type' => 'user_videos'    
      );    
      if($post_id = wp_insert_post($user_video_data)){
     
        update_field('link', $link_video, $post_id);

        $admin_email = get_option('admin_email');

        $subject = 'Vídeo aguardando aprovação.';
        $message = 'Um novo vídeo foi inserido, <a href="'.site_url('/wp-admin/post.php?post='.$post_id.'&action=edit').'">Clique aqui</a> para aprova-lo';
        $to = array($admin_email);
         
        $headers = array();
        $headers[] = 'From:Soccersee <noreply@soccersee.com>';
   
        $headers[] = 'categories: category1, category2';
        $headers[] = 'template: c0caa1f3-16b6-4c5a-a6a0-017b3e357b06';
         
         
        add_filter('wp_mail_content_type', 'set_html_content_type');
        $mail = wp_mail($to, $subject, $message, $headers, $attachments);
         
        remove_filter('wp_mail_content_type', 'set_html_content_type');
          
      }
    }
  }

  if (isset( $_POST['sui_form_delete_video_submitted'] ) && wp_verify_nonce($_POST['sui_form_delete_video_submitted'], 'sui_form_delete_video')){
 
    if(isset($_REQUEST['sui_video_delete_id'])){
     
      if($user_video_deleted = sui_delete_user_videos($_REQUEST['sui_video_delete_id'])){        
       
        echo '<p class="msg-sucess-sui-form">' . $user_video_deleted . ' vídeo(s) foram delatados com sucesso !</p>';
         
      }
    }
  }

  echo sui_get_upload_video_form($sui_video_caption = 'video-'.$current_user->ID);
 
  
}

  function count_images() {
    global $current_user;
  
    switch ($current_user->membership_level->ID) {
      case '1':
        $number_images = 7; 
      break;
      
      case '2':
        $number_images = 5;
      break;

      case '3':
        $number_images = 8;
      break;    
      
      case '4':
        $number_images = 13;
        break;
    }

    $args = array(
      'author' => $current_user->ID,
      'post_type' => 'user_images',
      'post_status' => 'any'   
    );
     
    $user_images = new WP_Query($args);
   
    $count = $user_images->post_count;

    $out = $number_images - $count;

    return $out;

  }

  function count_videos() {
    global $current_user;
  
    switch ($current_user->membership_level->ID) {
      case '1':
        $number_videos = 0; 
      break;
      
      case '2':
        $number_videos = 0;
      break;

      case '3':
        $number_videos = 2;
      break;    
      
      case '4':
        $number_videos = 4;
        break;
    }

      $args = array(
      'author' => $current_user->ID,
      'post_type' => 'user_videos',
      'post_status' => 'any'
    );
     
    $user_videos = new WP_Query($args);
   
    $count = $user_videos->post_count;

    $out = $number_videos - $count;

    return $out;

  }

  function sui_get_upload_image_form($sui_image_caption = ''){
    ?>
      <div class="container grid-images">
      <div class="row">
        <div class="col-lg-4">
          <h2 class="title-gallery-images">
            Envie suas fotos
          </h2>
          <p>Clique no botão abaixo para selecionar suas fotos do seu perfil:</p>
          <div class="form-gallery-images-container">
            <form id="sui_upload_image_form" method="post" action="" enctype="multipart/form-data">

            <?php 

                $count = count_images();
                if(!$count == 0) {

              ?>
              <?php wp_nonce_field('sui_upload_image_form', 'sui_upload_image_form_submitted'); ?>
              <div class="clearfix"></div>
              <div class="custom-file-upload">
                <input type="file" id="file" name="sui_image_file" />

            </div>
            <?php } ?>
              <p> Você tem o direito de postar : <strong><?php echo count_images(); ?></strong> fotos</p> 
              <?php if(!$count == 0) {?>
                <input type="submit" id="sui_submit" class="pricing-button" name="sui_submit" value="Enviar foto">
                <?php }?>
            </form>
          </div>
        </div>
        <div class="col-lg-8">
          <h2 class="title-gallery-images">
            Confira suas fotos enviadas
          </h2>
          <p>Para remover as fotos já cadastradas basta selecionar as que deseja excluir e depois clicar no botão: <br>"Deletar imagens selecionadas"</p>
            <?php 
          
            echo sui_get_user_images_table();
            
  
            ?>

          </h2>
        </div>
      </div>
    </div>

    <?php 

 
    /* $out = '<form id="sui_upload_image_form" method="post" action="" enctype="multipart/form-data">';
    $out .= '<h2>Envie suas fotos:</h2>';
    $out .= wp_nonce_field('sui_upload_image_form', 'sui_upload_image_form_submitted');
    $out .= '<label for="sui_image_file">Selecione uma imagem: </label><br/>';  
    $out .= '<input type="file" size="60" name="sui_image_file" id="sui_image_file"><br/>';
       
    $out .= '<input type="submit" id="sui_submit" class="pricing-button" name="sui_submit" value="Enviar foto">';
   
    $out .= '</form><div class="clearfix"></div>';*/
   
  }

  function sui_get_upload_video_form($sui_image_caption = ''){
    ?>
      <div class="container grid-images">
      <div class="row">
        <div class="col-lg-4">
          <h2 class="title-gallery-images">
            Envie seus vídeos
          </h2>
          <p>Clique no botão abaixo para selecionar seus vídeos:</p>
          <div class="form-gallery-images-container">
            <form id="sui_upload_video_form" method="post">

            <?php 

                $count = count_videos();
                if(!$count == 0) {

              ?>
              <?php wp_nonce_field('sui_upload_video_form', 'sui_upload_video_form_submitted'); ?>
              <div class="clearfix"></div>
              <div class="input-text">
               <label>Insira o link do vídeo :</label>
                <input type="text" id="video-link" name="sui_video_link" />
              </div>
            <?php } ?>
              <p> Você tem o direito de postar : <strong><?php echo count_videos(); ?></strong> Vídeos</p> 
              <?php if(!$count == 0) {?>
                <input type="submit" id="sui_submit" class="pricing-button" name="sui_submit" value="Enviar Vídeo">
                <?php }?>
            </form>
          </div>
        </div>
        <div class="col-lg-8">
          <h2 class="title-gallery-images">
            Confira seus vídeos
          </h2>
          <p>Para remover os vídeos já cadastrados basta selecionar os que deseja excluir e depois clicar no botão: <br>"Deletar vídeos selecionados"</p>
            <?php 
          
            echo sui_get_user_videos_table();
            
  
            ?>

          </h2>
        </div>
      </div>
    </div>

    <?php 
   
  }


  function sui_get_user_images_table(){
    
    global $current_user;

    $args = array(
      'author' => $current_user->ID,
      'post_type' => 'user_images',
      'post_status' => 'publish'   
    );
     
    $user_images = new WP_Query($args);
   
    if(!$user_images->post_count) return false;
     
    $out = '';
     
    $out .= '<form method="post" action="">';
     
    $out .= wp_nonce_field('sui_form_delete', 'sui_form_delete_submitted');  
     
    $out .= '<div class="row">';
    $out .= '<p class="text-center">Clique na imagem para visualizar</p>';
    foreach($user_images->posts as $user_image){
      $post_thumbnail_id = get_post_thumbnail_id($user_image->ID);   
      $out .= wp_nonce_field('sui_image_delete_' . $user_image->ID, 'sui_image_delete_id_' . $user_image->ID, false); 
          
      $out .= '<div class="col-lg-4 col-xs-12 grid-image">';
      $out .= '<div class="checkbox">
                  <input type="checkbox" id="sui_image_delete_id" name="sui_image_delete_id[]" value="' . $user_image->ID . '" class="checkbox-custom" /> 
                  <label class="checkbox-custom-label" for="sui_image_delete_id">Remover Imagem</label>
              </div>';
      $out .=  wp_get_attachment_link($post_thumbnail_id, 'thumbnail');    
      $out .= '</div>';
       
    }
    $out .= "</div><div class='row'><div class='col-lg-12 col-xs-12 buttom-delete'>";       
    $out .= '<input type="submit" name="sui_delete" class="pricing-button" value="Deletar imagens selecionadas" />';
    $out .= "</div></div>";
    $out .= '</form>';  
     
    return $out;
 
  }

  function sui_get_user_videos_table(){
    
    global $current_user;

    $args = array(
      'author' => $current_user->ID,
      'post_type' => 'user_videos',
      'post_status' => 'any'   
    );
     
    $user_videos = new WP_Query($args);
   
    if(!$user_videos->post_count) return false;
     
    $out = '';
     
    $out .= '<form method="post" action="">';
     
    $out .= wp_nonce_field('sui_form_delete_video', 'sui_form_delete_video_submitted');  
     
    $out .= '<div class="row">';
    foreach($user_videos->posts as $user_video){

      $wp_embed = new WP_Embed(); 

      $post_video_link = get_field('link', $user_video->ID );  

      $out .= wp_nonce_field('sui_video_delete_' . $user_video->ID, 'sui_video_delete_id_' . $user_video->ID, false); 
          
      $out .= '<div class="col-lg-4 col-xs-12 grid-image">';
      $out .= '<div class="checkbox">
                  <input type="checkbox" id="sui_video_delete_id" name="sui_video_delete_id[]" value="' . $user_video->ID . '" class="checkbox-custom" /> 
                  <label class="checkbox-custom-label" for="sui_video_delete_id">Remover Vídeo</label>
              </div>';
      $out .= $wp_embed->run_shortcode('[embed width="123" height="456"]'.$post_video_link.'[/embed]');    
      $out .= '</div>';
       
    }
    $out .= "</div><div class='row'><div class='col-lg-12 col-xs-12 buttom-delete'>";       
    $out .= '<input type="submit" name="sui_delete_video" class="pricing-button" value="Deletar videos selecionados" />';
    $out .= "</div></div>";
    $out .= '</form>';  
     
    return $out;
    
  }

  function sui_delete_user_images($images_to_delete){
 
    $images_deleted = 0;
   
    foreach($images_to_delete as $user_image){
   
      if (isset($_POST['sui_image_delete_id_' . $user_image]) && wp_verify_nonce($_POST['sui_image_delete_id_' . $user_image], 'sui_image_delete_' . $user_image)){
       
        if($post_thumbnail_id = get_post_thumbnail_id($user_image)){
   
          wp_delete_attachment($post_thumbnail_id);      
   
        }  
   
        wp_trash_post($user_image);
         
        $images_deleted ++;
   
      }
    }
   
    return $images_deleted;
 
}

function sui_delete_user_videos($videos_to_delete){
 
    $videos_deleted = 0;
   
    foreach($videos_to_delete as $user_video){
   
      if (isset($_POST['sui_video_delete_id_' . $user_video]) && wp_verify_nonce($_POST['sui_video_delete_id_' . $user_video], 'sui_video_delete_' . $user_video)){
       
      
   
        wp_trash_post($user_video);
         
        $videos_deleted ++;
   
      }
    }
   
    return $videos_deleted; 
}

function sui_parse_file_errors($file = '', $image_caption){
 
  $result = array();
  $result['error'] = 0;
   
  if($file['error']){
   
    $result['error'] = "No file uploaded or there was an upload error!";
     
    return $result;
   
  }
 
  $image_caption = trim(preg_replace('/[^a-zA-Z0-9\s]+/', ' ', $image_caption));
   
  if($image_caption == ''){
 
    $result['error'] = "Your caption may only contain letters, numbers and spaces!";
     
    return $result;
   
  }
   
  $result['caption'] = $image_caption;  
 
  $image_data = getimagesize($file['tmp_name']);
   
  if(!in_array($image_data['mime'], unserialize(TYPE_WHITELIST))){
   
    $result['error'] = 'Your image must be a jpeg, png or gif!';
     
  }elseif(($file['size'] > MAX_UPLOAD_SIZE)){
   
    $result['error'] = 'Your image was ' . $file['size'] . ' bytes! It must not exceed ' . MAX_UPLOAD_SIZE . ' bytes.';
     
  }
     
  return $result;
 
}

function sui_process_image($file, $post_id, $caption){
  
  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');
  
  $attachment_id = media_handle_upload($file, $post_id);
  
  update_post_meta($post_id, '_thumbnail_id', $attachment_id);
 
  $attachment_data = array(
    'ID' => $attachment_id,
    'post_excerpt' => $caption
  );
   
  wp_update_post($attachment_data);
 
  return $attachment_id;
 
}

function sui_process_video($file, $post_id, $caption){
  
  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');
  
  $attachment_id = media_handle_upload($file, $post_id);
  
  update_post_meta($post_id, '_thumbnail_id', $attachment_id);
 
  $attachment_data = array(
    'ID' => $attachment_id,
    'post_excerpt' => $caption
  );
   
  wp_update_post($attachment_data);
 
  return $attachment_id;
 
}