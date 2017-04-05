<?php

/**
 * RESTful Helper
 * 
 * Helper functions for RESTful web service creation
 * @author Rory Molyneux <rorymolyneux@gmail.com>
 * @date 2017-03-29
 * @url https://github.com/aftertheboop/restful-helper-for-codeigniter/
 * @version 1.0
 */

/**
 * Get Request Type
 * 
 * Gets the type of server request: GET, POST, PUT, DELETE
 * @return string
 */
function get_request_type() {
    // Loads up the current CI instance
    $ci =& get_instance();
    // Gets the current request method
    $method = $ci->input->server('REQUEST_METHOD');
    
    return strtolower($method);
}

/**
 * Allowed Request Types
 * 
 * Simple security check. Allows only the permitted request types through.
 * All HTTP request types should be lowercase
 * 
 * @param array $allowed_requests (lowercase)
 */
function allowed_request_types($allowed_requests) {
    
    // Get request type
    $request = get_request_type();
    
    if(!is_array($allowed_requests)) {
        $allowed_requests = array($allowed_requests);
    }
    
    // Convert request types to lowercase
    foreach($allowed_requests as $k => $req) {
        $allowed_requests[$k] = strtolower($req);
    }
    
    if(!in_array($request, $allowed_requests)) {
        // Request is denied, send rejection message
        $return = array('status' => 0,
                        'message' => 'The request type is not allowed');
        return_json($return, 403);
        exit;
    } else {
        return $request;
    }
}

/**
 * Return JSON
 * 
 * Returns the object in JSON form to be consumed by an endpoint
 * @param object/array $obj
 * @return string
 */
function return_json($obj, $status = 200) {
    
    http_response_code($status);
    
    if(is_null($obj)) {
        $obj = array();
    }
    
    echo json_encode($obj);
    exit;
    
}

/**
 * Get Post Vars
 * 
 * Gets the post variables transmitted via
 * JSON
 * 
 * @return mixed
 */
function get_vars() {
    $ci =& get_instance();
    
    $post = $ci->input->post();
    $get = $ci->input->get();
    $req_type = get_request_type();
    
    // Different data handling for if there is a PUT request
    if($req_type == 'put' || $req_type  == 'delete') {
        
        parse_str(urldecode(file_get_contents('php://input')), $phpinput);
                
    } else {
        $phpinput = (Array)json_decode(file_get_contents('php://input'));
    }
    
    if(is_null($post) || !$post) {
        $post = array();
    }
    
    if(is_null($get) || !$get) {
        $get = array();
    }
    
    $vars = array_merge($post, $get, $phpinput);
    
    return (object) $vars;
}
