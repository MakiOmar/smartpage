<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action('show_user_profile', 'anony_user_metabox');
add_action('edit_user_profile', 'anony_user_metabox');

function anony_user_metabox($user){
	 $manage_project_id = (isset($user->managed_project) && $user->managed_project != '') ? $user->managed_project : '';?>  
  <h3><?php esc_html_e( 'Managed project', ANONY_TEXTDOM ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="managed_project"><?php esc_html_e( 'Select managed project', ANONY_TEXTDOM ); ?></label></th>
			<td>
				<select name="managed_project" id="managed_project" autocomplete = "off">
					<option value=""><?php esc_html_e( 'Select project', ANONY_TEXTDOM ) ?></option>
					<?php
						$projects_list = ANONY_POST_HELP::getPostsIdsTitles(['post_type' => 'contract']);
						foreach ($projects_list as $project_id => $project_title) {?>
							<option value="<?php echo esc_attr( $project_id ) ?>"<?php selected($manage_project_id ,$project_id) ?>><?php echo  esc_html( $project_title ) ?></option>
						<?php }

					 ?>
				</select>
			</td>
		</tr>
	</table>
<?php }


add_action('personal_options_update', 'anony_user_metabox_update');
add_action('edit_user_profile_update', 'anony_user_metabox_update');
function anony_user_metabox_update($user_id) {
	if ( ! current_user_can( 'edit_user', $user_id ) )  return false;
	
	if(isset($_POST['managed_project']) && !empty($_POST['managed_project'])){

			update_user_meta($user_id, 'managed_project', $_POST['managed_project']);
		
	}else{
		delete_user_meta($user_id, 'managed_project');
	}
}

///If need to add validation errors
add_action( 'user_profile_update_errors', function ( $errors, $update, $user ) {
	if(isset($_POST['managed_project']) && !is_integer( intval($_POST['managed_project'] ) )){

		$errors->add('not_valid', esc_html__('Sorry, but you have selected an invalid value'));
	}
}, 10, 3 );