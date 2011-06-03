<?php
/* Article Test cases generated on: 2011-06-03 19:50:43 : 1307123443*/
App::uses('Article', 'Model');

/**
 * Article Test Case
 *
 */
class ArticleTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.article', 'app.user', 'app.tag', 'app.articles_tag');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Article = ClassRegistry::init('Article');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Article);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
