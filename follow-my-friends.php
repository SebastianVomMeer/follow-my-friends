<?php
class ElementStartingTag {

	private $tag;

	public function __construct($tag) {
		// todo
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
