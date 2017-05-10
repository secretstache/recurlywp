<?php

/**
 * @return array
 * @since 0.1.0
 */
function get_recurly_data() {

  Recurly_Client::$apiKey = recurlywp_get_option('recurlywp_setting_recurly_api_key_private');
  Recurly_Client::$subdomain = recurlywp_get_option('recurlywp_setting_recurly_subdomain');
  $account_code = recurlywp_get_option('recurlywp_setting_account_code_query_var');

  $data = array();

  if ( isset($_GET[ $account_code ]) && !empty($_GET[ $account_code ]) ) {

    $accountID = $_GET[ $account_code ];

    // Setup
    $account = Recurly_Account::get( $accountID );
    $billing_info = Recurly_BillingInfo::get( $accountID );
    $invoices = Recurly_InvoiceList::getForAccount( $accountID );

    $i = 1;

    foreach ( $invoices as $invoice ) {

      // pprint_r ($invoice);

      if ( $i == 1 ) {

      $inv['uuid'] = $invoice->uuid;
      $inv['invoice'] = $invoice->invoice_number;

        foreach ( $invoice->line_items as $line_item ) {
          $inv['plan'] = $line_item->description;
          $inv['total'] = convert_cents_to_dollars( $line_item->total_in_cents );
          $inv['startDate'] = $line_item->start_date->format('m/d/y');
          $inv['endDate'] = $line_item->end_date->format('m/d/y');
          $inv['nextBilling'] = $line_item->end_date->modify('+1 Day')->format('m/d/y');

        }

      }

      $i++;

    }

    $firstName = $account->first_name;
    $lastName = $account->last_name;
    $companyName = $account->company_name;

    $phoneNumber = sanitize_phone( $billing_info->phone );

    $uuid = $inv['uuid'];
    $invoice = $inv['invoice'];
    $plan = $inv['plan'];
    $total = $inv['total'];
    $startDate = $inv['startDate'];
    $endDate = $inv['endDate'];
    $nextBilling = $inv['nextBilling'];

    $data = array(

       'accountID'      => $accountID,
       'firstName'      => $firstName,
       'lastName'       => $lastName,
       'companyName'    => $companyName,
       'phoneNumber'    => $phoneNumber,
       'plan'           => $plan,
       'uuid'           => $uuid,
       'invoice'        => $invoice,
       'total'          => $total,
       'startDate'      => $startDate,
       'endDate'        => $endDate,
       'nextBilling'    => $nextBilling

    );

  }

    return $data;

}

/**
 * @param  $amount_in_cents
 * @return string
 * @since  0.1.0
 */
function convert_cents_to_dollars( $amount_in_cents ) {
  $dollars = number_format( ($amount_in_cents / 100), 2);
  $dollars = '$' . $dollars;

  return $dollars;
}

/**
 * @param  string
 * @param  boolean
 * @return mixed
 * @since  0.1.0
 */
function sanitize_phone( $phone, $international = false ) {
  $format = "/(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/";

  $alt_format = '/^(\+\s*)?((0{0,2}1{1,3}[^\d]+)?\(?\s*([2-9][0-9]{2})\s*[^\d]?\s*([2-9][0-9]{2})\s*[^\d]?\s*([\d]{4})){1}(\s*([[:alpha:]#][^\d]*\d.*))?$/';

  // Trim & Clean extension
  $phone = trim( $phone );
  $phone = preg_replace( '/\s+(#|x|ext(ension)?)\.?:?\s*(\d+)/', ' ext \3', $phone );

    if ( preg_match( $alt_format, $phone, $matches ) ) {
        return '(' . $matches[4] . ') ' . $matches[5] . '-' . $matches[6] . ( !empty( $matches[8] ) ? ' ' . $matches[8] : '' );
    } elseif ( preg_match( $format, $phone, $matches ) ) {

      // format
      $phone = preg_replace( $format, "($2) $3-$4", $phone );

      // Remove likely has a preceding dash
      $phone = ltrim( $phone, '-' );

      // Remove empty area codes
      if ( false !== strpos( trim( $phone ), '()', 0 ) ) {
        $phone = ltrim( trim( $phone ), '()' );
      }

      // Trim and remove double spaces created
      return preg_replace('/\\s+/', ' ', trim( $phone ) );
    }

    return false;
}