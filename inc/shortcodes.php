<?php

function recurly_shortcode($atts) {
  extract(shortcode_atts(array(
          "data" => '',
          "default" => '',
  ), $atts));

  return do_recurly_data( $data, $default );
}

add_shortcode("recurly", "recurly_shortcode");

function do_recurly_data( $data, $default ) {

  $recurly = get_recurly_data();

  // pprint_r($recurly);

  $accountID    = $recurly['accountID'];
  $firstName    = $recurly['firstName'];
  $lastName     = $recurly['lastName'];
  $companyName  = $recurly['companyName'];
  $phoneNumber  = $recurly['phoneNumber'];
  $plan         = $recurly['plan'];
  $invoice      = $recurly['invoice'];
  $uuid         = $recurly['uuid'];
  $total        = $recurly['total'];
  $startDate    = $recurly['startDate'];
  $endDate      = $recurly['endDate'];
  $nextBilling  = $recurly['nextBilling'];

  if ( $data == 'firstName' ) {
    if ( $firstName != NULL ) {
      $output = $firstName;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'lastName' ) {
    if ( $lastName != NULL ) {
      $output = $lastName;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'companyName') {
    if ( $companyName  != NULL ) {
      $output = $companyName;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'plan' ) {
    if ( $plan != NULL ) {
      $output = $plan;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'invoice' ) {
    if ( $invoice != NULL ) {
      $output = $invoice;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'uuid' ) {
    if ( $uuid != NULL ) {
      $output = $uuid;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'total' ) {
    if ( $total != NULL ) {
      $output = $total;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'accountID' ) {
    if ( $accountID != NULL ) {
      $output = $accountID;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'startDate' ) {
    if ( $startDate != NULL ) {
      $output = $startDate;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'endDate' ) {
    if ( $endDate != NULL ) {
      $output = $endDate;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'nextBilling' ) {
    if ( $nextBilling != NULL ) {
      $output = $nextBilling;
    } else {
      $output = $default;
    }

  } elseif ( $data == 'phoneNumber' ) {
    if ( $phoneNumber != NULL ) {
      $output = $phoneNumber;
    } else {
      $output = $default;
    }

  }

  return $output;

}
