<?php

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

//update view history, user view which products
require_once( dirname(__FILE__) . '/update-view-history.php' );

//code for customer who view this product is also buy
require_once( dirname(__FILE__) . '/customer-who-view-also-buy.php' );

//code for most viewed items
require_once( dirname(__FILE__) . '/most-view.php' );
require_once( dirname(__FILE__) . '/recent-view.php' );