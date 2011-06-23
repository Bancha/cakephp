<?php
/* ExceptionsTest Test cases generated on: 2011-06-20 22:22:02 : 1308601322*/

App::uses('ExceptionsTestsController', 'Controller');
App::load('ExceptionsTestsController');

/**
 * TestExceptionsTest 
 *
 */
class TestExceptionsTest extends ExceptionsTestsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * ExceptionsTest Test Case
 *
 */
class ExceptionsTestTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.exceptions_test');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->ExceptionsTest = new TestExceptionsTest();
		$this->Exce->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ExceptionsTest);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
