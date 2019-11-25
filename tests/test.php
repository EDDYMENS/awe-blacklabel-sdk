<?php
/**
* Class and Function List:
* Function list:
* - setUp()
* - testGetPerformers()
* - testGetMorePerformers()
* - testGetPerformerAlbum()
* - testGetPerformerDetailsByName()
* - testGetAlbumItem()
* - testGeneralSearch()
* - testGetFilterList()
* - testGetLanguages()
* - testGetPerformerRecommendations()
* - testAuthenticateUser()
* - testUpdateUser()
* Classes list:
* - SDKTest extends TestCase
*/
namespace Awe\Blacklabel;
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
class SDKTest extends TestCase
  {
    private $config            = null;
    private $SDKInstance       = null;
    public function setUp()
      {
        $this->config = [
            'clientIP'         => '104.198.14.52',
            'applicationSecret'=> 'secret goes here', 
            'userAgent'        => 'Gecko',
            'language'         => 'en',
            'whiteLabelURL'    => 'URL goes here', 
          ];
        $this->SDKInstance = new SDK($this->config);
      }
    public function testGetPerformers()
      {
        $output            = $this
            ->SDKInstance
            ->getPerformers(['pageSize' => 10, 'category' => 'girls']);
        return $this->assertArrayHasKey('performers', $output['data']);
      }

    public function testGetMorePerformers()
      {
        $performer = $this
            ->SDKInstance
            ->getPerformers(['pageSize'           => 4, 'category'           => 'girls']);

        $output    = $this
            ->SDKInstance
            ->getMorePerformers($performer['data']['listPageId']);

        return $this->assertCount(27, $output['data']['performers']);
      }

    public function testGetPerformerAlbum()
      {

        $output = $this
            ->SDKInstance
            ->getPerformerAlbum('PrivateObsession', ['type' => 'image', 'privacy' => 'exclusive']);
        return $this->assertTrue($output['data']['albums'][0]['isLocked']);
      }

    public function testGetPerformerDetailsByName()
      {
        $output = $this
            ->SDKInstance
            ->getPerformerDetailsByName('PrivateObsession');
        return $this->assertGreaterthan(0, strlen($output['data']['bio']));
      }

    public function testGetAlbumItem()
      {
        $output = $this
            ->SDKInstance
            ->getAlbumItem('PrivateObsession', '5c897e0136b31ae756dc3afd');
        return $this->assertGreaterthan(0, count($output['data']['items']));
      }

    public function testGeneralSearch()
      {
        $output = $this
            ->SDKInstance
            ->generalSearch('adeleB');
        return $this->assertGreaterthan(0, count($output['data']['performers']));
      }

    public function testGetFilterList()
      {
        $output = $this
            ->SDKInstance
            ->getFilterList();
        return $this->assertGreaterthan(0, count($output['data']));
      }

    public function testGetLanguages()
      {
        $output = $this
            ->SDKInstance
            ->getLanguages();
        return $this->assertGreaterthan(0, count($output['data']['languages']));
      }

    public function testGetPerformerRecommendations()
      {
        $output = $this
            ->SDKInstance
            ->getPerformerRecommendations('girls');
        return $this->assertGreaterthan(0, count($output['data']['performers']));
      }

    public function testAuthenticateUser()
      {
        $output = $this
            ->SDKInstance
            ->authenticateUser(['partnerUserId' => '101', 'displayName' => 'John Doe', 'email' => 'test@test.com', ]);
        return $this->assertArrayHasKey("userType", $output['data']);
      }

    public function testUpdateUser()
      {
        $this
            ->SDKInstance
            ->setSession('session ID goes here');
        $output = $this
            ->SDKInstance
            ->updateUser(['partnerUserId' => '8689', 'displayName' => 'John Doe', 'email' => 'test@test.com', ]);
        // return $this->assertArrayHasKey("userType", $output);
        
      }

  }

