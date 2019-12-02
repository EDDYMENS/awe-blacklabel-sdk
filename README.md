# AWE PHP SDK

<!-- [![Codacy Badge](https://api.codacy.com/project/badge/Grade/989042d96d2b42b28d98c0c098bceeef)](https://app.codacy.com/app/EDDYMENS/awe-html-kit?utm_source=github.com&utm_medium=referral&utm_content=EDDYMENS/awe-html-kit&utm_campaign=Badge_Grade_Dashboard) -->

[![StyleCI](https://github.styleci.io/repos/223872088/shield?branch=master)](https://github.styleci.io/repos/223872088)

The AWE PHP SDK is a PHP wrapper for the blacklabel API offering of  [AWEmpire API](http://awempire.com).

## Requirements

- PHP: >=7.1
- phpunit/phpunit: 6.* (dev)

## Setup 
- git clone https://github.com/EDDYMENS/awe-blacklabel-sdk.git
- composer install
## Methods 
### Instantiation 
```PHP
 $this->config = [
            'clientIP'         => '104.198.14.52',
            'applicationSecret'=> 'secret goes here',
            'userAgent'        => 'Gecko',
            'language'         => 'en',
            'whiteLabelURL'    => 'URL goes here',
          ];
$this->SDKInstance = new SDK($this->config);
```
### getPerformers
Fetch the bios of models. 
EG:
```PHP
$output = $this
            ->SDKInstance
            ->getPerformers(['pageSize' => 10, 'category' => 'girls']);

```
### getMorePerformers
Get extra model bios. 
EG:
```PHP
$output = $this
            ->SDKInstance
            ->getMorePerformers($performer['data']['listPageId']);
```

### getPerformerDetailsByName
Get more bio details of a specific model. 
EG:
```PHP 
$output = $this
            ->SDKInstance
            $response = $SDKInstance->getPerformerDetailsByName('MaiRare');
```
### getPerformerAlbum
Get album content of a model. 
EG: 
```PHP 
$output = $this
            ->SDKInstance
            ->getPerformerAlbum('PrivateObsession', ['type' => 'image', 'privacy' => 'exclusive']);
```
### getPerformerVideos
Get video only content of model 
EG: 
```PHP 
coming soon ...
```
### getAlbumItem
Get Album content of model.
EG: 
```PHP 
$output = $this
            ->SDKInstance
            ->getAlbumItem('PrivateObsession', '5c897e0136b31ae756dc3afd');
```
### generalSearch
Search for models. 
EG: 
```PHP 
$output = $this
            ->SDKInstance
            ->generalSearch('adeleB');
```
### getFilterList
Get list of categories and filters 
EG:
```PHP 
$output = $this
            ->SDKInstance
            ->getFilterList();
```
### setLanguage
Change the language for data sent back 
EG: 
```PHP 
$output = $this
            ->SDKInstance
            ->setLanguage('fr');
```
### refreshSession
Refresh and reuse an expired session. 
EG: 
```PHP 
$output = $this
            ->SDKInstance
            ->refreshSession('<session goes here>');
```
### setSession
For requests where member sessions are required like the updateUser method
you will have to set the session with what you get back from authenticateUser.
EG: 
```PHP 
$output = $this
            ->SDKInstance
            ->setSession('<session goes here>');
```
### getPerformerRecommendations
EG: 
```PHP 
 $output = $this
            ->SDKInstance
            ->getPerformerRecommendations('girls');
```
### authenticateUser
Authenticate user and get back a purchase URL.
EG: 
```PHP 
$output = $this
            ->SDKInstance
            ->authenticateUser(['partnerUserId' => '101', 'displayName' => 'John Doe', 'email' => 'test@test.com']);
```
### updateUser
Update a member users profile. 
EG: 
```PHP 
$output = $this
            ->SDKInstance
            ->updateUser(['partnerUserId' => '8689', 'displayName' => 'John Doe', 'email' => 'test@test.com']);
```
### getChatScript
EG: 
```PHP 
  $response = $SDKInstance->getChatscript("AdeleBlake", "vid", 'g5679b10435a7ff3449c76e44aa1d27a1',
        $primaryButtonBg = null, $primaryButtonColor = null, $inputBg = null, $inputColor = null);
```
## Run test
- cd src 
- $ cp tests/.env-example tests/.env (Change credentials)
- ./vendor/phpunit/phpunit/phpunit  tests/test.php
## TODO
- Add puchase method
- Test user update 
- Test session refresh
- Test getPerformerVideos
- Document getPerformerVideos

## Support 
Incase you need help with the SDK please contact your account manager :)