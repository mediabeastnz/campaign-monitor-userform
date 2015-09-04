#campaign-monitor-userform
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

#### TODO
+ add extension points e.g. Custom fields, change field type
+ Better error message is something goes wrong
+ Added supoport for submission data e.g. Submission shows user was subscribed.
