<?php
/**
 * AppelPourLaDifférence - Signup
 *
 * Sets up all of the necessary stuff to perform signups
 *
 */


/**
 * Gravity Forms
 *
 */

// loads gravity JS in the footer
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
	return true;
}

// handle data after form submission
add_action( 'gform_after_submission_1', 'after_submission_subscribe_form', 10, 2 );

function after_submission_subscribe_form( $entry, $form ) {
	
	global $wpdb; 
	
	$last_name = rgar( $entry, '1' );
	$first_name = rgar( $entry, '2' );
	$email = rgar( $entry, '3' );
	$message = rgar( $entry, '4' );
	$photo_url = rgar( $entry, '5' );
	$subscribe_newsletter = rgar( $entry, '6.1' );

	$inscription = array(
	  'post_title'  => $first_name . ' ' . $last_name,
	  'post_content'  => $message,
	  'post_status'   => 'publish',
	  'post_type'	  => 'inscription'
	);
 
	// Insert the post into the database
	$result = wp_insert_post( $inscription );
	if ($result==0) { 
        // error
	} else {
		// updates post_meta
		update_post_meta($result, 'txt_last_name', $last_name);
		update_post_meta($result, 'txt_first_name', $first_name);
		update_post_meta($result, 'txt_email', $email);
		//debug_by_mail('test 1 : '.$subscribe_newsletter);
		if ($subscribe_newsletter != "") { 
            $subscribe_newsletter = true;
        } else { 
            $subscribe_newsletter = false;
        };
		//debug_by_mail('test 2 : '.$subscribe_newsletter);
		update_post_meta($result, 'boolean_subscribe_newsletter', $subscribe_newsletter);
        if ($photo_url) {
            // creates thumbnail image
			Generate_Featured_Image( $photo_url, $result );
        };
	}
	
	$message = $email;
	$message .= " Nouvelle inscription commeunseulhomme.org";
	wp_mail( "communication@commeunseulhomme.com", "Inscription liste " . get_home_url(), $message );
	
}

add_filter( 'gform_upload_path', 'change_upload_path', 10, 2 );
function change_upload_path( $path_info, $form_id ) {
	$upload_dir = wp_upload_dir();
	//debug_by_mail($upload_dir);

	$path_info['path'] = $upload_dir['path'] . '/';
	$path_info['url'] = $upload_dir['url']. '/';
	return $path_info;
}

function Generate_Featured_Image( $image_url, $post_id  ){
    
    $upload_dir = wp_upload_dir();
    $filename = basename($image_url);
    if ( wp_mkdir_p($upload_dir['path']) ) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }

    $wp_filetype = wp_check_filetype( $filename, null );

    $attachment_data = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name( $filename ),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    apply_filters( 'wp_handle_upload', array( 
        'file' => $file,  
        'url' => $image_url,  
        'type' => $wp_filetype['type'] 
    ));

    $attach_id = wp_insert_attachment( $attachment_data, $file, $post_id );

    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    set_post_thumbnail( $post_id, $attach_id );
}


/**
 * Gravity Wiz // Gravity Forms // Rename Uploaded Files
 *
 * Rename uploaded files for Gravity Forms. You can create a static naming template or using merge tags to base names on user input.
 *
 * Features:
 *  + supports single and multi-file upload fields
 *  + flexible naming template with support for static and dynamic values via GF merge tags
 *
 * Uses:
 *  + add a prefix or suffix to file uploads
 *  + include identifying submitted data in the file name like the user's first and last name
 *
 * @version	  1.2
 * @author    David Smith <david@gravitywiz.com>
 * @license   GPL-2.0+
 * @link      http://gravitywiz.com/...
 */
class GW_Rename_Uploaded_Files {
    public function __construct( $args = array() ) {

        // set our default arguments, parse against the provided arguments, and store for use throughout the class
        $this->_args = wp_parse_args( $args, array(
            'form_id'  => false,
            'field_id' => false,
            'template' => ''
        ) );

        // do version check in the init to make sure if GF is going to be loaded, it is already loaded
        add_action( 'init', array( $this, 'init' ) );

    }

    public function init() {

        // make sure we're running the required minimum version of Gravity Forms
        if( ! property_exists( 'GFCommon', 'version' ) || ! version_compare( GFCommon::$version, '1.8', '>=' ) ) {
            return;
        }

        add_action( 'gform_pre_submission', array( $this, 'rename_uploaded_files' ) );

    }

    function rename_uploaded_files( $form ) {

        if( ! $this->is_applicable_form( $form ) ) {
            return;
        }

        foreach( $form['fields'] as &$field ) {

            if( ! $this->is_applicable_field( $field ) ) {
                continue;
            }

            $is_multi_file  = rgar( $field, 'multipleFiles' ) == true;
            $input_name     = sprintf( 'input_%s', $field['id'] );
            $uploaded_files = rgars( GFFormsModel::$uploaded_files, "{$form['id']}/{$input_name}" );

            if( $is_multi_file && ! empty( $uploaded_files ) && is_array( $uploaded_files ) ) {

                foreach( $uploaded_files as &$file ) {
                    $file['uploaded_filename'] = $this->rename_file( $file['uploaded_filename'] );
                }

                GFFormsModel::$uploaded_files[ $form['id'] ][ $input_name ] = $uploaded_files;

            } else {

                if( empty( $uploaded_files ) ) {

                    $uploaded_files = rgar( $_FILES, $input_name );
                    if( empty( $uploaded_files ) || empty( $uploaded_files['name'] ) ) {
                        continue;
                    }

                    $uploaded_files['name'] = $this->rename_file( $uploaded_files['name'] );
                    $_FILES[ $input_name ] = $uploaded_files;

                } else {

                    $uploaded_files = $this->rename_file( $uploaded_files );
                    GFFormsModel::$uploaded_files[ $form['id'] ][ $input_name ] = $uploaded_files;

                }

            }

        }

    }

    function rename_file( $filename ) {

        $file_info = pathinfo( $filename );
        $new_filename = $this->remove_slashes( $this->get_template_value( $this->_args['template'], GFFormsModel::get_current_lead(), $file_info['filename'] ) );

        return sprintf( '%s.%s', $new_filename, rgar( $file_info, 'extension' ) );
    }

    function get_template_value( $template, $entry, $filename ) {

        $form = GFAPI::get_form( $entry['form_id'] );
        $template = GFCommon::replace_variables( $template, $form, $entry, false, true, false, 'text' );

        // replace our custom "{filename}" psuedo-merge-tag
        $template = str_replace( '{filename}', $filename, $template );

        return $template;
    }

    function remove_slashes( $value ) {
        return stripslashes( str_replace( '/', '', $value ) );
    }

    function is_applicable_form( $form ) {

        $form_id = isset( $form['id'] ) ? $form['id'] : $form;

        return $form_id == $this->_args['form_id'];
    }

    function is_applicable_field( $field ) {

        $is_file_upload_field   = in_array( GFFormsModel::get_input_type( $field ), array( 'fileupload', 'post_image' ) );
        $is_applicable_field_id = $this->_args['field_id'] ? $field['id'] == $this->_args['field_id'] : true;

        return $is_file_upload_field && $is_applicable_field_id;
    }

}
    
// Configuration
new GW_Rename_Uploaded_Files( array(
    'form_id' => 1,
    'field_id' => 5,
    'template' => 'image_cleaned_name_'.substr(str_shuffle(MD5(microtime())), 0, 8) // most merge tags are supported, original file extension is preserved
) );

add_filter( 'gform_field_input', 'add_file_field_attributes_for_upload_on_mobile', 10, 5 );
function add_file_field_attributes_for_upload_on_mobile( $input, $field, $value, $lead_id, $form_id ) {
    // because this will fire for every form/field, only do it when it is the specific form and field
    if ( $form_id == 1 && $field->id == 5 ) {
        $input = '<div class="ginput_container ginput_container_fileupload"><input type="hidden" name="MAX_FILE_SIZE" value="3145728"><input name="input_5" id="input_1_5" type="file" class="medium" capture="camera" accept="image/*" aria-describedby="extensions_message" tabindex="4"><span id="extensions_message" class="screen-reader-text">Types de fichiers acceptés : jpg, gif, png, bmp.</span></div>';
    }
    return $input;
}