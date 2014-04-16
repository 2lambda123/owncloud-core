<?php
/**
 * Copyright (c) 2012 Bernhard Posselt <nukeawhale@gmail.com>
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */

class Test_App extends PHPUnit_Framework_TestCase {

	
	public function testIsAppVersionCompatibleSingleOCNumber(){
		$oc = array(4);
		$app = '4.0';

		$this->assertTrue(OC_App::isAppVersionCompatible($oc, $app));
	}

	
	public function testIsAppVersionCompatibleMultipleOCNumber(){
		$oc = array(4, 3, 1);
		$app = '4.3';

		$this->assertTrue(OC_App::isAppVersionCompatible($oc, $app));
	}


	public function testIsAppVersionCompatibleSingleNumber(){
		$oc = array(4);
		$app = '4';

		$this->assertTrue(OC_App::isAppVersionCompatible($oc, $app));
	}


	public function testIsAppVersionCompatibleSingleAppNumber(){
		$oc = array(4, 3);
		$app = '4';

		$this->assertTrue(OC_App::isAppVersionCompatible($oc, $app));
	}


	public function testIsAppVersionCompatibleComplex(){
		$oc = array(5, 0, 0);
		$app = '4.5.1';

		$this->assertTrue(OC_App::isAppVersionCompatible($oc, $app));
	}

	
	public function testIsAppVersionCompatibleShouldFail(){
		$oc = array(4, 3, 1);
		$app = '4.3.2';

		$this->assertFalse(OC_App::isAppVersionCompatible($oc, $app));
	}

	public function testIsAppVersionCompatibleShouldFailTwoVersionNumbers(){
		$oc = array(4, 3, 1);
		$app = '4.4';

		$this->assertFalse(OC_App::isAppVersionCompatible($oc, $app));
	}


	public function testIsAppVersionCompatibleShouldWorkForPreAlpha(){
		$oc = array(5, 0, 3);
		$app = '4.93';

		$this->assertTrue(OC_App::isAppVersionCompatible($oc, $app));
	}


	public function testIsAppVersionCompatibleShouldFailOneVersionNumbers(){
		$oc = array(4, 3, 1);
		$app = '5';

		$this->assertFalse(OC_App::isAppVersionCompatible($oc, $app));
	}

	/**
	 * Tests that the app order is correct
	 */
	public function testGetEnabledAppsIsSorted() {
		$apps = \OC_App::getEnabledApps(true);
		// copy array
		$sortedApps = $apps;
		sort($sortedApps);
		$this->assertEquals($sortedApps, $apps);
	}

	public function testGetAppInfo() {
		$info = OC_App::getAppInfo('files');
		$this->assertInternalType('array', $info);
		$this->assertArrayHasKey('id', $info);
		$this->assertArrayHasKey('name', $info);
		$this->assertArrayHasKey('remote', $info);
		$this->assertArrayHasKey('public', $info);
		$this->assertEquals('files', $info['id']);
	}

	public function testGetEnabledApps() {
		$enabledApps = OC_App::getEnabledApps();
		$this->assertInternalType('array', $enabledApps);
		$this->assertContains('files', $enabledApps);
	}

	public function testIsEnabled() {
		$this->assertTrue(OC_App::isEnabled('files'));
		$this->assertFalse(OC_App::isEnabled('files2'));
	}

	public function testEnableAndDisable() {
		$app = 'test12345';
		$this->assertFalse(OC_App::isEnabled($app));
		OC_App::getManager()->enableApp($app);
		$this->assertTrue(OC_App::isEnabled($app));
		OC_App::getManager()->disableApp($app);
		$this->assertFalse(OC_App::isEnabled($app));
	}

	public function testDisableEnableIsEnabled() {
		$this->assertTrue(OC_App::isEnabled('files'));
		$app = 'test12345';
		OC_App::getManager()->disableApp($app);
		OC_App::getManager()->enableApp($app);
		$this->assertTrue(OC_App::isEnabled('files'));
	}
}
