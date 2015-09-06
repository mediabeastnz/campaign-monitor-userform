#Campaign Monitor UserForm Field
Adds a custom field to UserForms which allows you to select a
list from campaign monitor, set custom fields and subscribe on submission.

### Installation
Via composer
```
composer require mediabeast/campaign-monitor-userform
```
#####Configuration
To connect to your campaign monitor field you will need to set two fields in your config.yml.
```
EditableCampaignMonitorField:
    api_key: 'API KEY GOES HERE'
    client_id: 'CLIENT ID GOES HERE'
```
^ These setting can be found in client settings area in Campaign Monitor.

#####Customisation
You can also change what type of field is actually used on the UserForm.
By Default it's a checkbox field. You can change this via your config.yml.
If you choose to use a dropwdown field you can add options under the Custom Options tab.
```
EditableCampaignMonitorField:
    defaultFieldType: 'DropdownField'
```
There are currently 3 extension hooks which can be useful to handle data before and after saving.
+ beforeValueFromData
+ afterValueFromData
+ updateLists

#### TODO
+ ~~add extension points e.g. Custom fields, change field type~~
+ Better error message is something goes wrong
+ ~~Added supoport for submission data e.g. Submission shows user was subscribed.~~

![field configuration example](http://i.imgur.com/3mBgSRq.png)
