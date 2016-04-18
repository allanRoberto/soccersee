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
    'name' => _x('User images', 'post type general name'),
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
    'menu_name' => 'User Images'
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
     
}

add_shortcode('sui_form', 'sui_form_shortcode');

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
        'post_title' => 'img-'.$current_user->ID,
        'post_status' => 'pending',
        'post_author' => $current_user->ID,
        'post_type' => 'user_images'    
      );    
      if($post_id = wp_insert_post($user_image_data)){
     
        sui_process_image('sui_image_file', $post_id, 'img-'.$current_user->ID);
          
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
 
  if($user_images_table = sui_get_user_images_table($current_user->ID)){
   
    echo $user_images_table;
     
  }
}

  function sui_get_upload_image_form($sui_image_caption = ''){
 
    $out = '<form id="sui_upload_image_form" method="post" action="" enctype="multipart/form-data">';
    $out .= '<h2>Envie suas fotos:</h2>';
    $out .= wp_nonce_field('sui_upload_image_form', 'sui_upload_image_form_submitted');
    $out .= '<label for="sui_image_file">Selecione uma imagem: </label><br/>';  
    $out .= '<input type="file" size="60" name="sui_image_file" id="sui_image_file"><br/>';
       
    $out .= '<input type="submit" id="sui_submit" class="pricing-button" name="sui_submit" value="Enviar foto">';
   
    $out .= '</form><div class="clearfix"></div>';
   
    return $out; 
  }


  function sui_get_user_images_table($user_id){
 
    $args = array(
      'author' => $user_id,
      'post_type' => 'user_images',
      'post_status' => 'pending'   
    );
     
    $user_images = new WP_Query($args);
   
    if(!$user_images->post_count) return 0;
     
    $out = '';
     
    $out .= '<form method="post" action="">';
     
    $out .= wp_nonce_field('sui_form_delete', 'sui_form_delete_submitted');  
     
    $out .= '<div id="user_images">';
    $out .= '<h2>Fotos enviadas : </h2>';
    $out .= '<p class="text-center">Clique na imagem para visualizar</p>';
    $out .= '<ul class="table-img">';
       
    foreach($user_images->posts as $user_image){
   
      $post_thumbnail_id = get_post_thumbnail_id($user_image->ID);   
   
      $out .= wp_nonce_field('sui_image_delete_' . $user_image->ID, 'sui_image_delete_id_' . $user_image->ID, false); 
          
      $out .= '<li>';
      $out .= '<span class="container-img">' . wp_get_attachment_link($post_thumbnail_id, 'thumbnail') . '</span>';    
      $out .= '<span class="description-img"><input type="checkbox" name="sui_image_delete_id[]" value="' . $user_image->ID . '" /><label for="sui_image_delete_id">Remover foto</label></span>';          
      $out .= '</li>';
       
    }
   
    $out .= '</ul>';
       
    $out .= '<input type="submit" name="sui_delete" class="pricing-button" value="Deletar imagens selecionadas" />';
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