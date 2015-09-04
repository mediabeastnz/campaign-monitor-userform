<?php

/**
 * Creates an editable field that allows users to choose a list
 * From Campaign Monitor and choose default fields
 * On submission of the form a new subscription will be created
 *
 *
 * @method UserDefinedForm Parent()
 */
class EditableCampaignMonitorField extends EditableFormField {

    /**
	 * @var string
	 */
    private static $singular_name = 'Campaign Monitor Signup Field';

    /**
	 * @var string
	 */
    private static $plural_name = 'Campaign Monitor Signup Fields';


    /**
	 * @var array Fields on the user defined form page.
	 */
    private static $db = array(
        'ListID' => 'Varchar(255)',
        'EmailField' => 'Varchar(255)',
        'FirstNameField' => 'Varchar(255)',
        'LastNameField' => 'Varchar(255)'
    );

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = parent::getCMSFields();

        // get current user form fields
        $currentFromFields = $this->Parent()->Fields()->map('Name', 'Title')->toArray();

        // check for any lists
        $fieldsStatus = true;
        if($this->getLists()->Count() > 0) {
            $fieldsStatus = false;
        }

        $fields->addFieldsToTab("Root.Main", array(
            LiteralField::create("CampaignMonitorStart", "<h4>Campaign Monitor Configuration</h4>")->setAttribute("disabled", $fieldsStatus),
            DropdownField::create("ListID", 'Subscripers List', $this->getLists()->map("ListID", "Name"))
                ->setEmptyString("Choose a Campaign Monitor List")
                ->setAttribute("disabled", $fieldsStatus),
            DropdownField::create("EmailField", 'Email Field', $currentFromFields)->setAttribute("disabled", $fieldsStatus),
            DropdownField::create("FirstNameField", 'First Name Field', $currentFromFields)->setAttribute("disabled", $fieldsStatus),
            DropdownField::create("LastNameField", 'Last Name Field', $currentFromFields)->setAttribute("disabled", $fieldsStatus),
            LiteralField::create("CampaignMonitorEnd", "<h4>Other Configuration</h4>"),
        ), 'Type');

        return $fields;
    }

    /**
     * @return NumericField
     */
    public function getFormField() {
        $field = CheckboxField::create($this->Name, $this->EscapedTitle);
        $this->doUpdateFormField($field);
        return $field;
    }

    protected function updateFormField($field) {
        parent::updateFormField($field);
    }

    /**
     * @return Boolean/Result
     */
    public function getValueFromData($data) {
        // if this field was set and there are lists - subscriper the user
        if (isset($data[$this->Name]) && $this->getLists()->Count() > 0) {
            require_once '../vendor/campaignmonitor/createsend-php/csrest_subscribers.php';
            $auth = array(null, 'api_key' => $this->config()->get('api_key'));
            $wrap = new CS_REST_Subscribers($this->getField('ListID'), $auth);
            $result = $wrap->add(array(
                'EmailAddress' => $data[$this->getField('EmailField')],
                'Name' => $data[$this->getField('FirstNameField')].' '.$data[$this->getField('LastNameField')],
                'Resubscribe' => true
            ));

            if($result->was_successful()) {
                return "Subscribed with code ".$result->http_status_code;
            } else {
                return "Not subscribed with code ".$result->http_status_code;
            }
        }

        return false;
    }

    /**
     * @return Boolean
     */
    public function getFieldValidationOptions() {
		return false;
	}

    /**
     * @return ArrayList
     */
    public function getLists() {

        require_once '../vendor/campaignmonitor/createsend-php/csrest_clients.php';

        $auth = array('api_key' => $this->config()->get('api_key'));
        $wrap = new CS_REST_Clients($this->config()->get('client_id'), $auth);

        $result = $wrap->get_lists();
        $cLists = array();
        if($result->was_successful()) {

            foreach ($result->response as $list) {
                $cLists[] = new ArrayData(array("ListID" => $list->ListID , "Name" => $list->Name));
            }
        }

        return new ArrayList($cLists);

    }
}
