<?php
/* ArticlesTag Test cases generated on: 2011-06-03 19:50:48 : 1307123448*/
App::uses('ArticlesTag', 'Model');

/**
 * ArticlesTag Test Case
 *
 */
class ArticlesTagTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.articles_tag', 'app.article', 'app.user', 'app.tag');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->ArticlesTag = ClassRegistry::init('ArticlesTag');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ArticlesTag);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
