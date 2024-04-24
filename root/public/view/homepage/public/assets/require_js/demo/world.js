//调用内部函数和外部函数

show = function() {
	$('body').html(
		"hello！\
		这是一个测试文件\
		用来测试requirejs的用法\
		\
		");
}

define([], function() {
	'use strict';
	return {
		world() {
			animal();
			show();
		}
	}
});

