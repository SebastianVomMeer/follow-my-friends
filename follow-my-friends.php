<?php

class FollowMyFriends {

	public $friendlyUrls = array(
		'http://sgaul.de'
	);

	private $finder;

	public function __construct() {
		$this->finder = new AnchorTagFinder();
	}

	public function removeNofollowFromFriendlyLinks($text) {
		while ($tagString = $this->finder->findFirstTagInText($text)) {
			$tag = new AnchorStartingTag($tagString);
			foreach ($this->friendlyUrls as $url) {
				if (strpos($tag->getHref(), $url) === 0) {
					$tag->setRef('external');
					$text = str_replace($tagString, $tag->__toString, $text);
				}
			}
		}
		return $text;
	}

}

class AnchorTagFinder {

	/**
	 * Find first a tag, e.g. "<a href="">"
	 */
	public function findFirstTagInText($text) {
		$parts = explode('<', $text);
		foreach ($parts as $i => $part) {
			if ($i == 0) {
				continue;
			}
			if ($this->startsWith($part, 'a ')) {
				$tag = '<' . $part;
				$tag = $this->extractBeginningTag($tag);
				if ($tag !== null) {
					return $tag;
				}
			}
		}
		return null;
	}

	public function startsWith($haystack, $needle) {
		return (strpos($haystack, $needle) === 0);
	}

	/**
	 * Get the tag from the beginning of a string
	 * "<a href>Foo</a>..." => "<a href>"
	 */
	public function extractBeginningTag($htmlFramgent) {
		$parts = explode('>', $htmlFramgent);
		if (count($parts) > 1) {
			return $parts[0] . '>';
		} else {
			return null;
		}
	}

}

class AnchorStartingTag {

	private $tag;

	public function __construct($tag) {
		$this->tag = $tag;
	}

	public function getHref() {
		if (preg_match('/href="([^"]*)"/', $this->tag, $result)) {
			return $result[1];
		}
		return null;
	}

	public function getRel() {
		if (preg_match('/rel="([^"]*)"/', $this->tag, $result)) {
			return $result[1];
		}
		return null;
	}

	public function setRel($value) {
		if ($value != null) {
			$value = 'rel="' . $value . '"';
		}
		$this->tag = str_replace(
			'rel="' . $this->getRel() . '"',
			$value,
			$this->tag
		);
	}

	public function __toString() {
		return $this->tag;
	}

}
