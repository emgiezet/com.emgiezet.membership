<?php
use CRM_Membership_ExtensionUtil as E;

/**
 * Class CRM_Membership_Page_MembershipPeriod
 */
class CRM_Membership_Page_MembershipPeriod extends CRM_Core_Page {


  /**
   *
   */
  public function getMembershipPeriodList() {

    $id = CRM_Utils_Request::retrieve('membership_id', 'Positive', $this);

    $membership = array();
    $dao = new CRM_Membership_DAO_MembershipPeriod();
    $dao->is_test = 0;
    if ($id) {
      $dao->whereAdd("membership_id = " . $id);
    }
    $dao->find();

    while ($dao->fetch()) {
      $membership[$dao->id]['membership_id'] = $dao->membership_id;
      $membership[$dao->id]['contact_id'] = $dao->contact_id;
      $membership[$dao->id]['start_date'] = $dao->start_date;
      $membership[$dao->id]['end_date'] = $dao->end_date;
      $membership[$dao->id]['modified_date'] = $dao->modified_date;
    }
    $this->assign('periods', $membership);
  }

  /**
   *
   */
  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('MembershipPeriod'));

    // Example: Assign a variable for use in a template
    $this->getMembershipPeriodList();
    parent::run();
  }

}
