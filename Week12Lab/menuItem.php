<?php
class menuItem {
	// Properties
	protected $itemName;
	protected $description;
	protected $price;

	// Constructor
	public function __construct($itemName, $description, $price) {
	// use 'this' keyword to access methods in this class
	$this->setItemName($itemName);
	$this->setDescription($description);
	$this->setPrice($price);
	}

	// Getters/setters for all properties
	public function getItemName() { return $this->itemName;}
	public function setItemName($anitemName) {$this->itemName = $anitemName;}

	public function getDescription() {return $this->description;}
	public function setDescription($description) {$this->description = $description;}

	public function getPrice() {return $this->price;}
	public function setPrice($price) {$this->price = $price;}
}
?>
