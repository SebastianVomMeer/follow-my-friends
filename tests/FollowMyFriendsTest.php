<?php
require_once '/usr/share/php/PHPUnit/Framework/TestCase.php';
require_once '../follow-my-friends.php';

class FollowMyFriendsTest extends PHPUnit_Framework_TestCase {

	private $fmf;
	private $testText;

	public function testRemoveNofollowFromFriendlyLinksWithDoubleQuotes() {
		$this->initDependencies('"');
		$text = $this->fmf->removeNofollowFromFriendlyLinks($this->testText);
		$this->assertTrue(strpos($text, 'href="http://w3c.org/foo/bar" rel="external nofollow"') == true, 'unexpected anchor for w3c.org');
		$this->assertTrue(strpos($text, '<a href="http://sgaul.de/foo/bar" rel="external">') == true, 'unexpected anchor for sgaul.de');
		$this->assertTrue(strpos($text, '<a href="http://picomol.de/#foo?bar" rel="external">') == true, 'unexpected anchor for picomol.de');
	}

	public function testRemoveNofollowFromFriendlyLinksWithSingleQuotes() {
		$this->initDependencies("'");
		$text = $this->fmf->removeNofollowFromFriendlyLinks($this->testText);
		$this->assertTrue(strpos($text, "href='http://w3c.org/foo/bar' rel='external nofollow'") == true, 'unexpected anchor for w3c.org');
		$this->assertTrue(strpos($text, "<a href='http://sgaul.de/foo/bar' rel='external'>") == true, 'unexpected anchor for sgaul.de');
		$this->assertTrue(strpos($text, "<a href='http://picomol.de/#foo?bar' rel='external'>") == true, 'unexpected anchor for picomol.de');
	}

	public function initDependencies($attributeDelimiter) {
		$this->fmf = new FollowMyFriends(
			new FMF_AnchorStartingTagFactory($attributeDelimiter)
		);
		$this->fmf->friendlyUrls = array(
			'http://sgaul.de',
			'http://picomol.de'
		);
		$this->testText = 'Lorem <a href=' . $attributeDelimiter . 'http://w3c.org/foo/bar' . $attributeDelimiter . ' rel=' . $attributeDelimiter . 'external nofollow' . $attributeDelimiter . '>amet</a>, \n\rsed <a href=' . $attributeDelimiter . 'http://sgaul.de/foo/bar' . $attributeDelimiter . ' rel=' . $attributeDelimiter . 'external nofollow' . $attributeDelimiter . '>diam</a> nonumy <a href=' . $attributeDelimiter . 'http://picomol.de/#foo?bar' . $attributeDelimiter . ' rel=' . $attributeDelimiter . 'external nofollow' . $attributeDelimiter . '>eirmod</a> temporet <a href=' . $attributeDelimiter . 'http://w3c.org/foo/bar' . $attributeDelimiter . ' rel=' . $attributeDelimiter . 'external nofollow' . $attributeDelimiter . '>dolore</a> magna.';
	}
}