<?php
/**
 * JqueryEngineTestCase
 *
 * PHP 5
 *
 * CakePHP : Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2006-2010, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright       Copyright 2006-2010, Cake Software Foundation, Inc.
 * @link            http://cakephp.org CakePHP Project
 * @package         cake.tests
 * @package         cake.tests.cases.views.helpers
 * @license         MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('HtmlHelper', 'View/Helper');
App::uses('JsHelper', 'View/Helper');
App::uses('JqueryEngineHelper', 'View/Helper');
App::uses('View', 'View');

class JqueryEngineHelperTest extends CakeTestCase {
/**
 * setUp
 *
 * @return void
 */
	function setUp() {
		parent::setUp();
		$controller = null;
		$this->View = $this->getMock('View', array('addScript'), array(&$controller));
		$this->Jquery = new JqueryEngineHelper($this->View);
	}

/**
 * tearDown
 *
 * @return void
 */
	function tearDown() {
		parent::tearDown();
		unset($this->Jquery);
	}

/**
 * test selector method
 *
 * @return void
 */
	function testSelector() {
		$result = $this->Jquery->get('#content');
		$this->assertEqual($result, $this->Jquery);
		$this->assertEqual($this->Jquery->selection, '$("#content")');

		$result = $this->Jquery->get('document');
		$this->assertEqual($result, $this->Jquery);
		$this->assertEqual($this->Jquery->selection, '$(document)');

		$result = $this->Jquery->get('window');
		$this->assertEqual($result, $this->Jquery);
		$this->assertEqual($this->Jquery->selection, '$(window)');

		$result = $this->Jquery->get('ul');
		$this->assertEqual($result, $this->Jquery);
		$this->assertEqual($this->Jquery->selection, '$("ul")');
	}

/**
 * test event binding
 *
 * @return void
 */
	function testEvent() {
		$this->Jquery->get('#myLink');
		$result = $this->Jquery->event('click', 'doClick', array('wrap' => false));
		$expected = '$("#myLink").bind("click", doClick);';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->event('click', '$(this).show();', array('stop' => false));
		$expected = '$("#myLink").bind("click", function (event) {$(this).show();});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->event('click', '$(this).hide();');
		$expected = '$("#myLink").bind("click", function (event) {$(this).hide();'."\n".'return false;});';
		$this->assertEqual($expected, $result);
	}

/**
 * test dom ready event creation
 *
 * @return void
 */
	function testDomReady() {
		$result = $this->Jquery->domReady('foo.name = "bar";');
		$expected = '$(document).ready(function () {foo.name = "bar";});';
		$this->assertEqual($expected, $result);
	}

/**
 * test Each method
 *
 * @return void
 */
	function testEach() {
		$this->Jquery->get('#foo');
		$result = $this->Jquery->each('$(this).hide();');
		$expected = '$("#foo").each(function () {$(this).hide();});';
		$this->assertEqual($expected, $result);
	}

/**
 * test Effect generation
 *
 * @return void
 */
	function testEffect() {
		$this->Jquery->get('#foo');
		$result = $this->Jquery->effect('show');
		$expected = '$("#foo").show();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->effect('hide');
		$expected = '$("#foo").hide();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->effect('hide', array('speed' => 'fast'));
		$expected = '$("#foo").hide("fast");';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->effect('fadeIn');
		$expected = '$("#foo").fadeIn();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->effect('fadeOut');
		$expected = '$("#foo").fadeOut();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->effect('slideIn');
		$expected = '$("#foo").slideDown();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->effect('slideOut');
		$expected = '$("#foo").slideUp();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->effect('slideDown');
		$expected = '$("#foo").slideDown();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->effect('slideUp');
		$expected = '$("#foo").slideUp();';
		$this->assertEqual($expected, $result);
	}

/**
 * Test Request Generation
 *
 * @return void
 */
	function testRequest() {
		$result = $this->Jquery->request(array('controller' => 'posts', 'action' => 'view', 1));
		$expected = '$.ajax({url:"\\/posts\\/view\\/1"});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->request(array('controller' => 'posts', 'action' => 'view', 1), array(
			'update' => '#content'
		));
		$expected = '$.ajax({dataType:"html", success:function (data, textStatus) {$("#content").html(data);}, url:"\/posts\/view\/1"});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->request('/people/edit/1', array(
			'method' => 'post',
			'before' => 'doBefore',
			'complete' => 'doComplete',
			'success' => 'doSuccess',
			'error' => 'handleError',
			'type' => 'json',
			'data' => array('name' => 'jim', 'height' => '185cm'),
			'wrapCallbacks' => false
		));
		$expected = '$.ajax({beforeSend:doBefore, complete:doComplete, data:"name=jim&height=185cm", dataType:"json", error:handleError, success:doSuccess, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->request('/people/edit/1', array(
			'update' => '#updated',
			'success' => 'doFoo',
			'method' => 'post',
			'wrapCallbacks' => false
		));
		$expected = '$.ajax({dataType:"html", success:function (data, textStatus) {doFoo$("#updated").html(data);}, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->request('/people/edit/1', array(
			'update' => '#updated',
			'success' => 'doFoo',
			'method' => 'post',
			'dataExpression' => true,
			'data' => '$("#someId").serialize()',
			'wrapCallbacks' => false
		));
		$expected = '$.ajax({data:$("#someId").serialize(), dataType:"html", success:function (data, textStatus) {doFoo$("#updated").html(data);}, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->request('/people/edit/1', array(
			'success' => 'doFoo',
			'before' => 'doBefore',
			'method' => 'post',
			'dataExpression' => true,
			'data' => '$("#someId").serialize()',
		));
		$expected = '$.ajax({beforeSend:function (XMLHttpRequest) {doBefore}, data:$("#someId").serialize(), success:function (data, textStatus) {doFoo}, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($expected, $result);
	}

/**
 * test that alternate jQuery object values work for request()
 *
 * @return void
 */
	function testRequestWithAlternateJqueryObject() {
		$this->Jquery->jQueryObject = '$j';

		$result = $this->Jquery->request('/people/edit/1', array(
			'update' => '#updated',
			'success' => 'doFoo',
			'method' => 'post',
			'dataExpression' => true,
			'data' => '$j("#someId").serialize()',
			'wrapCallbacks' => false
		));
		$expected = '$j.ajax({data:$j("#someId").serialize(), dataType:"html", success:function (data, textStatus) {doFoo$j("#updated").html(data);}, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($expected, $result);
	}

/**
 * test sortable list generation
 *
 * @return void
 */
	function testSortable() {
		$this->Jquery->get('#myList');
		$result = $this->Jquery->sortable(array(
			'distance' => 5,
			'containment' => 'parent',
			'start' => 'onStart',
			'complete' => 'onStop',
			'sort' => 'onSort',
			'wrapCallbacks' => false
		));
		$expected = '$("#myList").sortable({containment:"parent", distance:5, sort:onSort, start:onStart, stop:onStop});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->sortable(array(
			'distance' => 5,
			'containment' => 'parent',
			'start' => 'onStart',
			'complete' => 'onStop',
			'sort' => 'onSort',
		));
		$expected = '$("#myList").sortable({containment:"parent", distance:5, sort:function (event, ui) {onSort}, start:function (event, ui) {onStart}, stop:function (event, ui) {onStop}});';
		$this->assertEqual($expected, $result);
	}

/**
 * test drag() method
 *
 * @return void
 */
	function testDrag() {
		$this->Jquery->get('#element');
		$result = $this->Jquery->drag(array(
			'container' => '#content',
			'start' => 'onStart',
			'drag' => 'onDrag',
			'stop' => 'onStop',
			'snapGrid' => array(10, 10),
			'wrapCallbacks' => false
		));
		$expected = '$("#element").draggable({containment:"#content", drag:onDrag, grid:[10,10], start:onStart, stop:onStop});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->drag(array(
			'container' => '#content',
			'start' => 'onStart',
			'drag' => 'onDrag',
			'stop' => 'onStop',
			'snapGrid' => array(10, 10),
		));
		$expected = '$("#element").draggable({containment:"#content", drag:function (event, ui) {onDrag}, grid:[10,10], start:function (event, ui) {onStart}, stop:function (event, ui) {onStop}});';
		$this->assertEqual($expected, $result);
	}

/**
 * test drop() method
 *
 * @return void
 */
	function testDrop() {
		$this->Jquery->get('#element');
		$result = $this->Jquery->drop(array(
			'accept' => '.items',
			'hover' => 'onHover',
			'leave' => 'onExit',
			'drop' => 'onDrop',
			'wrapCallbacks' => false
		));
		$expected = '$("#element").droppable({accept:".items", drop:onDrop, out:onExit, over:onHover});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->drop(array(
			'accept' => '.items',
			'hover' => 'onHover',
			'leave' => 'onExit',
			'drop' => 'onDrop',
		));
		$expected = '$("#element").droppable({accept:".items", drop:function (event, ui) {onDrop}, out:function (event, ui) {onExit}, over:function (event, ui) {onHover}});';
		$this->assertEqual($expected, $result);
	}

/**
 * test slider generation
 *
 * @return void
 */
	function testSlider() {
		$this->Jquery->get('#element');
		$result = $this->Jquery->slider(array(
			'complete' => 'onComplete',
			'change' => 'onChange',
			'min' => 0,
			'max' => 10,
			'value' => 2,
			'direction' => 'vertical',
			'wrapCallbacks' => false
		));
		$expected = '$("#element").slider({change:onChange, max:10, min:0, orientation:"vertical", stop:onComplete, value:2});';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->slider(array(
			'complete' => 'onComplete',
			'change' => 'onChange',
			'min' => 0,
			'max' => 10,
			'value' => 2,
			'direction' => 'vertical',
		));
		$expected = '$("#element").slider({change:function (event, ui) {onChange}, max:10, min:0, orientation:"vertical", stop:function (event, ui) {onComplete}, value:2});';
		$this->assertEqual($expected, $result);
	}

/**
 * test the serializeForm method
 *
 * @return void
 */
	function testSerializeForm() {
		$this->Jquery->get('#element');
		$result = $this->Jquery->serializeForm(array('isForm' => false));
		$expected = '$("#element").closest("form").serialize();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->serializeForm(array('isForm' => true));
		$expected = '$("#element").serialize();';
		$this->assertEqual($expected, $result);

		$result = $this->Jquery->serializeForm(array('isForm' => false, 'inline' => true));
		$expected = '$("#element").closest("form").serialize()';
		$this->assertEqual($expected, $result);
	}
}
