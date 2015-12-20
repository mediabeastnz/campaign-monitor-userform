<?php

/**
 * Custom dataobject specifically for Campaign Monitor Field Type
 *
 * @package campaign-monitor-userform
 */
class EditableCustomOption extends DataObject
{

    private static $default_sort = "Sort";

    private static $db = array(
        "Name" => "Varchar(255)",
        "Title" => "Varchar(255)",
        "Default" => "Boolean",
        "Sort" => "Int"
    );

    private static $has_one = array(
        "EditableCampaignMonitorField" => "EditableCampaignMonitorField",
    );

    private static $summary_fields = array(
        'Title',
        'Default'
    );

    /**
     * @param Member $member
     *
     * @return boolean
     */
    public function canEdit($member = null)
    {
        return ($this->EditableCampaignMonitorField()->canEdit($member));
    }

    /**
     * @param Member $member
     *
     * @return boolean
     */
    public function canDelete($member = null)
    {
        return ($this->EditableCampaignMonitorField()->canDelete($member));
    }

    public function getEscapedTitle()
    {
        return Convert::raw2att($this->Title);
    }
}
