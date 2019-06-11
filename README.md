# Restful Helper For Codeigniter
A simple helper library for assisting with creating RESTful services with Codeigniter

## What is this?
Built out of necessity for working with RESTful frameworks like Backbonejs, I built this library to assist with basic REST handling inside Codeigniter. It's not robust, but it gets the job done for basic REST handling.

## Usage
* Clone or download this repo
* Copy the application folder into your Codeigniter project directory
* Load the restful helper in your controller with
>$this->load->helper('restful');
* Or autoload the helper file in your autoload.php
>$autoload['helper'] = array('restful_helper');

### Functions
#### get_request_type()
Gets the current request type so that you can determine whether the service is requesting a GET, POST, PUT or DELETE

#### allowed_request_types($allowed_requests)
Allows you to gate away specific request types. Accepts a string or an array.
If your endpoint is GET only, you can restrict it using
>allowed_request_types('get');

This will reject all server requests but GET with a 403 response.

A GET,POST,PUT endpoint like "/user" will take
>allowed_request_types(array('get', 'post', 'put'));

#### return_json($obj, $status = 200)
This method will return your data as a JSON string with a 200 HTTP status code, unless otherwise specified. Useful for if you want to standardise how you send data back to the application.

#### get_vars()
Returns a PHP Object of any/all POST, PUT or GET values sent to your endpoint.

#### get_auth()
Gets the `Authorization` header encoded phrase, decodes it and returns the object
as a username and password pair to be passed to your own auth function.