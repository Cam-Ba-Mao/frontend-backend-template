<?php
/** hook actions for back end **/

namespace BM\Core\Auth;

if ( !class_exists ( 'AuthHook') ) {
	class AuthHook 
	{
		public static function init()
        {
            static $init = null;

            if ($init === null) {
                $init = new self();
                $init->initialize();
            }
			

            return $init;
        }

        private function initialize() 
        {
			// add_action("wp_ajax_rt_register", [$this, 'ajaxUserRegister']);
			// add_action("wp_ajax_nopriv_rt_register", [$this, 'ajaxUserRegister']);
        	add_action( 'rest_api_init', array( $this, 'registerAuthApi' ) );
        }

		public function ajaxUserRegister() {
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$type = 'google';
			$id = isset($_POST['provide_id']) ? $_POST['provide_id'] : '';
			$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
			$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
			$name = isset($_POST['name']) ? $_POST['name'] : $first_name . ' ' .$last_name ;
			
			if( !empty($email) && !empty($id) && !empty($first_name) && !empty($last_name) && !empty($name) ) {
				$userExited = get_user_by( 'email', $email );
		
				if ( $userExited ) {
					// parent site login
					$userID = $userExited->data->ID;
					wp_clear_auth_cookie();
					wp_set_current_user( $userID );
					wp_set_auth_cookie( $userID );
		
					wp_send_json_success(array(
						'message' => 'Login is success',
					));
					exit();
				} else {
					$password = 'rt@' . time() . '*!' ;
		
					$dataRegister = array(
						'user_login' => $email,
						'user_email' => $email,
						'user_pass' => $password,
					);
		
					if(!empty($first_name)) {
						$dataRegister['first_name'] = $first_name;
					}
		
					if(!empty($last_name)) {
						$dataRegister['last_name'] = $last_name;
					}
		
					if(!empty($name)) {
						$dataRegister['display_name'] = $name;
					}
		
					$userID = wp_insert_user( $dataRegister );
		
					if ( is_wp_error( $userID ) AND $userID->errors ) {
						wp_send_json_error(array(
							'message' => $userID->get_error_message()
						));
						exit();
					}
		
					if(!empty($id)) {
						update_user_meta($userID, 'social_id', $id);
					}
		
					if(!empty($type)) {
						update_user_meta($userID, 'type', $type);
					}

					wp_clear_auth_cookie();
					wp_set_current_user( $userID );
					wp_set_auth_cookie( $userID );
		
					wp_send_json_success(array(
						'message' => 'Register is success',
						
					));
					exit();
				}
			} else {
				wp_send_json_error(array(
					'message' => 'Param is required'
				));
				exit();
			}
			exit();
			
		}

		/**
	     * Portnerpress register custom auth api
	     * @return
	     */
	    public function registerAuthApi() 
	    {	
	    	// register user
	        register_rest_route( 'api/v1', '/auth/login', array(
	            'methods' => 'POST',
	            'callback' => array( $this, 'apiLogin' ),
	            'permission_callback' => function () {
	                return !is_user_logged_in();
	            },
	            'args' => array(
	                'email' => array(
	                    'required'          => true,
	                    'type'              => 'string',
	                    'validate_callback' => function ( $param, $request, $key ) {
	                        return filter_var( $param, FILTER_VALIDATE_EMAIL );
	                    }
	                ),
	                'password' => array(
	                    'required' => false,
	                    'type'     => 'string',
	                    'validate_callback' => function ( $param, $request, $key ) {
	                        return !empty( $param );
	                    }
	                )
	            )
	        ) );

	       	// register user
	        register_rest_route( 'api/v1', '/auth/register', array(
	            'methods' => 'POST',
	            'callback' => array( $this, 'apiRegister' ),
	            'permission_callback' => function () {
	                return !is_user_logged_in();
	            },
	            'args' => array(
	                'email' => array(
	                    'required'          => true,
	                    'type'              => 'string',
	                    'validate_callback' => function ( $param, $request, $key ) {
	                        return filter_var( $param, FILTER_VALIDATE_EMAIL );
	                    }
	                ),
	                'type' => array(
	                    'required' => true,
	                    'type'     => 'string',
	                    'default'  => 'google',
	                    'validate_callback' => function ( $param, $request, $key ) {
	                        return !empty($param);
	                    }
	                ),
	                'provide_id' => array(
	                    'required' => false,
	                    'type'     => 'string'
	                ),
	                'first_name' => array(
	                    'required' => false,
	                    'type'     => 'string'
	                ),
	                'last_name' => array(
	                    'required' => false,
	                    'type'     => 'string'
	                ),
	                'name' => array(
	                    'required' => false,
	                    'type'     => 'string'
	                )
	            )
	        ) );
	    }

	    public function apiLogin(\WP_REST_Request $request) {
	    	$email = $request->get_param('email');
	    	$password = $request->get_param('password');

	    	if(!empty($email) && !empty($password)) {

	    		try {	    			
	    			$creds = array(
			            'user_login'    => strip_tags( $email ),
			            'user_password' => strip_tags( $password ),
			            'remember'      => true
			        );

		        	$user = wp_signon( $creds, false );

		        	if ( is_wp_error( $user ) ) {
		        		return \BM\Core\Common\CommonFunctions::response( 'login_error', 403, __('<strong>LỖI</strong>: Email hoặc mật khẩu không chính xác.', 'Rt') );
			        } else {
						$userID = $user->data->ID;
						wp_clear_auth_cookie();
						wp_set_current_user( $userID );
						wp_set_auth_cookie( $userID );
					}

			        return \BM\Core\Common\CommonFunctions::response( 'login_success', 200, $user );

	    		} catch (Exception $e) {
	    			return \BM\Core\Common\CommonFunctions::response( 'register_error', 403, $e->getMessage() );
	    		}
	    	}


	    }

	    /* API register user*/
	    public function apiRegister( \WP_REST_Request $request ) {

	        $email = $request->get_param('email');
	        $type = $request->get_param('type');
	        $id = $request->get_param('provide_id');
	        $first_name = $request->get_param('first_name');
	        $last_name = $request->get_param('last_name');
	        $name = $request->get_param('name');

	        $userExited = get_user_by( 'email', $email );
			if ( $userExited ) {
				// parent site login
				$userID = $userExited->data->ID;
				wp_clear_auth_cookie();
				wp_set_current_user( $userID );
				wp_set_auth_cookie( $userID );

				return \BM\Core\Common\CommonFunctions::response( 'register_success', 200, $userExited->data );
			}
			
	        $password = 'rt@' . time() . '*!' ;
	        $this->createAccountByEmail( $email, $password, $type, $id, $first_name, $last_name, $name); 

	        try {	            
	            $user  = get_user_by( 'email', $email );
	            wp_clear_auth_cookie();
	            wp_set_current_user( $user->ID );
	            wp_set_auth_cookie( $user->ID );
	           
	            return \BM\Core\Common\CommonFunctions::response( 'register_success', 200, $user );

	        } catch (Exception $e) {	            
	        	return \BM\Core\Common\CommonFunctions::response( 'register_error', 403, $e->getMessage() );
	        }
	    }

	    /**
	     * Portnerpress create account by email
	     * @param  string $email
	     * @return
	     */
	    public function createAccountByEmail( 
	        $email, 
	        $password = null, 
	        $type='email', 
	        $id='', 
	        $first_name='', 
	        $last_name='', 
	        $display_name='', 
	        $picture='' ) {

	        $password = $password ?? wp_generate_password( $length = 12, $special_chars = true, $extra_special_chars = false );
	        
	        $dataRegister = array(
	            'user_login' => $email,
	            'user_email' => $email,
	            'user_pass' => $password,
	        );

	        if(!empty($first_name)) {
	            $dataRegister['first_name'] = $first_name;
	        }

	        if(!empty($last_name)) {
	            $dataRegister['last_name'] = $last_name;
	        }

	        if(!empty($display_name)) {
	            $dataRegister['display_name'] = $display_name;
	        }

	        $userID = wp_insert_user( $dataRegister );

	        if ( is_wp_error( $userID ) AND $userID->errors ) {
	            return new \WP_REST_Response( array( 'type' => 'error', 'message' => __( $userID->get_error_message(), 'vencreative' ) ) );
	        }

	        if(!empty($id)) {
	            update_user_meta($userID, 'social_id', $id);
	        }

	        if(!empty($type)) {
	            update_user_meta($userID, 'type', $type);
	        }

	        // Save social avatar
	        $social_info = array(
	            'avatar_url' => $picture,
	            'full_name' => $first_name . ' ' . $last_name,
	        );

	        update_user_meta($userID, 'social_'.$type, json_encode($social_info));
	        update_user_meta($userID, 'social_'.$type.'_email', $email);


	        // Save avatar
	        //self::updateAvatarRegister($userID, $picture);

	        // Send email user register
	        // self::sendEmailRegisterNotification($userID, $password);
	    }

	    /**
	    * Update user avatar user
	    * @param int $userID
	    * @param string $image_url
	    * @return void
	    */
	    public static function updateAvatarRegister( $userID, $image_url ) {
	        if( !empty($image_url) ) {

	            // Add Featured Image to Post
	            $image_name       = 'avatart-' . $userID .'.png';
	            $upload_dir       = wp_upload_dir(); // Set upload folder
	            $image_data       = file_get_contents($image_url); // Get image data
	            $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
	            $filename         = basename( $unique_file_name ); // Create image file name

	            // Check folder permission and define file location
	            if( wp_mkdir_p( $upload_dir['path'] ) ) {
	                $file = $upload_dir['path'] . '/' . $filename;
	            } else {
	                $file = $upload_dir['basedir'] . '/' . $filename;
	            }

	            // Create the image  file on the server
	            file_put_contents( $file, $image_data );

	            // Check image file type
	            $wp_filetype = wp_check_filetype( $filename, null );

	            // Set attachment data
	            $attachment = array(
	                'post_mime_type' => $wp_filetype['type'],
	                'post_title'     => sanitize_file_name( $filename ),
	                'post_content'   => '',
	                'post_status'    => 'inherit'
	            );

	            // Create the attachment
	            $attach_id = wp_insert_attachment( $attachment, $file, 0 );

	            // Include image.php
	            require_once(ABSPATH . 'wp-admin/includes/image.php');

	            // Define attachment metadata
	            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

	            // Assign metadata to attachment
	            wp_update_attachment_metadata( $attach_id, $attach_data );


	            if(!empty($attach_id)) {
	                update_user_meta($userID, 'user_avatar', $attach_id);
	            }
	        }
	    }

	    /**
	    * Send email notification for user after register
	    * @param int $userID
	    * @param string $password
	    * @return json
	    */
	    public static function sendEmailRegisterNotification( $userID, $password ) {        
	        // WC()->mailer()->emails['WC_Email_Customer_New_Account']->trigger( $userID, $password);        
	    }
	}
}

?>