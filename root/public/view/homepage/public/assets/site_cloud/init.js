/*
 *
 * 百度推广
 * 获取网站流量信息
 *
 *  <script src="/assets/site_cloud/init.js"></script>
 *
 */

//网页的ssl状态
var curProtocol = window.location.protocol.split(':')[0];

/*
 * 即百度推广，页面URL会自动推送给百度
 * 有推送限制，经测试，同一ip同一页面自动推送两次之后就会出错
 * 单个页面每个用户每天只能自动推送两次
 */
(function() {
	var bp = document.createElement('script');

	if(curProtocol === 'https') {
		bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
	} else {
		bp.src = 'http://push.zhanzhang.baidu.com/push.js';
	}
	var s = document.getElementsByTagName("script")[0];
	s.parentNode.insertBefore(bp, s);
})();

/*
 * cnzz
 *统计网站访问情况
 * “document.write”不能在页面渲染完成之后执行，否则会覆盖网页的原本内容
 */
function cnzz() {
	var cnzz_protocol = curProtocol + "://";
	//基本样式
	//	document.write(unescape("%3Cspan hidden id='cnzz_stat_icon_1388976'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/stat.php%3Fid%3D1388976' type='text/javascript'%3E%3C/script%3E"));

//	$('body').prepend(unescape("%3Cspan hidden id='cnzz_stat_icon_1388976'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/stat.php%3Fid%3D1388976' type='text/javascript'%3E%3C/script%3E"))
	//	显示在线人数
	//	document.write(unescape("%3Cspan style='' id='cnzz_stat_icon_1388976'%3E%3C/span%3E%3Cscript src='" + curProtocol + "s11.cnzz.com/stat.php%3Fid%3D1388976%26online%3D2' type='text/javascript'%3E%3C/script%3E"));
	//显示所有信息
	//	document.write(unescape("%3Cspan id='cnzz_stat_icon_1388976'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/stat.php%3Fid%3D1388976%26online%3D1%26show%3Dline' type='text/javascript'%3E%3C/script%3E"));

	//隐藏cnzz默认按钮
	//	  $("[title='站长统计']").css("display", "none");


//部署异步统计代码
	var cnzz_s_tag = document.createElement('script');
	cnzz_s_tag.type = 'text/javascript';
	cnzz_s_tag.async = true;
	cnzz_s_tag.charset = 'utf-8';
	cnzz_s_tag.src = cnzz_protocol+'w.cnzz.com/c.php?id=1388976&async=1';
		var root_s = document.getElementsByTagName('script')[0];
	root_s.parentNode.insertBefore(cnzz_s_tag, root_s);

}

//qq统计
function qq_tj() {
	! function(g, d, t, e, v, n, s) {
		if(g.gdt) return;
		v = g.gdt = function() {
			v.tk ? v.tk.apply(v, arguments) : v.queue.push(arguments)
		};
		v.queue = [];
		n = d.createElement(t);
		n.async = !0;
		n.src = e;
		s = d.getElementsByTagName(t)[0];
		s.parentNode.insertBefore(n, s);
	}(window, document, 'script', '//qzonestyle.gtimg.cn/qzone/biz/gdt/dmp/user-action/gdtevent.min.js');
	gdt('init', '1106956980');
	gdt('track', 'PAGE_VIEW');

	$("<noscript>").appendTo("head");
	$("<img>")
		.attr({
			height: "1",
			width: "1",
			style: "display:none",
			src: curProtocol + "://a.gdt.qq.com/pixel?user_action_set_id=1106956980&action_type=PAGE_VIEW&noscript=1"
		})
		.appendTo("noscript");

}

cnzz();
$(function() {
	//	qq_tj();
})
