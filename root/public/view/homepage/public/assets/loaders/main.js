/*
 * 
 
<script type="text/javascript" src="./loaders/jquery.min.js"></script>
<script type="text/javascript" src="/assets/loaders/main.js"></script>
 
 * *
 * 页面加载效果
 * 同时添加遮罩层，防止用户在页面加载完成前点击页面
 * h5加载效果，非图片
 * 同一个页面只能加载一次onload，所以要统一调用
 * $(window).load(function(){
		Clearloader();
	})
 * 
 */

function loading(type) {
	$(function() {

		if(type == undefined) {

			//载入css文件
			$("<link>")
				.attr({
					rel: "stylesheet",
					type: "text/css",
					href: "/assets/loaders/main.css",
					onload: ""
				})
				.appendTo("head");

			$('body').prepend('<div class="loader">\
    <div class="loader-inner ball-spin-fade-loader">\
      <div></div>\
      <div></div>\
      <div></div>\
      <div></div>\
      <div></div>\
      <div></div>\
      <div></div>\
      <div></div>\
    </div>\
 </div>\
 <div class="dfer_loading"></div>');

			//调整元素
			setTimeout(function() {
				//	$('.dfer_loading').hide();//隐藏遮罩
				$(".loader").animate({
					opacity: 1,
					'top': '10%',
					'left': '90%'
				}, 1500);
				$(".loader div").css({
					'background': '#666'
				});
			}, 1000)

		} else if(type == 1) {
			$(".dfer_loading").remove() //移除遮罩
		} else if(type == 2) {
			$(".loader").remove() //移除加载圈
		} else if(type == 0) {
			//清除
			$(".loader").remove() //移除加载圈
			$(".dfer_loading").remove() //移除遮罩
		}
	})

}

// loading()
console.log("loaders loaded");