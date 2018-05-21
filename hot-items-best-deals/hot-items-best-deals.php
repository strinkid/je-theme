<?php

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

//update view history, user view which products
require_once( dirname(__FILE__) . '/settings.php' );

//code for customer who view this product is also buy
require_once( dirname(__FILE__) . '/display.php' );