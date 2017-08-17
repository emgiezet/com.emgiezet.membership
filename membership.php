<?php

require_once 'membership.civix.php';
use CRM_Membership_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function membership_civicrm_config(&$config) {
  _membership_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function membership_civicrm_xmlMenu(&$files) {
  _membership_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function membership_civicrm_install() {
  _membership_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function membership_civicrm_postInstall() {
  _membership_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function membership_civicrm_uninstall() {
  _membership_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function membership_civicrm_enable() {
  _membership_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function membership_civicrm_disable() {
  _membership_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function membership_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _membership_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function membership_civicrm_managed(&$entities) {
  _membership_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function membership_civicrm_caseTypes(&$caseTypes) {
  _membership_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function membership_civicrm_angularModules(&$angularModules) {
  _membership_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function membership_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _membership_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function membership_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function membership_civicrm_navigationMenu(&$menu) {
  _membership_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _membership_civix_navigationMenu($menu);
} // */

/**
 * @param $op
 * @param $objectName
 * @param $objectId
 * @param $objectRef
 */
function membership_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  switch ($objectName) {
    case 'Membership':

      $membershipType = civicrm_api3('MembershipType', 'get', array(
        'id' => "{$objectRef->membership_type_id}",
        'options' => array('limit' => 1),
        'sequential' => 1,
      ));
      $membershipTypeArray = $membershipType['values'][0];

      // calculate datediffs
      if($objectRef->end_date === null) {
        $diff = date_diff(new \DateTime('now'), new \DateTime($objectRef->start_date));
      } else {
        $diff = date_diff(new \DateTime($objectRef->end_date), new \DateTime($objectRef->start_date));
      }

      switch ($membershipTypeArray['duration_unit']) {
        case 'year':
          $count = $diff->y;
          $interval ='Y';
          break;
        case 'month':
          $count = $diff->m + $diff->y * 12;
          $interval ='M';
          break;
        case 'day':
          $count = $diff->days;
          $interval ='D';
          break;
        case 'lifetime':
        default:
          $count = 1;
          $interval ='Y';
          break;
      }

      $startDate = new \DateTime($objectRef->start_date);
      $now = new \DateTime();

      for ($i=0; $i <= $count; $i++) {
        $currStartDate = clone $startDate;
        $currStartDate->add(new \DateInterval('P'.$i.$interval));

        if ($membershipTypeArray['duration_unit'] != 'lifetime') {
          $plusOne = new \DateInterval('P1' . $interval);
          $currEndDate = clone $currStartDate;
          $currEndDate->add($plusOne);
        }

        $result = civicrm_api3(
          'MembershipPeriod',
          'create',
          array(
            'contact_id' => $objectRef->contact_id,
            'membership_id' => $objectRef->id,
            'start_date' => $currStartDate->format('Y-m-d'),
            'end_date' => $currEndDate->format('Y-m-d'),
            'modified_date' => $now->format('Y-m-d'),
            'sequential' => 1,
            'debug'=>1
          )
        );
      }
      break;
    default:
      // nothing to do
      break;
  }
}

function membership_civicrm_entityTypes(&$entityTypes) {
  $entityTypes[] = array (
    'name' => 'MembershipPeriod',
    'class' => 'CRM_Membership_DAO_MembershipPeriod',
    'table' => 'civicrm_membershipperiod',
  );
};

/**
 * Add new link to display membership renewal log using hook_civicrm_links
 *
 * @param string $op
 * @param string $objectName
 * @param int $objectId
 * @param array $links
 * @param array $mask
 * @param array $values
 */
function membership_civicrm_links($op, $objectName, $objectId, &$links, &$mask, &$values) {
  switch ($objectName) {
    case 'Membership':
      switch ($op) {
        case 'membership.selector.row':
          $links[] = array(
            'name' => ts('Membership Periods'),
            'url' => 'civicrm/membershipperiod',
            'title' => 'View Membership Periods',
            'qs' => 'membership_id=%%membership_id%%',
            'class' => 'crm-popup',
          );
          $values['membership_id'] = $objectId;
          break;
      }
      break;
    default:
      // Do Nothing
      break;
  }
}

