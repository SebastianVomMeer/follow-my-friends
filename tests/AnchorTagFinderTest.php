<?php
require_once '/usr/share/php/PHPUnit/Framework/TestCase.php';
require_once '../follow-my-friends.php';

class AnchorTagFinderTest extends PHPUnit_Framework_TestCase {

	private $finder;

	public function setUp() {
		$this->finder = new AnchorTagFinder();
	}

	public function testStartsWith() {
		$this->assertTrue($this->finder->startsWith('a href="">', 'a '));
		$this->assertFalse($this->finder->startsWith('<a href=""> ', 'a '));
		$this->assertFalse($this->finder->startsWith(' a href=""> ', 'a '));
	}

	public function testExtractBeginningTag() {
		$this->assertEquals(
			'<a href="foo">',
			$this->finder->extractBeginningTag('<a href="foo">anchor content')
		);
		$this->assertEquals(
			'<a href="foo">',
			$this->finder->extractBeginningTag('<a href="foo">')
		);
		$this->assertEquals(
			null,
			$this->finder->extractBeginningTag('<a href="foo"')
		);
	}

	public function testFindFirstTagInText() {
		// text to be tested => expected tag to be found
		$tests = array(
			'<a href="foo">Foo</a>' => '<a href="foo">',
			'bar <a href="foo">Foo bar</a> foo' => '<a href="foo">',
			'<b>bar</b>\nfoo<a href="foo">Foo bar</a> foo' => '<a href="foo">',
			'\n\n\n<a href="foo">Foo bar</a> foo' => '<a href="foo">'
		);
		foreach ($tests as $text => $expectedResult) {
			$this->assertEquals(
				$expectedResult,
				$this->finder->findFirstTagInText($text)
			);
		}
	}
}