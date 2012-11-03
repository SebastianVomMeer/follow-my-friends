<?php
require_once '/usr/share/php/PHPUnit/Framework/TestCase.php';
require_once '../follow-my-friends.php';

class FMF_AnchorStartingTagTest extends PHPUnit_Framework_TestCase {

	public function testGetHref() {
		$expectedHref = 'http://foo.bar#foo?foo=bar&foo=bar&amp;foo=bar';
		$this->assertThatStringEqualsHref(
			$expectedHref,
			'<a href="' . $expectedHref . '">'
		);

		$this->assertThatStringEqualsHref(
			null,
			'<a>'
		);

		$this->assertThatStringEqualsHref(
			'',
			'<a href="">'
		);
	}

	private function assertThatStringEqualsHref($expectedHrefString, $tagString) {
		$tag = new FMF_AnchorStartingTag($tagString);
		$this->assertEquals(
			$expectedHrefString,
			$tag->getHref()
		);
	}

	public function testSetRel() {
		$this->assertThatTagContainsRelValue(
			'<a href="#foo" rel="external nofollow">',
			'external'
		);
		$this->assertThatTagContainsRelValue(
			'<a href="#foo" rel="external nofollow">',
			'nofollow'
		);
		$this->assertThatTagDoesNotContainsRelAttribute(
			'<a href="#foo" rel="external nofollow">'
		);
	}

	private function assertThatTagContainsRelValue($tagString, $expectedRelValue) {
		$tag = new FMF_AnchorStartingTag($tagString);
		$tag->setRel($expectedRelValue);
		$this->assertTrue(
			strpos($tag->__toString(), $expectedRelValue) !== false
		);
		$tag = new FMF_AnchorStartingTag($tag->__toString());
		$this->assertEquals($expectedRelValue, $tag->getRel());
	}

	private function assertThatTagDoesNotContainsRelAttribute($tagString) {
		$tag = new FMF_AnchorStartingTag($tagString);
		$tag->setRel(null);
		$this->assertTrue(
			strpos($tag->__toString(), 'rel="') === false
		);
		$tag = new FMF_AnchorStartingTag($tag->__toString());
		$this->assertNull($tag->getRel());
	}
}