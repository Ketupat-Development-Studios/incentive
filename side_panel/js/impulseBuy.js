function impulseBuy (name,priceObject) {
    this.name = name;
    this.priceObject = priceObject;
    this.rawPrice = parsePrice(priceObject.text());
    this.taxedPrice = NaN;
    this.inflatePrice = function(tax) {
    	this.taxedPrice = this.rawPrice*tax;
    	return this.taxedPrice;
    };

}

function parsePrice(raw){
	return Number(raw.replace(/[^0-9\.]+/g,""))
}