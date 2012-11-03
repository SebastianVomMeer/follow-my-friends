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
		$this->testText = 'Lorem <a href="http://w3c.org/foo/bar" rel="external nofollow">amet</a>, \n\rsed <a href="http://sgaul.de/foo/bar" rel="external nofollow">diam</a> nonumy <a href="http://picomol.de/#foo?bar" rel="external nofollow">eirmod</a> temporet <a href="http://w3c.org/foo/bar" rel="external nofollow">dolore</a> magna.';
	}

	public function testRemoveNofollowFromFriendlyLinks() {
		$text = $this->fmf->removeNofollowFromFriendlyLinks($this->testText);
		// TODO replace manual test...
		echo $text;
	}
}