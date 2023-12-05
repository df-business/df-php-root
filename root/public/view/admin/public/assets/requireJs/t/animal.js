//定义一个对象
define([], function() {
	'use strict';
	//私有方法
	function _showName(name) {
		console.log(name);
	}
	return {
		say(words) {
			console.log(words);
		},
		showName(name) {
			_showName(name);
		}
	}
});