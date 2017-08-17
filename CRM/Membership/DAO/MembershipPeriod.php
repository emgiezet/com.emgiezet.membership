<?php
/**
 * Created by PhpStorm.
 * User: mgz
 * Date: 17.08.17
 * Time: 22:32
 */

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
/**
 * CRM_Membership_DAO_MembershipPeriod constructor.
 */
class CRM_Membership_DAO_MembershipPeriod extends CRM_Core_DAO {
  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  static $_tableName = 'civicrm_membershipperiod';
  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var boolean
   */
  static $_log = true;
  /**
   *
   * @var int unsigned
   */
  public $id;
  /**
   * FK to Membership table
   *
   * @var int unsigned
   */
  public $membership_id;

  /**
   * FK to Contact ID of person under whose credentials this data modification was made.
   *
   * @var int unsigned
   */
  public $contact_id;
  /**
   * New membership period start date
   *
   * @var date
   */
  public $start_date;
  /**
   * New membership period expiration date.
   *
   * @var date
   */
  public $end_date;
  /**
   * New membership period expiration date.
   *
   * @var date
   */
  public $modified_date;

  /**
   * Class constructor.
   */
  function __construct() {
    $this->__table = 'civicrm_membership_period';
    parent::__construct();
  }
  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static ::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName() , 'membership_id', 'civicrm_membership', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName() , 'contact_id', 'civicrm_contact', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }
  /**
   * Returns the names of this table
   *
   * @return string
   */
  static function getTableName() {
    return self::$_tableName;
  }
  /**
   * Returns if this table needs to be logged
   *
   * @return boolean
   */
  function getLog() {
    return self::$_log;
  }
  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = array(
        'id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'Unique MembershipPeriod ID',
          'required' => true,
          'table_name' => 'civicrm_membership_period',
          'entity' => 'MembershipPeriod',
          'bao' => 'CRM_Membership_DAO_MembershipPeriod',
          'localizable' => 0,
        ) ,
        'contact_id' => array(
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'FK to Contact',
          'table_name' => 'civicrm_membership_period',
          'entity' => 'MembershipPeriod',
          'bao' => 'CRM_Membership_DAO_MembershipPeriod',
          'localizable' => 0,
          'FKClassName' => 'CRM_Member_DAO_Membership',
        ) ,
        'membership_id' => array(
          'name' => 'membership_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'FK to Membership',
          'table_name' => 'civicrm_membership_period',
          'entity' => 'MembershipPeriod',
          'bao' => 'CRM_Membership_DAO_MembershipPeriod',
          'localizable' => 0,
          'FKClassName' => 'CRM_Member_DAO_Membership',
        ) ,
        'start_date' => array(
          'name' => 'start_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Start Date') ,
          'description' => 'Renewal Start Date',
          'required' => true,
          'table_name' => 'civicrm_membership_period',
          'entity' => 'MembershipPeriod',
          'bao' => 'CRM_Membership_DAO_MembershipPeriod',
          'localizable' => 0,
        ) ,
        'end_date' => array(
          'name' => 'end_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('End Date') ,
          'description' => 'Renewal End Date',
          'required' => true,
          'table_name' => 'civicrm_membership_period',
          'entity' => 'MembershipPeriod',
          'bao' => 'CRM_Membership_DAO_MembershipPeriod',
          'localizable' => 0,
        ) ,
        'modified_date' => array(
          'name' => 'modified_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Modified Date') ,
          'description' => 'Modified Date',
          'required' => true,
          'table_name' => 'civicrm_membership_period',
          'entity' => 'MembershipPeriod',
          'bao' => 'CRM_Membership_DAO_MembershipPeriod',
          'localizable' => 0,
        ) ,
      );
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }
  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }
  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  static function &import($prefix = false) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'membershiprenewallog', $prefix, array());
    return $r;
  }
  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  static function &export($prefix = false) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'membershiprenewallog', $prefix, array());
    return $r;
  }
  /**
   * Returns the list of indices
   */
  public static function indices($localize = TRUE) {
    $indices = array();
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }


}
