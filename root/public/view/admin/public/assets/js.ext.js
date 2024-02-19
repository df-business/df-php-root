/**
 *
 * js原生拓展方法
 *
 * By Df
 */

/* String转化为Number
 * eg:
 * '333'.toInt()
 */
String.prototype.toInt = function() {
	return isNaN(parseInt(this)) ? this.toString() : parseInt(this);
};

/*将str转为Num，小数点后保留指定数目的数字，没有四舍五入
 * eg：
 * '123.33'.ToDecimal(3)
 */
String.prototype.toDecimal = function(n) {
	num = new Number(this);
	console.log(num.toFixed(n));
	return num.toFixed(n);
}

/*
 * 四舍五入保留指定位数的小数
 * eg：
 * 四舍五入保留2位小数
 * money.Round(2)
 *
 * 123.123.Round(1)
 */
Number.prototype.round = function(fractiondigits) {
	var returnN;
	with(Math) {
		returnN = round(this * pow(10, fractiondigits)) / pow(10, fractiondigits);
	}
	console.log(returnN);
	return returnN;
}

/*
 * js占位符组装字符串
 * eg:
 * var str = "js实现用{two}自符串替换占位符{two} {three}  {one} ".format({one: "I",two: "LOVE",three: "YOU"});
 * var str2 = "js实现用{1}自符串替换占位符{1} {2}  {0} ".format("I","LOVE","YOU");
 */
String.prototype.format = function() {
	if (arguments.length == 0) return this;
	var param = arguments[0];
	var s = this;
	if (typeof(param) == 'object') {
		for (var key in param)
			s = s.replace(new RegExp("\\{" + key + "\\}", "g"), param[key]);
		return s;
	} else {
		for (var i = 0; i < arguments.length; i++)
			s = s.replace(new RegExp("\\{" + i + "\\}", "g"), arguments[i]);
		return s;
	}
}

/*判断字符串是否为空
 * eg:"".isEmpty()
 */
String.prototype.isEmpty = function() {
	var t = this.toString();
	return t == "";
};

console.log("jsExt 加载完成");
