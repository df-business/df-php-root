$(function() {
	//  //载入css文件
	$("<link>")
		.attr({
			rel: "stylesheet",
			type: "text/css",
			href: "/assets/fontFamily/customFont.css",
			onload: ""
		})
		.appendTo("head");
	//
	//
	//  //载入自定义字体预加载模块
	$("<df>")
		.attr({
			class: "myFont",
			style: 'color:rgba(1,1,1,0)'
		}).html(0)
		.appendTo("body"); //模块里必须有字符，否则字体不会加载

	fontFamily_switch = true;
	console.log('自定义字体在拼命加载中...')
})
