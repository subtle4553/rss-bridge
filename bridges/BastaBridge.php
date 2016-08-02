<?php
class BastaBridge extends BridgeAbstract{
	public function loadMetadatas() {
		$this->maintainer = "qwertygc";
		$this->name = "Bastamag Bridge";
		$this->uri = "http://www.bastamag.net/";
		$this->description = "Returns the newest articles.";
		$this->update = "2016-08-02";
	}
	
	public function collectData(array $param){
		$html = $this->file_get_html('http://www.bastamag.net/spip.php?page=backend') or $this->returnError('Could not request Bastamag.', 404);
		$limit = 0;

		foreach($html->find('item') as $element) {
			if($limit < 10) {
			$item = new \Item();
			$item->title = $element->find('title', 0)->innertext;
			$item->uri = $element->find('guid', 0)->plaintext;
			$item->timestamp = strtotime($element->find('pubDate', 0)->plaintext);
			$item->content = $this->file_get_html($item->uri)->find('div.texte', 0)->innertext;
			$this->items[] = $item;
			$limit++;
			}
		}
	}

	public function getName(){
		return 'Bastamag Bridge';
	}

	public function getURI(){
		return 'http://bastamag.net/';
	}

	public function getCacheDuration(){
		return 3600*2; // 2 hours
	}
}
?>