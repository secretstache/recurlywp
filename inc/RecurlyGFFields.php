<?php 


class RecurlyGFFields {

  /** This will hold the recurly data */
  public $recurly_data;

  function __construct() {

    // Configure the $recurly_data var to hold data
    $this->recurly_data = get_recurly_data();

    // Our filters
    add_filter( 'gform_field_value_cName', array( $this, 'recurly_get_company' )  );
    add_filter( 'gform_field_value_paFirstName', array( $this, 'recurly_get_first_name' ) );
    add_filter( 'gform_field_value_paLastName', array( $this, 'recurly_get_last_name' ) );
    add_filter( 'gform_field_value_cPhoneNumber', array( $this, 'recurly_get_phone_number' ) );
    add_filter( 'gform_field_value_cEmailAddress', array( $this, 'recurly_get_email_address' ) );
    add_filter( 'gform_field_value_b2b_mName', array( $this, 'recurly_get_b2b_membership_name' ) );
    add_filter( 'gform_field_value_b2c_mName', array( $this, 'recurly_get_b2c_membership_name' ) );
    add_filter( 'gform_field_value_uuid', array( $this, 'recurly_get_uuid' ) );
    add_filter( 'gform_field_value_invoice', array( $this, 'recurly_get_invoice' ) );

  }


  /**
  * Get Company Name from Recurly API
  */
  public function recurly_get_company( $value ) {
    $recurly = $this->recurly_data;
    return $recurly['companyName'];
  }


  /**
  * Get First Name from Recurly API
  */
  public function recurly_get_first_name( $value ) {
    $recurly = $this->recurly_data;
    return $recurly['firstName'];
  }


  /**
   * Get Last Name from Recurly API
   */
  public function recurly_get_last_name( $value ) {
    $recurly = $this->recurly_data;
    return $recurly['lastName'];
  }


  /**
  * Get Company Phone Number from Recurly API
  */
  public function recurly_get_phone_number( $value ) {
    $recurly = $this->recurly_data;
    return $recurly['phoneNumber'];
  }


  /**
  * Get Company Email Address from Recurly API
  */
  public function recurly_get_email_address( $value ) {
    $recurly = $this->recurly_data;
    return $recurly['accountID'];
  }


  /**
   * Create Internal Membership Name from Recurly API
   */
  public function recurly_get_b2b_membership_name( $value ) {
    $recurly = $this->recurly_data;
    $mName = $recurly['companyName'] . ' - ' . $recurly['plan'];

    return $mName;
  }


  /**
  * Create Internal Membership Name from Recurly API
  */
  public function recurly_get_b2c_membership_name( $value ) {
  $recurly = $this->recurly_data;
  $plan_name = $recurly['plan'];

  if ( strpos($plan_name, 'Individuals') != FALSE ) {
    $plan = 'Individual';
  } elseif ( strpos($plan_name, 'Couples') != FALSE ) {
    $plan = 'Couple';
  } elseif ( strpos($plan_name, 'Families') != FALSE ) {
    $plan = 'Family';
  }

  $mName = $recurly['lastName'] . ', ' . $recurly['firstName'] . ' - ' . $plan;
  return $mName;

  }


  /**
  * Get Subscription UUID from Recurly API
  */
  public function recurly_get_uuid( $value ) {
    $recurly = $this->recurly_data;
    return $recurly['uuid'];
  }

  /**
  * Get Subscription Invoice from Recurly API
  */
  public function recurly_get_invoice( $value ) {
    $recurly = $this->recurly_data;
    return $recurly['invoice'];
  }

}

new RecurlyGFFields();