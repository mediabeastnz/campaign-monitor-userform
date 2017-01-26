#Campaign Monitor UserForm Field
Adds a custom field to UserForms which allows you to select a
list from campaign monitor, set custom fields and subscribe on submission.

### Installation
Via composer
```
composer require mediabeast/campaign-monitor-userform
```
##### Configuration
To connect to your campaign monitor field you will need to set two fields in your config.yml.
```
EditableCampaignMonitorField:
    api_key: 'API KEY GOES HERE'
    client_id: 'CLIENT ID GOES HERE'
```
^ These setting can be found in client settings area in Campaign Monitor.

##### Customisation
You can also change what type of field is actually used on the UserForm.
By Default it's a checkbox field. You can change this via your config.yml OR via the CMS per form.
If you choose to use a DropdownField you can add options under the Custom Options tab.
```
EditableCampaignMonitorField:
    defaultFieldType: 'DropdownField'
```

##### Adding Custom Fields
You can integrate your campaigns custom fields with the fields on your form.
To do so you must name the field(s) with the prefix 'customfields_', so for example if your custom field was
called `interests` then the field name on your form must be named `customfield_interests`.
The module will automatically push all fields to Campaign Monitor if there's a match.
Note: there are a few caveats here e.g. you have to ensure if a field is required then it needs to be required at both ends.

##### Extensions
There are a few extension hooks which can be useful to handle data before and after saving throughout the process.
+ `$this->extend('beforeValueFromData', $data)`
+ `$this->extend('afterValueFromData', $data)`
+ `$this->extend('updateLists', $data)`
+ `$this->extend('updateCustomFields', $custom_fields)`


![field configuration example](http://i.imgur.com/3mBgSRq.png)
