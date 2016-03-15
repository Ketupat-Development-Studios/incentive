function impulseBuy (name,priceObject) {
    this.name = name;
    this.priceObject = priceObject;
    this.rawPrice = parsePrice(priceObject.text());
    this.taxedPrice = NaN;
    this.itemId = NaN;
    this.deleteID = NaN;
    this.category = NaN;
    this.inflatePrice = function(tax) {
    	this.taxedPrice = this.rawPrice+this.rawPrice*tax;
    	return this.taxedPrice;
    };
    this.setItemId = function(itemid){
    	return this.itemId = itemid;
    }
    this.setCategory = function(category){
        return this.category = category;
    }

}

function parsePrice(raw){
	return Number(raw.replace(/[^0-9\.]+/g,""))
}