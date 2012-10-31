<?php
require_once '/usr/share/php/PHPUnit/Framework/TestCase.php';
require_once '../follow-my-friends.php';

class FollowMyFriendsTest extends PHPUnit_Framework_TestCase {

	private $fmf;
	private $testText;

	public function setUp() {
		$this->fmf = new FollowMyFriends();
		$this->fmf->friendlyUrls = array(
			'http://sgaul.de',
			'http://picomol.de'
		);
		$this->testText = 'Lorem ipsum dolor sit <a href="http://w3c.org/foo/bar" rel="external nofollow">amet</a>,
		consetetur sadipscing elitr, sed <a href="http://sgaul.de/foo/bar" rel="external nofollow">diam</a>
		nonumy <a href="http://picomol.de/#foo?bar" rel="external nofollow">eirmod</a> tempor invidunt ut 
		labore et <a href="http://w3c.org/foo/bar" rel="external nofollow">dolore</a> magna aliquyam erat, 
		sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.';
	}

	public function testStartsWith() {
		$text = $this->fmf->removeNofollowFromFriendlyLinks($this->testText);
		die($text);
	}
}