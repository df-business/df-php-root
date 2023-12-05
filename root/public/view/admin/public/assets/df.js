/*
 *Dfer
 *
 *常用的js方法
 *
 *Version:  5.1
 *
 *Write by Df
 *Copyright (c) 2017-2027 Df
 *
 *
 *
 *
 * ----------------------bug整理
 * Js的变量和方法名字是区分大小写的，切记
 * $(...)xx is not a function //同时引用多个版本的jquery，或者js引用顺序不对，会出现此错误
 *
 *
 */

//-------------------------------------初始化

if(typeof define != 'undefined')
	//rJs模块
	define([], function() {
		return {
			log(x) {
				log(x, 'red');
			},
			init(x) {
				df_init();
			}
		}
	});

/*
 * 需要引入clipboard插件
 * <script src="/assets/clipboard.min.js"></script>
 * 复制字符串到剪贴板
 *  <button class="btn" data-clipboard-text="1">Copy</button>
 *  copyTxt('.btn')
 * 需要触发obj的点击事件
 *
 * https://github.com/zenorocha/clipboard.js
 */
function copyTxt(str,obj=null,id=null) {
	if(obj!=null)
	var clipboard = new obj(str,{container: document.getElementById(id)});
	else
	var clipboard = new ClipboardJS(str);

	clipboard.on('success', function(e) {
		console.log(e);
		alert('复制成功')
	});

	clipboard.on('error', function(e) {
		console.log('err',e);
	});

}

function df_init() {
	DfAttentionLog('★★★欢迎来到Df的站点★★★', '50', '#ffffff');
	log(["QQ", ":", "3504725309"], ["red", "#000000", "blue"]);
	log("http://dfer.top", "");
}

//查看网站流量
function cnzz() {
	log('http://new.cnzz.com/v1/login.php?siteid=1388976')
}

//原生动态加载js文件
function loadJs(url, callback) {
	var script = document.createElement('script');
	script.type = "text/javascript";
	if(typeof(callback) != "undefined") {
		if(script.readyState) {
			script.onreadystatechange = function() {
				if(script.readyState == "loaded" || script.readyState == "complete") {
					script.onreadystatechange = null;
					callback();
				}
			}
		} else {
			script.onload = function() {
				callback();
			}
		}
	}
	script.src = url;
	document.body.appendChild(script);
}

//获取对象类型
function type(obj) {
	//	log(obj)
	return typeof(obj);
}
//判断对象是否不存在或者未赋值或者为空
function empty(obj) {
	if(typeof obj == 'undefined' || obj == undefined || obj == '')
		return true;
	else
		return false;
}
//清空console
function clear() {
	console.clear()
}
/*
 * 在网页中加入一个动态消息框
 *
 * 消息框在显示完成之后会自动销毁
 *
 */
function message(msg, color = 'white') {
	var delay = 5000;
	var DivC = "message" + (new Date()).valueOf()
	$('body').append('<div class="publicColor ' + DivC + '" style="z-index:99999;opacity: 0;position: fixed;right: 15%;top:0%;color:' + color + '"></div>');
	var obj = $("." + DivC);
	obj.html(msg);
	obj.animate({
		opacity: 1,
		top: '25%'
	}, delay, 'swing', function() {
		obj.animate({
			opacity: 0,
			top: '50%'
		}, delay, 'linear', function() {
			obj.remove();
		});
	});

}

/*
 * 输出一些句子
 *
 */
function story(msg="忆经年，小楼初画夜雨寒。枯蝶残梦驻秋千，看落红凌乱。",color = "#00000066") {
	var delay = 3000;
	if(msg.indexOf("。")<0)
	arr=msg.split("，")
	else
	arr=msg.split("。")

	var num = 0;
	$(function() {

		t = setInterval(function() {
			message(arr[num], color);
			num++;
			if(num > arr.length)
				clearInterval(t);
		}, delay);

	})
}

////处理js错误
//window.onerror = function(msg, url, line, col, error) {
//	console.log(arguments) //打印所有错误信息
//	return false; //屏蔽js自动生成的错误信息
//}

/*
 * 改写弹窗
 * 文档加载完成之后执行
 *
 */
function layerInit() {
	document.write("<script type='text/javascript' src='/assets/layui/layer/layer.js'></script>"); //动态调用js文件
	$(function() {
		window.alert = layer.alert; //改写普通的alert
		//alert(1)
	});
}
/*alert花式用法
 * 模块加载的时候需要赋值调用
 *
 */
function alert1(layer) {
	layer.confirm('Df帅吗？', {
		btn: ['帅', '很帅'] //按钮
	}, function() {
		layer.msg('谢谢夸奖', {
			icon: 1
		}); //对应“/skin/default/icon.png”，从0开始排序，1代表图片里第二个图案
	}, function() {
		layer.confirm('荣幸之至！', {
			btn: ['客气了', '应该的']
		}, function() {
			layer.msg('呵呵', {
				icon: 1
			});

		}, function() {
			layer.confirm('陪我聊会儿天吧', {
				btn: ['好的', '不要']
			}, function() {
				layer.msg('加我QQ：573270407', {
					icon: 1,
					time: 60000, //30s后自动关闭
					btn: ['ok']
				});
			}, function() {

				layer.msg('那就不好意思了', {
					icon: 0
				});
				setTimeout(function() {
					//					"Scripts may close only the windows that were opened by it" (脚本只能关闭它所打开的窗口)

					//					window.opener = null;
					//					window.open('', '_self');
					//					window.close();
					//					open(location, '_self').close();
					hacker()
				}, 1000)

			});

		});
	});
}


/*
 *
 * 用画板显示黑客帝国字幕
 *
 *
 hacker({
			style: "position:unset;left:0;top:0;z-index:9",
			bottom:false
		});
 */
function hacker(paras = {}) {
	var chars = '0123456789',
		fontColor = '#0F0',
		style = 'position:fixed;left:0;top:0;z-index:9999999',
		delay = undefined,
		bottom = false;
	if(paras.hasOwnProperty("chars"))
		chars = paras["chars"];
	if(paras.hasOwnProperty("fontColor"))
		fontColor = paras["fontColor"];
	if(paras.hasOwnProperty("style"))
		style = paras["style"];
	if(paras.hasOwnProperty("delay"))
		delay = paras["delay"];
	if(paras.hasOwnProperty("bottom"))
		bottom = paras["bottom"];
	$('html').css('overflow', 'hidden')

	if(bottom)
		$("<canvas>").attr({
			id: "canvas",
			style: style
		}).appendTo("html");
	else
		$("<canvas>").attr({
			id: "canvas",
			style: style
		}).prependTo("html");

	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');

	canvas.height = window.innerHeight;
	canvas.width = window.innerWidth;

	var texts = chars.split('');

	var fontSize = 16;
	var columns = canvas.width / fontSize;
	// 用于计算输出文字时坐标，所以长度即为列数
	var drops = [];
	//初始值
	for(var x = 0; x < columns; x++) {
		drops[x] = 1;
	}

	function draw() {
		//让背景逐渐由透明到不透明
		ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
		ctx.fillRect(0, 0, canvas.width, canvas.height);
		//文字颜色
		ctx.fillStyle = fontColor;
		ctx.font = fontSize + 'px arial';
		//逐行输出文字
		for(var i = 0; i < drops.length; i++) {
			var text = texts[Math.floor(Math.random() * texts.length)];
			ctx.fillText(text, i * fontSize, drops[i] * fontSize);

			if(drops[i] * fontSize > canvas.height || Math.random() > 0.95) {
				drops[i] = 0;
			}

			drops[i]++;
		}
	}

	setInterval(draw, 33);

	function windowSize() {
		//获取屏幕可见区域的实际大小
		width = $(window).width();
		height = $(window).height();
		$("#canvas").css({
			'width': width,
			'height': height
		});
	}
	//窗体大小发生变化时重置容器的尺寸
	$(window).resize(function() {
		windowSize();
	});

	if(delay != undefined) {
		setTimeout(function() {
			$("#canvas").animate({
					opacity: 0
				}, delay, 'swing',
				function() {
					//必须取消，不然无法正常浏览
					$('html').css('overflow', 'auto')
					$("#canvas").remove()
				});

		})

	}

}

//对菜单的当前页面进行加深显示
function menu() {
	var url = window.location.href;
	var index = url.lastIndexOf("\/");
	url = url.substring(index + 1, url.length);
	switch(url) {
		case 'xxjs':
			$('#jsddm li').eq(1).css('background', '#0085da');
			break;
		case 'zk':
			$('#jsddm li').eq(2).css('background', '#0085da');
			break;
		case 'cj':
			$('#jsddm li').eq(3).css('background', '#0085da');
			break;
		case 'wj':
			$('#jsddm li').eq(4).css('background', '#0085da');
			break;
		case 'zzyjs':
			$('#jsddm li').eq(5).css('background', '#0085da');
			break;
		case 'lxwm':
			$('#jsddm li').eq(6).css('background', '#0085da');
			break;
		default:
			$('#jsddm li').eq(0).css('background', '#0085da');
			break;
	}
}

/*生成浮动的QQ联系窗口、滚动到页面顶端的按钮，可以添加多个类似的浮动窗口
 *
 */
function float_QQ() {

	/*自动生成一系列浮动窗口*/
	__BASE__ = "";
	document.write("<style type='text/css'>#full{width:88px; height:383px;}.qq_top{position:absolute; left:-45px; bottom:0}</style>");
	document.write("<div id=\"full\" style='right: 13px;bottom: 95px;position:fixed;z-index:100000000000;'>");
	document.write("<div class=\"qq_top\"> <img src='" + __BASE__ + "/images/float_top.gif'/></div>");
	document.write("<div class=\"qq_info\"><a href='tencent://message/?uin=427729597&Site=&Menu=yes'><img src='" + __BASE__ + "/images/float_QQ.jpg' /></a><!-- <a href='#'> <img src='" + __BASE__ + "/images/float_WeChat.jpg' /></a>--></div>");

	/*这一段表示的是 文字 和QQ ，如果你要添加N个QQ，就把上面的代码复制N次*/
	document.write("</div>");
	/*如果QQ在线的话，它会自动的变换成亮颜色。如果不在线它会自动变成灰色。这个可以不用控制它。
	    所有的样式都在第一个“document.write”里面，可以在里面更改所有的样式。

	*/
	$(".qq_top").css("cursor", "default")
	$(".qq_top").click(function() {
		$('body,html').animate({
			scrollTop: 0
		}, 400);
		return false;
	});

}

/*
 *
 *
 * var time = new Date().format("yyyy-MM-dd HH:mm:ss");
 * http://www.w3school.com.cn/jsref/jsref_obj_date.asp
 * 将date格式化
 * ok：本地时间格式；
 * date：日期；
 * time：时间；
 * full：日期加时间
 * date_list(Time,"ok")
 */
function date_list(v, x) {
	switch(x) {
		//toLocaleDateString按不同的国家设置不同的日期格式
		case "ok":
			var xx = new Date(parseInt(v.replace("/Date(", "").replace(")/", ""), 10)).toLocaleString();
			break;
		case "date":
			var xx = new Date(parseInt(v.replace("/Date(", "").replace(")/", ""), 10)).toLocaleDateString();
			break;
		case "time":
			var xx = new Date(parseInt(v.replace("/Date(", "").replace(")/", ""), 10)).toLocaleTimeString();
			break;
		case "full":
			var xx = new Date(parseInt(v.replace("/Date(", "").replace(")/", ""), 10)).toLocaleDateString() + new Date(parseInt(v.replace("/Date(", "").replace(")/", ""), 10)).toLocaleTimeString();
			break;
		default:
			var xx = "error";
	}
	return xx;
}

//将date格式化，截取年月日       //date_list(Time,"y")
function date_listC(v, x) {
	switch(x) {
		case 'y':
			var xx = new Date(parseInt(v.replace("/Date(", "").replace(")/", ""), 10)).getFullYear();
			break;
		case 'm':
			var xx = new Date(parseInt(v.replace("/Date(", "").replace(")/", ""), 10)).getMonth() + 1;
			break;
		case 'd':
			var xx = new Date(parseInt(v.replace("/Date(", "").replace(")/", ""), 10)).getDate();
			break;
	}
	return xx;
}

//获取当前时间，返回一个对象或者一个时间字符串
function datetimeNow(isObj) {
	var d = new Date();
	var timeN = {
		Year: d.getFullYear(), //获取当前年份
		Month: d.getMonth() + 1, //获取当前月份（0——11）
		Day: d.getDate(),
		Hour: d.getHours(),
		Minute: d.getMinutes(),
		Second: d.getSeconds()
	}
	if(isObj)
		return timeN;
	else //自动填充为国际规范的时间格式
		return timeN.Year + '-' + (timeN.Month < 10 ? "0" + timeN.Month : timeN.Month) + '-' + (timeN.Day < 10 ? "0" + timeN.Day : timeN.Day) + '-' + (timeN.Hour < 10 ? "0" + timeN.Hour : timeN.Hour) + '-' + (timeN.Minute < 10 ? "0" + timeN.Minute : timeN.Minute) + '-' + (timeN.Second < 10 ? "0" + timeN.Second : timeN.Second)
}

/*
 * 获取date的年月日
 *将长整型的时间转化为正常的时间格式
 *date_list(1489737842131, "ok")
 */
function date_FromLong(v, x) {
	switch(x) {
		case 'y':
			var xx = new Date(v).getFullYear();
			break;
		case 'm':
			var xx = new Date(v).getMonth() + 1;
			break;
		case 'd':
			var xx = new Date(v).getDate();
			break;
		case 'ok':
			var xx = new Date(v).getFullYear() + "年" + (new Date(v).getMonth() + 1) + "月" + new Date(v).getDate() + "日";
			break;
		default:
			var xx = new Date(v).toLocaleString();
			break; //完整的时间
	}
	return xx;
}

/*
 * 将纯数字的时间转化为正常的时间格式
 * date_截取("20170317145726");
 *
 */
function date_截取(v) {
	var year = v.substring(0, 4);
	var month = v.substring(4, 2);
	var day = v.substring(6, 2);
	var h = v.substring(8, 2);
	var m = v.substring(10, 2);
	var s = v.substring(12, 2);
	return year + "年" + month + "月" + day + "日" + h + "时" + m + "分" + s + "秒";
}

//判断是否为空或null
function isNullOrEmpty(val) {
	if(val == null || val == "")
		return true;
	else
		return false;
}

//判断是否是数字
function isNum(val) {
	if(!isNaN(val)) { //判断数字
		alert("是数字");
	} else {
		alert("不是数字");
	}
}

/*
 * 简洁异步传输
 *
 * js
 * var data = { a: 1, b: "1" };
 * action =function (js) { top.alert(js.msg); };
 *
 * c#
 * public JsonResult Url(string a,string b){var json=new df.asp_net.json();json.status =0;return Json(json, JsonRequestBehavior.AllowGet);}
 *
 *
 *
 */
function post(url, data, action, log = false) {
	//jquery写法
	$.post(url, data,
		function(x) {
			if(log)
				console.log(x)
			action(x);
		}
	);
}

//跨域写法，防止“ Access-Control-Allow-Origin”禁止访问
function post_ao(url, data, action) {

	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSONP',
		data: data, //字符串参数
		success: function(x) {
			//          	x=strToJson(x);
			console.log(x)
			action(x);
		}
	});
}

/*
 * action = [function () { top.alert("提现成功"); }, function (json) {if (json.msg == "")top.alert('提现出错'); else top.alert(json.msg);}];
 *action = [function (j) { top.alert(j.msg); }, function (j) { top.alert(j.msg); }]
 */
function post_y(url, data, action) {
	//默认调用普通异步
	var x = false;
	//详细异步
	if(x) {
		$.ajax({
			url: url,
			data: data,
			dataType: "json",
			type: "POST",
			async: true,
			success: function(json) {
				if(json.status > 0) {
					action[0](json);
				} else {
					action[1](json);
				}
			}
		});
	}
	//普通异步
	else {
		$.post(url, data,
			function(json) {
				json = strToJson(json);
				if(json.status > 0) {
					action[0](json);
				} else {
					action[1](json);
				}
			}
		);
	}
}

//同步请求
function post_t(url) {
	$.ajax({
		type: "post",
		url: url,
		async: false
	});
}

/*
 * 将json字符串转化为json对象
 */
function strToJson(str) {
	return JSON.parse(str);
}

/*
 * 异步传递form
 *
 * public JsonResult Url(string a,string b){var json=new df.asp_net.json();json.status =0;return Json(json, JsonRequestBehavior.AllowGet);}
 *
 */
function UrlPostForm(url, Form, action) {
	var data = $(Form).serialize();
	$.post(url, data,
		function(json) {
			console.log(json);
			if(json.status > 0) {
				action[0](json);
			} else {
				action[1](json);
			}
		}
	);

}

//弹窗确定事件
function tc(str, action) {
	alert(str, action());
}

//查找字符
function findStr(str, 查找的字符) {
	return str.indexOf(查找的字符);
}

//将字符串分割，并循环分割的每一个部分，执行函数
//var str="";
//StrSplitRun(value, "|", function (x) { str += SplitStr(x, ",", -3) + "/"; });
function StrSplitRun(str, 分隔符, 函数) {
	data = str.split(分隔符);
	for(var i = 0; i < data.length; i++) {
		函数(data[i]);
	}
}

function SplitStr(theString, 分隔符, 位置) {
	arr = theString.split(分隔符);
	if(位置 < 0)
		return arr[arr.length + 位置];
	return arr[位置];
}

//替换字符串尾部指定数目的字符
//用来隐藏手机号的后几位，粗略保护会员隐私，技术党F12搜索函数名下断点可以获得完整手机号
function HideStr(value) {
	if(value.length > 10)
		value = value.substring(0, value.length - 3) + "***";
	return value;
}

/*-------------------------------qui---------------------------------start
 * view df
 *
<link href="/js/modernBlue/style.css" rel="stylesheet" type="text/css" id="theme" themeColor="modernBlue" positionTarget="positionContent" selInputHeight="28" selButtonWidth="29" defaultSelWidth="160" fileBtnWidth="60" defaultFileInputWidth="222" defaultGridHeaderHeight="32" defaultGridRowHeight="32" defaultFontSize="14" defaultPageSelWidth="55" defaultFilterItemHeight="28" defaultFontFamily="微软雅黑" />
<script src="~/js/framework.js" ></script>
<script src="/js/quiGrid.js"></script>

//<div id="List"></div>
//c#
//public ActionResult df() {return View();}
//id：List
//url: '/Order/Order/GetList'
//sort: Id
//var _coumns = [{name: 'cardId', display: "卡号", isAllowHide: false, width: "20%", render: function (rowData, rowindex, value, column) { return '<a id=' + rowData.ID + '>' + value + '</a>'; }},{ name: 'money', display: "提现金额(元)", isAllowHide: false, width: "10%" }];
//click:false   //默认简单点击事件
//c#
/*
public JsonResult GetList(){ var json = new df.asp_net.json();
json.rows = db.fxlog.AsNoTracking().Select(v => v).Where(p => p.ID > 0 & p.cardId.Contains(Name)).ToList(); //linq
json.rows = SqlHelper.ExecuteDataset(WebConfig.HaiQiConnStrWebCfg, CommandType.Text, sql).Tables[0].ToList();    //Sql Select
return Json(json, JsonRequestBehavior.AllowGet);}
 *
 */
var _List;
//精简版qui（只用来显示数据）
function qui_pure(id, url, _columns) {
	var _menu;
	$(function() {
		_List = $("#" + id).quiGrid({ //qui主程序
			url: url,
			rownumbers: true,
			checkbox: false,
			height: '100%',
			width: "100%",
			pageSize: 20, //20条每页
			pageSizeOptions: [10, 20, 30, 40, 50],
			percentWidthMode: true,
			columns: _columns,
		});
	})
}

//复杂版qui（带有点击事件）
/*
qui("List", '/sys/master/GetList', "id", [{ name: 'MasterName', display: "账户昵称", isAllowHide: false, width: "20%" }]);  //click空置则代表该参数为false
mem = { items: [{ text: "add", iconClass: "icon_add", click: quiX.Add }, { line: true }, { text: "df", iconClass: "icon_user_worker", click: "df" }, { line: true }] };  //mem代表顶部菜单的内容
menujson = [{ "text": "删除", "icon": "icon_delete", "click": "del" }, { "text": "编辑", "icon": "icon_edit", "click": "edit" }];  //左键、右键菜单
*/
function qui(id, url, sort, _columns, click, mem) {
	var _menu;
	quiX = new quiC;
	if(mem == "" || mem == undefined)
		mem = {
			items: [{
				text: "add",
				iconClass: "icon_add",
				click: quiX.Add
			}, {
				line: true
			}, {
				text: "df",
				iconClass: "icon_user_worker",
				click: "df"
			}, {
				line: true
			}]
		};
	$(function() {
		_List = $("#" + id).quiGrid({ //qui主程序
			//  whenRClickToSelect: true,
			url: url,
			//sortName: "'" + sort + "'",
			rownumbers: true,
			checkbox: false,
			height: '100%',
			width: "100%",
			pageSize: 20, //20条每页
			pageSizeOptions: [10, 20, 30, 40, 50],
			percentWidthMode: true,
			columns: _columns,
			toolbar: mem, //顶部菜单
			onContextmenu: function(parm, e) {
				if(_menu != undefined)
					_menu.show({
						top: e.pageY,
						left: e.pageX
					});
				return false;
			}
		});
	})

	//菜单内容
	if(menujson == "" || menujson == undefined)
		menujson = [{
			"text": "删除",
			"icon": "icon_delete",
			"click": "del"
		}, {
			"text": "编辑",
			"icon": "icon_edit",
			"click": "edit"
		}];

	if(click == true) { //复杂点击事件

		//----------右键菜单--------------start
		InitRowContextMenu();

		function InitRowContextMenu() {
			var a = [];
			if(menujson.length == 0) {
				a.push({
					'id': "",
					'text': "df",
					iconClass: 'icon_delete'
				}); //当前操作员无列表操作权限
			} else {
				for(var i = 0; i < menujson.length; i++) {
					a.push({
						'id': menujson[i].click,
						'text': menujson[i].text,
						'click': itemclick
					});
				}
			}
			_menu = $.rightClickMenu({
				width: 155,
				items: a
			});
		};

		function itemclick(item, i) {
			quiX = new quiC;
			quiX.MemListColumnAction(item.id);
		}
		//----------右键菜单--------------end

		//---------------左键弹窗----------start
		$(function() { //在页面加载完之后执行
			$('.popupMenu_link').live('click', function() { //根据元素class绑定事件
				$(this).find('div').remove(); //删除元素
				if($(this).find('div').size() === 1) return; //存在则跳出
				$(this).append(iniPop()).find('.popupMenu_con').bind('mouseleave', function() {
					$(this).hide();
				}); //绑定鼠标事件
				$(this).find('div').show(); //显示元素
				var ost = $(this).find('div').offset(); //获取元素位置
				$(this).find('div').offset({
					left: ost.left - 87
				}); //设置元素位置
			});
		});

		function iniPop() {
			var html = '<div class="popupMenu_con icon_con" style=" margin-right: 0;">';
			for(var i = 0; i < menujson.length; i++) {
				html += '<a style="color:#06c;text-decoration:none;" href=\'javascript:quiX=new quiC;quiX.MemListColumnAction("' + menujson[i].click + '");\'><span class="' + menujson[i].icon + '">' + menujson[i].text + '</span></a>';
			}
			return html + '</div>';
		}
		_columns.push({ //数组添加一列
			'display': "操作",
			'width': "50",
			'render': function(rowData, rowindex, value, column) {
				return '<div class="popupMenu_link arrow border white_bg" ><a style="color:#06c;text-decoration:none;" href="javascript:;">' + "操作" + '</a></div>';
			}
		});
		//---------------左键弹窗----------end

	} else {
		//----------简单的点击事件----------start
		_columns.push({
			name: 'sh',
			display: "状态",
			width: "10%",
			render: function(rowdata, rowindex, value, column) {
				var val2 = "";
				switch(value) {
					case 0:
						val2 = "待审核";
						break;
					case 1:
						val2 = "审核通过";
						break;
					case 2:
						val2 = "审核失败";
						break;
				}
				return val2;
			}
		});

		_columns.push({
			'display': '通过审核',
			'width': "10%",
			render: function(rowData, rowindex, value, column) {
				if(rowData.sh == 1)
					return '<a style="color:#06c;text-decoration:none;" href="javascript:void(0);">已审核</a>';
				else
					return '<div class="popupMenu_link arrow border white_bg" ridx = ' + rowindex + '><a style="color:#06c;text-decoration:none;" href="javascript:quiX=new quiC;quiX.tg(\'' + rowData.ID + '\',\'' + rowData.data + '\',\'' + rowData.q + '\',\'' + rowData.m + '\',\'' + rowData.AllotCode + '\',\'' + rowData.OutShop + '\',\'' + rowData.InShop + '\',\'' + rowData.Remark + '\');">通过</a></div>';
			}
		});

		_columns.push({
			'display': '编辑',
			'width': "10%",
			render: function(rowData, rowindex, value, column) {
				return '<div class="popupMenu_link arrow border white_bg" ridx = ' + rowindex + '><a style="color:#06c;text-decoration:none;" href="javascript:quiX=new quiC;quiX.AlertWeb(\'' + rowindex + '\');">编辑</a></div>';
			}
		});

		//----------简单的点击事件----------end
	}
}

function quiC() { //包含了qui里需要调用的函数
	//qui弹窗里的点击事件
	this.MemListColumnAction = function(id) {
		var row = _List.getSelectedRow(); //获取当前选中的行的数据
		if(row == null) return;
		switch(id) {
			case "edit": //修改信息
				key = 9901; //memlistPage.ModelFn("Member.MemRegister");
				if(row.id != undefined) {
					//页面跳转
					top.om(9, "/qc/gz/?id=" + row.id);
				} else if(row.ID != undefined) {
					//网页弹窗
					_diag = new Dialog();
					_diag.Title = "df";
					_diag.Width = 500;
					_diag.Height = 400;
					_diag.URL = '/Member/BusinessAdjust/MemPoint?isLayer=1&id=' + row.Id;
					_diag.show();

				} else
					write(row + " →_→null");
				break;
			case "del": //删除
				top.Dialog.confirm("删除？", function() {
					$.post('/goods/StockAppropriation/del', {
						id: row.ID
					}, function(json) {
						top.alert(json.msg);
						quiX = new quiC;
						quiX.refresh();
					});
				});

				break;
			default:
		}
	}

	this.Add = function() {
		console.log("add");
		_diag = new Dialog();
		_diag.Title = "df";
		_diag.Width = 500;
		_diag.Height = 400;
		_diag.URL = '/df/df/ArEdi';
		_diag.show();
	}

	this.tg = function(ID, data, q, m, AllotCode, OutShop, InShop, Remark) {
		UrlPost("/Goods/StockAppropriation/TG", {
			ID: ID,
			data: data,
			q: q,
			m: m,
			AllotCode: AllotCode,
			OutShop: OutShop,
			InShop: InShop,
			Remark: Remark
		}, [function() {
			top.alert('已完成调拨');
			_List.loadData();
		}, function(json) {
			if(isNullOrEmpty(json.msg))
				top.alert('调拨出错');
			else top.alert(json.msg);
		}]);
	}

	//刷新qui
	/*
	可以跨框架调用，比如“quix = new top.quiC; quix.refresh();”
	*/
	this.refresh = function() {
		_List.loadData();
	}

	//用弹窗加载网页
	this.AlertWeb = function(row) {
		var _diag;
		var row = _List.getRow(row); //获取指定行的数据
		if(row == null) {
			top.Dialog.alert("null"); //http://localhost:5740/hqui/libs/js/dialog.js?v=1
		} else {
			_diag = new top.Dialog();
			_diag.Title = lan.zx;
			_diag.Width = 300;
			_diag.Height = 150;
			_diag.URL = "/Setup/Shop/ShopEdit?id=" + row.shopid;
			_diag.show();
		}
	}

	//简易用弹窗加载网页
	this.PureAlertWeb = function(title, src) {
		var _diag;
		_diag = new top.Dialog();
		_diag.Title = title;
		_diag.Width = 800;
		_diag.Height = 750;
		_diag.URL = src;
		_diag.show();

	}

}

/*
qui传递form里的内容到绑定的url里头
 https://github.com/citnvillareal/serializeObject
<script src="/js/serializeObject.js"></script>   //将form的内容转化为url参数
<form id="forms">
*/
function qui_post(form_id) {
	_List.setOptions({
		params: $('#' + form_id).serializeObject()
	});
	_List.setNewPage(1);
	_List.loadData();
};

//array = { CardID: $("#CardID").val() };
function qui_Easy_post(array) {
	_List.setOptions({
		params: array
	});
	_List.setNewPage(1);
	_List.loadData();
};

//延迟半秒关闭当前qui弹窗
var closeW = function(是否延迟) {
	if(是否延迟)
		setTimeout("top.Dialog.close()", 500);
	else
		top.Dialog.close();
}

/*hq= new  haiqi;hq.date_load();
 *
 *hq初始化
 */
function haiqi() {

	//<tr>
	//                     <td>@I18n.T("时间")：</td>
	//                     <td colspan="3">
	//                         <table class="">
	//                             <tr>
	//                                 <td>
	//                                     <input type="radio" id="" name="" value="1" checked="checked" /><label for="MemReg_BirthdayType1" class="hand">@I18n.T("公历")</label>

	//                                 </td>
	//                                 <td>
	//                                     <select id="MemReg_Birthday_Year" name="Year" keepdefaultstyle="true" selwidth="60" boxheight="200"></select>
	//                                     @I18n.T("年")
	//                                 </td>
	//                                 <td>
	//                                     <select id="MemReg_Birthday_Month" name="Month" keepdefaultstyle="true" selwidth="50" boxheight="200"></select>
	//                                     @I18n.T("月")
	//                                 </td>
	//                                 <td>
	//                                     <select id="MemReg_Birthday_Day" name="Day" keepdefaultstyle="true" selwidth="50" boxheight="200"></select>
	//                                     @I18n.T("日")
	//                                 </td>
	//                             </tr>
	//                         </table>
	//                     </td>
	//                 </tr>
	this.date_load = function() {
		var now = new Date();
		var year = now.getFullYear(); //年
		var _data = [];
		for(var i = 0; i < 100; i++) {
			var x = year - i;
			_data.push({
				"v": x,
				"t": x
			});
		}
		$("#MemReg_Birthday_Year").data("data", _data);
		$('#MemReg_Birthday_Year').render();
		$('#MemReg_Birthday_Year').setValue(2016);

		_data = [];
		for(var i = 0; i < 12; i++) {
			var x = 1 + i;
			_data.push({
				"v": x,
				"t": x
			});
		}
		$("#MemReg_Birthday_Month").data("data", _data);
		$('#MemReg_Birthday_Month').render();
		$('#MemReg_Birthday_Month').setValue(1);

		_data = [];
		for(var i = 0; i < 31; i++) {
			var x = 1 + i;
			_data.push({
				"v": x,
				"t": x
			});
		}
		$("#MemReg_Birthday_Day").data("data", _data);
		$("#MemReg_Birthday_Day").attr("selItemHeight", 10);

		$('#MemReg_Birthday_Day').render();
		$('#MemReg_Birthday_Day').setValue(1);
	}

	this.Empty_alert = function(id, txt0) {
		var txt = "不能为空";

		try {
			if($("#" + id).val() == "") {

				top.alert(txt0 + txt);
				return true;
			}
		} catch(e) {
			if($("#" + id).html() == "") {

				top.alert(txt0 + txt);
				return true;
			}
		}

	}

}

//change
function textChange(id, action) {
	$("#" + id).change(action)
}

//keypress
function keyPre(id, action) {
	$("#" + id).keypress(function(e) {
		var keyAscii = window.event ? e.keyCode : e.which;
		if(keyAscii == 13) {
			action
		}
	});
}

//keyup
function keyUp(id, action) {
	$('#' + id).keyup(
		action
	);
}

/*
 * 输出数据到js控制台
 *
 * log
 *
 * 可以设置颜色、大小
 *
 * 输出某种颜色的字符串到控制台
 * log("df","red")  //log(["df","fd"],["red","green"]);
 *
 */
function log(text, color, size = 33) {
	var t = "";
	var c = [];
	//多条数据根据颜色、尺寸输出
	if((text instanceof Array) && (color instanceof Array)) {
		for(var i = 0; i < text.length; i++) {
			t += "%c" + text[i];
		}
		c.push(t);
		for(var i = 0; i < text.length; i++) {
			if(typeof(color[i]) != "undefined")
				c.push("color:" + color[i]);
			else
				c.push("color:df");
		}
		console.log.apply(console, c);
	}
	//单条数据根据颜色、尺寸输出
	else if(color != undefined) {
		console.log("%c" + text, "color:" + color + ";font-size:" + size + 'px');
		//console.log("%c Df", "font-size:55px;color:red;-webkit-text-stroke: 0.5px orange;")
	}
	//普通输出
	else
		console.log(text)
}

function DfAttentionLog(str, font_size, color) { //以特定的格式打印“Df提示”，使用“ Unicode_JS 编码”和“ Unicode_JS 解码”
	if(str == undefined)
		str = 'Df提示'
	if(font_size == undefined)
		font_size = '150'
	if(color == undefined)
		color = 'red'
	console.log("%c " + str, "font-size:" + font_size + "px;color:" + color + ";-webkit-text-fill-color:" + color + ";-webkit-text-stroke: 1px orange;")
}

/*加减乘除
 *
 * JJCC([2222,2,20],"+")   //JJCC([2222,2,20])
 *
 */
function JJCC(num, style) {
	if(style == undefined)
		style = "+";
	var n;
	if(num instanceof Array) {
		if(num.length <= 1)
			return parseInt(num[0]);
		else {
			switch(style) {
				case "+":
					n = 0;
					for(var i = 0; i < num.length; i++) {
						n += parseInt(num[i]);
					};
					return n;
				case "-":
					n = parseInt(num[0]);
					for(var i = 1; i < num.length; i++) {
						n -= num[i];
					};
					return n;
				case "*":
					n = 1;
					for(var i = 0; i < num.length; i++) {
						n *= num[i];
					};
					return n;

				case "/":
					n = parseInt(num[0]);
					for(var i = 1; i < num.length; i++) {
						n /= num[i];
					};
					return n;
				default:
			}
		}
	} else return parseInt(num);
}

//函数动态获取参数
function ArgTest() {
	var i, s, numargs = arguments.length;
	s = numargs;
	if(numargs < 2)
		s += " argument was passed to ArgTest. It was ";
	else
		s += " arguments were passed to ArgTest. They were ";
	for(i = 0; i < numargs; i++) {
		s += arguments[i] + " ";
	}
	return(s);
}

/*
 *<form id ="SystemSetup_form"
Models.Info data = db.info.SingleOrDefault<Models.Info>(p => p.id == id); //linq
ViewBag.data=new System.Web.Script.Serialization.JavaScriptSerializer().Serialize(data);    //data是数据库的模型类，通过linq获取数据库的单条数据
Data=@Html.Raw(ViewBag.data)
formLoad('SystemSetup_form', Data);
formLoad('SystemSetup_form', Data,'img');
支持input和select，将单条数据库的数据加载到form里
*/
function FormLoad(FormId, Data, Type) {
	if(Type == undefined || Type == "")
		Type = "input";
	$(function() { //应该在网页加载完全之后给元素赋值
		var f = $('#' + FormId);
		switch(Type) {
			case "input":
				for(var i in Data) {
					var isexit = false;
					var el = f.find("input[name='" + i + "']");
					if(el && el.attr('type') === 'text') { //<input
						el.val(Data[i]);
						isexit = true;
					} else if(el && el.attr('type') === 'radio') { //<input
						el.each(function() {
							if($(this).val() == Data[i]) {
								$(this).attr("checked", true);
								isexit = true;
								return;
							}
						});
					} else if(el && el.attr('type') === 'checkbox') { //<input
						if(Data[i]) {
							el.attr("checked", true);
							isexit = true;
						} else {
							el.attr("checked", false);
							isexit = true;
						}
					} else if(el && el.attr('type') == undefined) { //<input
						el.val(Data[i]);
						isexit = true;
					}
					if(!isexit) {
						//<select
						var els = f.find("#" + i + "");
						if(els) {
							els.setValue(Data[i]);
						}
					}
				}
				break;
			case "img":
				for(var i in Data) {
					var els = f.find("#" + i + "");
					if(els) {
						els.attr("src", Data[i]);
					}
				}
				break;
			default:
		}
	})
}

/*
 *
 * -------------------操作iframe的详细函数
 */

/*
 * 调用父级frame的函数
 *
 */
function GetPaymentInfo() {
	var data = {
		isMemberPay: true,
		pay: $('#QuickConsume_DiscountMoney').val(),
		MemInfo: QuickConsume.MemInfo
	};
	return data;
}

function Frame_HQ() {
	var frames = parent.$('#' + parent.selectTabId).find("iframe")[0]; //获取父页面的指定元素里的iframe参数
	var data = frames.contentWindow.GetPaymentInfo(); //调用Iframe里的函数
}

//js
/*
运行frame里的函数（frame里的函数会在所处的frame的环境里运行）
*/
function RunFrameFunctionById(id, action, x) {
	document.getElementById(id).onload = function() { //在iframe加载完毕后执行
		$(this).contentWindow.action(x); //通过框架id调用框架内的函数
	}
}

function RunFrameFunctionByName(FrameName, action) {
	window.frames[FrameName].action(); //通过框架name调用框架内的函数

}

function RunParentFrameFunction(action) {
	parent.window.action(); //子页面调用父页面的函数
}

function RunPaOfParentFrameFunction(action) {
	window.parent.parent.window.action(); //调用上上级页面的函数
}

/*
获取iframe里的元素的值
*/
//根据框架Name和元素id获取属性,返回属性值   //GetIframeEleByName("df","dff","width")
function GetIframeEleByName(FrameName, ElementId, ElementAttr) {
	var x = $(window.frames[FrameName].document).find("#" + ElementId).attr(ElementAttr);
	if(x == "")
		x = $(window.frames[FrameName].document).find("#" + ElementAttr).find("input")[2].value;
	return x;

}

function Iframe(id, EleId) {
	//top代表多层Iframe里面最上面的一层
	console.log(top.$('#' + id)); //获取顶层页面下的某个元素
	console.log(top.$('#' + id).find("iframe")[0]); //获取第一个Iframe  //属于document，而document后面只能接contentWindow
	console.log(top.$('#' + id).find("iframe")[0].contentWindow); //获取Iframe内容里的元素的集合，contentWindow后面可以接具体的元素
	console.log(top.$('#' + id).find("iframe")[0].contentWindow.$("#" + EleId)); //获取Iframe里某个特定的元素
}
//获取框架上级页面元素的属性值
function GetParentFrameEleById(ParentElementId, ElementAttr) {
	return parent.$('#' + ParentElementId).attr(ElementAttr)
}

//获取框架上上级页面元素的属性值
function GetParentFrameEleById(ParentElementId, ElementAttr) {
	return parent.parent.$('#' + ParentElementId).attr(ElementAttr)
}

//根据框架id和元素id获取属性,返回属性值

function GetIframeEleById(FrameId, ElementId, ElementAttr) {
	$('#' + FrameId).load(function() {
		return $("#" + FrameId).contents().find("#" + ElementId).attr(ElementAttr) //$("#" + FrameId).contents() 获取指定元素的内容
		//相当于 return $("#" + FrameId).find("#" + ElementId).attr(ElementAttr)
		//元素后面可以接contents，而contents后面只能接find
	});
}
/*
<div id="baidumap" style="width:400px;height:500px;display:none;"><iframe style="display:block;margin:0 auto; width:300px;height:500px;" frameborder="0"></iframe> </div>
*/
function SetFrameSrc(id, src) {
	$('#' + id).find('iframe').attr('src', src); //设置frame的属性
	$('#' + id).show();
}
/*
在frame加载完成之后，自动根据frame里的内容的大小设置高度,跟本体页面完美结合
 <iframe src="/Setup/Shop/ShopEdit?id=0&Mid=2261" id="df" name="df" style="width:100%;"></iframe>
*/
function SetFrameHeight(FrameId) {
	document.getElementById(FrameId).onload = function() { //在iframe加载完毕后执行
		var mainheight = $(this).contents().height() + 30; //获取Iframe内容的高度
		$(this).height(mainheight); //设置Iframe高度
	}
}
//设置元素的高度，不赋值高度则获取元素的内容变换高度
function SetEleHeight(FrameId, mainheight) {
	if(mainheight == undefined || mainheight == "" || mainheight == null)
		var mainheight = $("#" + FrameId).contents().height() + 1;
	$("#" + FrameId).height(mainheight);
}

function IsLoadFrame(FrameId) {
	var x = false;
	$('#' + FrameId).load(function() {
		x = true;
	});
	return true;
}

//获取框架父级页面的元素
function SetParentEle(id) {
	console.log(parent.$("body").contents());
	var frames = parent.$("body").contents();
	frames.find("#" + id);
}
//获取框架父级页面的元素的值
function SetParentEleVal(id, value) {
	console.log(parent.$("body").contents());
	var frames = parent.$("body").contents();
	frames.find("#" + id).val(value);
}
//获取框架里的某个元素
function SetFrameEle(FrameId, EleId) {
	$('#' + FrameId).load(function() {
		return $("#" + FrameId).contents().find("#" + EleId);
	});
}

//禁用框架里的元素
function DisableFrameEle(FrameId, Ele) {
	$('#' + FrameId).load(function() {
		$("#" + FrameId).contents().find(Ele).attr("disabled", true);
	});
}

//动态添加div到body
function AddElementToBody(id, text) {
	$("body").append("<div id='" + id + "'></div>");
	$("#" + id).html(text);
	Set一堆样式("#" + id, {
		"position": "absolute",
		"left": "3px",
		"height": "150px",
		"color": "#ff0000",
		"top": "1px"
	}); //悬浮窗
}

//隐藏一个元素
function disP隐藏(Target) {
	$(Target).css("display", "none");
}
//根据id隐藏一个元素
function 隐藏(id) {
	$('#' + id).css("display", "none");
}

//根据id禁用一个元素
//disA禁用("button");
function disA禁用(Target) {
	$(Target).attr("disabled", "true");
}

//根据id设置元素的属性
//Set属性("input", "readonly", "true");
function Set属性(obj, name, value) {
	$(obj).attr(name, value);
}

//根据id获取元素的属性
//Get属性("RoleId1", "disabled");
function Get属性(obj, name) {
	return $("#" + obj).attr(name);
}

//根据id移除元素的属性
//Del属性("RoleId1", "disabled");  //disabled会导致控件失效
function Del属性(obj, name) {
	$('#' + obj).removeAttr(name);
}
//删除一个元素
//$('i')[3].remove()
function DelElement(Ele, num) {
	$(Ele)[num].remove();
}

/*根据id设置元素的样式
 *
 * Set样式("RoleId2", "display", "none");
 */
function Set样式(obj, name, value) {
	$('#' + obj).css(name, value);
}

//Attr = { "font-size": "8px", "background-color": "#8888888" };
function Set一堆样式(Obj, Attr) {
	$(Obj).css(Attr);
}
//获取元素的样式
function Get样式(obj, name) {
	return $('#' + obj).css(name);
}

//截取指定位置的字符串
//SplitStr(value, ",", -1);
function SplitStr(theString, 分隔符, 位置) {
	arr = theString.split(分隔符);
	if(位置 < 0)
		return arr[arr.length + 位置];
	return arr[位置];
}

//查找字符
function findStr(str, 查找的字符) {
	return str.indexOf(查找的字符);
}

//将字符串分割，并循环分割的每一个部分，将各个分割到的字符作为参数传递给函数并执行
//var str="";
//StrSplitRun(value, "|", function (x) { str += SplitStr(x, ",", -3) + "/"; });
function StrSplitRun(str, 分隔符, 函数) {
	data = str.split(分隔符);
	for(var i = 0; i < data.length; i++) {
		函数(data[i]);
	}
}

//关闭当前网页
function ClosePage() {
	window.close();
}

//判断是否使用了f12（浏览器调试工具）
function IsUseF12(func = function() {}, para1, para2) {

	document.onkeydown = document.onkeyup = document.onkeypress = function() {
		//		console.log('onkeydown', window.event.keyCode);
		if(window.event.keyCode == 123) {
			func(para1, para2)
			window.event.returnValue = false;
			return(false);
		}
	}

}

//屏蔽网页里的鼠标右键
function disableRightMouseKey() {
	document.onmousedown = function(e) {
		var msg = "欢迎光临寒舍，有什么需要帮忙的话，请与站长联系！谢谢您的合作！！！";
		//		console.log('onmousedown', event.button)
		if(event.button == 2 || event.button == 3) {
			if(typeof layer != 'undefined')
				layer.msg(msg);
			else
				alert(msg);
			document.oncontextmenu = new Function("return false;")
		}
	};

}

//获取某id下某一个元素,num从0开始
function FinEleByIdAndNum(id, num) {
	return $('#' + id).children().eq(num);
}

//根据元素名字获取一个元素
function FinEleByEleAndName(Ele, Name) {
	return $(Ele + "[name='" + Name + "']");
}
//输出被 jQuery 选择器匹配的元素的数量
function GetEleCountByEle(Ele) {
	return $(Ele).size(); //jquery-3.1.1将一些方法进行了修改
}

//显示中国省市区的js单选下拉框
/*
http://sc.chinaz.com/jiaobendemo.aspx?downloadid=0201630750211
<script src="/js/jquery-3.1.1.min.js" type="text/javascript"></script> //需要引用的jquery版本在“jQuery v1.11.0”之上
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="/js/全国各地区.js"></script>
<div id="distpicker">
<select></select>
<select></select>
<select></select>
</div>
*/
//获取当前下拉框选择的地址——0：获取省；1：获取市
function find中国省市区(num) {
	return $('#distpicker').children().eq(num).val();
}

//一个支持多选的下拉框
/*
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<link href="css/select2.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/select2.full.js"></script>

<select class="df-select" multiple="multiple" style="width: 75%">
</select>
<script type="text/javascript">
var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];
$(".df-select").select2({data:data});
</script>
*/
//http://www.cnblogs.com/liuxiaobo93/p/5112993.html
//http://select2.github.io/examples.html#data
//获取下拉框选择的项的编号
function SelectNum多选框() {
	return $(".df-select").val(); //获取项的内容
	//$(".df-select").select2().val([0,1,2]).trigger("change");   //添加项到输入框
	//$(".df-select").select2().val(['东城区','朝阳区']).trigger("change");
	//console.log($(".df-select").select2().val());    //输出项的名字
}
//获取下拉框选择的项
function SelectData多选框() {
	return $(".df-select").select2("data");
}

/*
支持多选的中国省市区下拉框
<form method="post" action='@(ViewBag.Id > 0 ? "/Sys/Master/Edit" : "/Sys/Master/Create")'>
 <td colspan="3" id="distpicker">
                <select style="width:22%;height:25px" name="sg"></select>
                <select style="width:22%;height:25px" name="si"></select>
                <select class="df-select" multiple="multiple" style="width:22%;"></select>
                <input name="qu" style="display:none" />
            </td>

</form>
*/
function MulCheckChinaPlace() {
	qu = SelectNum多选框();
	FinEleByEleAndName("input", "qu").val(qu);
	var Ccc = $('form').serializeObject();
	$.post($('form').attr('action'), Ccc, function(data) {})
}

function refresh() {
	location.reload();
}

/*
http://www.w3school.com.cn/jquery/event_change.asp
当元素的值发生改变时，会发生 change 事件。
该事件仅适用于文本域（text field），以及 textarea 和 select 元素
FindChangeById("RoleId", function () {  console.log($('#RoleId').val());});
*/

function FindChangeById(id, action) {
	$("#" + id).change(action);
}

/*
http://www.open-open.com/lib/view/open1418096000808.html
<script type="text/javascript" src="/js/timer.jquery.js"></script>
<div id="df" style="display:none"/>
*/
function timer(action) {
	//start a timer & execute a function in 5 minutes & 30 seconds
	$('#df').timer({
		duration: '3s',
		callback: function() {
			action();
			console.log("-------------");
		},
		repeat: true
	});

}

/*
获取一个元素指定属性的值
<div id="GoodsClass"  url="/Goods/GoodsList/GetClass" style="width: 200px; z-index: 506;" relvalue="3636"></div>*/
function getE() {
	$("#GoodsClass").attr("relvalue");
}

//-------------------------------百度地图---------------------------------start
/*
http://developer.baidu.com/map/jsdemo.htm#a1_2
自定义地图样式 http://developer.baidu.com/map/custom/
<div id="df"></div>
<style type="text/css">
#df {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}<!--这段样式不添加会导致地图不显示-->
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=k5Z56pTgQE0d0iHqQQtY0aBbZ7McmDBO">
//v2.0版本的引用方式：src="http://api.map.baidu.com/api?v=2.0&ak=您的密钥"
//v1.4版本及以前版本的引用方式：src="http://api.map.baidu.com/api?v=1.4&key=您的密钥&callback=initialize"
</script>
var map = new BMap.Map("df");          // 创建地图实例
*/

function MarkBdMap(x, y) { //BdMap(116.404, 39.915)     //根据经纬度在地图上标注一个位置

	map.setMapStyle({
		style: 'bluish'
	}); //设置地图风格
	var myIcon = new BMap.Icon("http://developer.baidu.com/map/jsdemo/img/fox.gif", new BMap.Size(300, 157)); //自定义图标

	var point = new BMap.Point(x, y); // 创建一个坐标（初始化地图时候的经纬度）
	map.centerAndZoom(point, 15); // 初始化地图，设置中心点坐标和地图缩放级别

	map.enableScrollWheelZoom(); //允许缩放
	map.addControl(new BMap.MapTypeControl({
		anchor: BMAP_ANCHOR_TOP_RIGHT
	})); //多种显示模式
	map.addControl(new BMap.NavigationControl()); //添加缩放平移控件
	map.addControl(new BMap.OverviewMapControl()); //缩略图
	map.addControl(new BMap.ScaleControl()); //添加比例尺控件

	var mk = new BMap.Marker(point, {
		icon: myIcon
	}); // 创建自定义图标的标注
	mk.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的标注
	map.addOverlay(mk); //添加标注
	map.panTo(point); //以某点为中心

}

function OnlineBdMap() { //根据浏览器定位地图
	//默认地图
	//	map.setMapStyle({
	//		//设置皮肤，参考网址：http://lbsyun.baidu.com/custom/list.htm
	//		style: 'googlelite'
	//	}); //设置地图风格

	//自定义地图

	map.setMapStyle({
		styleJson: [{
			"featureType": "land",
			"elementType": "geometry",
			"stylers": {
				"visibility": "on",
				"color": "#c7edcc"
			}
		}, {
			"featureType": "water",
			"elementType": "geometry",
			"stylers": {
				"visibility": "on",
				"color": "#4a90e2"
			}
		}]
	});
	var myIcon = new BMap.Icon("https://api.map.baidu.com/images/marker_red_sprite.png", new BMap.Size(300, 157)); //自定义图标
	//---------根据浏览器确定当前位置，进行定位--------begin
	var geolocation = new BMap.Geolocation(); //创建浏览器定位
	geolocation.getCurrentPosition(function(r) {
		if(this.getStatus() == BMAP_STATUS_SUCCESS) { //检索成功则执行
			map.centerAndZoom(r.point, 15); // 初始化地图，设置中心点坐标和地图缩放级别

			map.enableScrollWheelZoom(); //允许缩放
			map.addControl(new BMap.MapTypeControl({
				anchor: BMAP_ANCHOR_TOP_RIGHT
			})); //多种显示模式
			map.addControl(new BMap.NavigationControl()); //添加缩放平移控件
			map.addControl(new BMap.OverviewMapControl()); //缩略图
			map.addControl(new BMap.ScaleControl()); //添加比例尺控件

			Map.addMark(r.point); //添加标注
			//			console.log(r.point);
		} else {
			console.log('failed' + this.getStatus()); //返回状态码
		}
	});
	//---------根据浏览器确定当前位置，进行定位--------end

	// -----------------添加定位控件    -------------start
	//http://developer.baidu.com/map/reference/index.php?title=Class:%E6%8E%A7%E4%BB%B6%E7%B1%BB/GeolocationControlOptions
	var geolocationControl = new BMap.GeolocationControl({
		anchor: BMAP_ANCHOR_BOTTOM_LEFT,
		//		offset: new BMap.Size(10, 100),
		//		locationIcon: myIcon,
		enableAutoLocation: true
	});

	geolocationControl.addEventListener("locationSuccess", function(e) {
		// 定位成功事件
		var address = '';
		address += e.addressComponent.province;
		address += e.addressComponent.city;
		address += e.addressComponent.district;
		address += e.addressComponent.street;
		address += e.addressComponent.streetNumber;
		console.log("当前定位地址为：" + address);

	});
	geolocationControl.addEventListener("locationError", function(e) {
		// 定位失败事件
		console.log(e.message);
	});
	map.addControl(geolocationControl);
	// -----------------添加定位控件    -------------end

}

function Map() {
	var myIcon = new BMap.Icon("http://developer.baidu.com/map/jsdemo/img/fox.gif", new BMap.Size(300, 157)); //自定义图标

	//地图点击事件
	this.OnClick = function() {
		map.addEventListener('click', function(e) { //e包含了点击处的坐标
			console.clear();
			console.log(e);
			console.log('点击坐标: ' + e.point.lng + ', ' + e.point.lat); //获取经纬度
			//			map.clearOverlays(); //清除标注
			//			var mk = new BMap.Marker(e.point, {
			//				icon: myIcon
			//			}); //设置标注
			//			map.addOverlay(mk); //添加标注
			//			map.panTo(e.point); //移动指定位置到地图中心点
		});
	}

	//---------在指定坐标添加一个标注
	this.addMark = function(point) {
		var sContent =
			"<div>	<h4 style='margin:0 0 5px 0;padding:0.2em 0'>浏览器定位地址</h4>" +
			"<img style='float:right;margin:4px' id='imgDemo' src='' title=''/>" +
			"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em;float: left'>以当前网络服务商的基站地址为准（坐标：" + point.lng + "," + point.lat + ")</p>" +
			"</div>";
		var infoWindow = new BMap.InfoWindow(sContent); // 创建信息窗口对象

		var mk = new BMap.Marker(point, {
			title: ""
		}); //使用默认的图标

		map.addOverlay(mk); //添加标注
		mk.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的标注,浏览器定位的时候setAnimation必须放在addOverlay之后才能实现跳动效果
		map.panTo(point); //以某点为中心
		mk.addEventListener("click", function() {
			this.openInfoWindow(infoWindow);
		})
	}

	//-----------------创建带简介的标注
	/*
	var sContent =
	"<div>	<h4 style='margin:0 0 5px 0;padding:0.2em 0'>Dfer</h4>" +
	"<img style='float:right;margin:4px' id='imgDemo' src='http://www.95bl.com/js/s.png' width='139' height='104' title='天安门'/>" +
	"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'> 这网速，永远不知道从何卡起，又在什么时候结束，正所谓，十步卡一人，千里不留痕 ...</p>" +
	"</div>";
	Map.MarkPanel(111.326872, 30.739858, sContent);
	*/
	this.MarkPanel = function(x, y, sContent) {
		if(x == 0) {
			x = 111.30321250169;
			y = 30.703429510055;
			ico = new BMap.Icon("http://www.dfer.top/faviconMix.ico", new BMap.Size(33, 33));
		} else
			ico = myIcon;
		//-----------------创建带简介的标注---------begin

		var infoWindow = new BMap.InfoWindow(sContent); // 创建信息窗口对象
		var point = new BMap.Point(x, y);
		var marker = new BMap.Marker(point, {
			enableMassClear: false,
			shadow: ico,
			icon: ico,
			title: "跟Df来一场说走就走的旅行"
		});
		marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的标注
		map.addOverlay(marker);

		marker.addEventListener("click", function() {
			this.openInfoWindow(infoWindow);
		})
		//-----------------创建带简介的标注---------begin
	}

	//-----------------创建地图右键菜单
	this.OnClickRtButton = function() {
		//-----------------创建地图右键菜单---------begin
		var menu = new BMap.ContextMenu();
		var txtMenuItem = [ //创建选项
			{
				text: '放大',
				callback: function() {
					map.zoomIn()
				}
			}, {
				text: '缩小',
				callback: function() {
					map.zoomOut()
				}
			}
		];
		for(var i = 0; i < txtMenuItem.length; i++) {
			menu.addItem(new BMap.MenuItem(txtMenuItem[i].text, txtMenuItem[i].callback, 100)); //加载选项到右键菜单
		}
		map.addEventListener("tilesloaded", function() {
			//			console.log("地图加载完毕——添加右键菜单");
			map.addContextMenu(menu); //添加右键菜单到地图
		});
		//-----------------创建地图右键菜单---------end
	}

	this.Loading = function() {
		//------显示地图加载进度的div-------begin
		$("body").append("<div id='map_Loading'></div>");
		$("body").append("<div id='shadow'></div><div id='copyright'>陌上炊烟寥寥起，一壶浊酒醉平生——by Df</div>");
		$("#map_Loading").html("地图加载中...");
		Set一堆样式("#map_Loading", {
			"position": "absolute",
			"left": "3px",
			"height": "150px",
			"color": "#ff0000",
			"top": "1px"
		});
		Set一堆样式("#copyright", {
			"position": "absolute",
			"left": "0px",
			"height": "",
			"background": "rgb(0, 0, 0)",
			"color": "rgb(17, 241, 105)",
			"bottom": "0px",
			"width": "100%",
			"text-align": "right"
		});
		Set一堆样式("#shadow", {
			"position": "absolute",
			"left": "3px",
			"height": "30px",
			"width": "180px",
			"background": "rgb(0, 0, 0)",
			"bottom": "22px",
			"display": "none"
		});
		//------显示地图加载进度-------end

		//--------------地图加载完成之后执行-------------begin
		map.addEventListener("tilesloaded", function() {
			//			console.log("地图加载完毕");
			隐藏("map_Loading"); //加载完成之后隐藏
		});
		//--------------地图加载完成之后执行-------------end
	}
}

// 用经纬度设置地图中心点（移动到指定位置）和标注
function SetLocation(x, y) {
	if(x != "" && y != "") {
		var point = new BMap.Point(x, y); // 创建一个坐标（初始化地图时候的经纬度）
		map.centerAndZoom(point, 15); // 初始化地图，设置中心点坐标和地图缩放级别

		map.enableScrollWheelZoom(); //允许缩放
		map.addControl(new BMap.MapTypeControl({
			anchor: BMAP_ANCHOR_TOP_RIGHT
		})); //多种显示模式
		map.addControl(new BMap.NavigationControl()); //添加缩放平移控件
		map.addControl(new BMap.OverviewMapControl()); //缩略图
		map.addControl(new BMap.ScaleControl()); //添加比例尺控件

		var marker = new BMap.Marker(point); // 创建标注
		marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的标注
		map.addOverlay(marker); // 将标注添加到地图中
		map.panTo(new_point); //以某个坐标为地图中心点
	} else
		console.log("location!!!");
}

//-------------------------------百度地图---------------------------------end

//-------------------------------文本编辑框---------------------------------------------------------start
/*
<script src="/js/ueditor/ueditor.config.js"></script>
<script src="/js/ueditor/ueditor.all.js"></script>
                                <script name="text" id="bmaEditor" type="text/plain">
                                    @Html.Raw(Model.text)
                            </script>

*/

function ueditor() {
	UE.Editor.prototype._bkGetActionUrl = UE.Editor.prototype.getActionUrl;
	UE.Editor.prototype.getActionUrl = function(action) {
		if(action == "config") {
			return "/Tools.ashx?operation=ueconfig";
		} else {
			return "/Tools.ashx?operation=uploadstoredescription";
		}
	}
	UE.getEditor('bmaEditor');
}

//-------------------------------文本编辑框---------------------------------------------------------end

//判断鼠标是否移入某个控件
function MouseEvent(EleId, TaId) {
	$(function() {
		$("#" + EleId).hover(
			function() { //鼠标移入
				console.log("```");
				//$(this).show();
				$("#" + TaId).show();
			},
			function() { //鼠标移出
				//  $(this).hide();
				$("#" + TaId).hide()
			});
	})
}

//带抉择的弹窗
function TcChoice(弹窗内容, 触发函数) {
	top.Dialog.confirm(弹窗内容, 触发函数); //不要用“触发函数()”
}

//批量设置元素内容的显示长度，并且将元素内容设置为提示文字
function SetEleLenAndTitle(len) {
	$(function() {
		//var len = 50;
		var ele = $("body").find(".hot");
		$("body").find(".hot").each(function() { //获取一个元素集合
			$(this).attr("title", $(this).html());
			var EleLen = $(this).html().length;
			if(EleLen > len)
				$(this).html($(this).html().substr(0, len));
			//alert(EleLen);
		})
	})
}

//使元素获得焦点
function FocusEle(id) {
	$("#" + id)[0].focus()
}

//定义个对象
function SetObject() {
	//定义一个对象
	var ObjPanel = {
		ListData: {}, //定义数组
		Clear: function() {
			MemberPanel_Clear();
		}, //定义函数  调用：ObjPanel.Clear();
		IsSanKe: false, //bool变量        //调用:ObjPanel.IsSanKe
		MemState: undefined, //定义模糊变量
		data: {
			Id: 168704,
			CardID: "11",
			CardName: "1234",
			Mobile: "",
			Level: 272
		}, //定义对象  Object {Id: 168704, CardID: "11", CardName: "1234", Mobile: "", Level: 2729…}  //调用:ObjPanel.da.Id
		HideMemberInfoPanel: function() {
			$("#Panel_MemberInfo").css("display", "none");
		} //定义函数
	};
}

//设置所有的a标签的链接地址，带筛选
function SetA(Ele) {
	$(function() {
		Ele = $(Ele).find("a");
		for(var i = 0; i < Ele.length; i++) {
			if((i + 1) % 4 != 0)
				Ele[i].href = "javascript:;";
		}
	})
}

//调用js计时器
/*
Timer(function(){alert(123);}, 3, true); //循环
Timer(function(){alert(123);}, 3);//不循环
*/
function Timer(action, second, Loop) {
	var Id;
	if(Loop)
		Id = setInterval(action(), second * 1000); //在指定的间隔重复执行指定函数，不考虑函数是否执行完
	else
		Id = setTimeout(action(), second * 1000); //在指定的间隔执行一次指定函数，会在函数执行完成之后继续下面的操作
	return Id;
}

//stop
function ClearTimer(id, loop) {
	if(loop)
		clearInterval(id); //停止timer
	else
		clearTimeout(id);

}

//打开一个新的网页
function blank_web(src) {
	window.open(src);
}

//页面跳转
function turn_web(src) {
	window.location.href = src;
}

//点击事件函数
function Click(id, action) {
	$('#' + id).click(action())
}

//iframe隐藏边框
function iframeShadowBorder() {
	$(function() {
		$("iframe").attr("frameborder", "no");
	})
}

//用于制作菜单
/*
点击菜单中的一个元素之后，该元素变色，页面主体加载相应的内容
将多个内容简单的页面放到一个页面里通过点击菜单进行加载
*/
function MenuClick() {
	$(".tab1 span").click(function() {
		$(".tab1 span").css({
			"color": "#666"
		});
		$(this).css({
			"color": "#009ce0"
		});
		var num = $(this).index();
		$(".tabpages1 .tabpage1").hide()
		$(".tabpages1 .tabpage1").eq(num).show();
	});
}

//根据屏幕尺寸隐藏元素
function ShadowEleByScreenScale(maxwidth) {
	_sw = $(window).width(); // $(document.body).width();
	_sh = $(window).height() - 100;
	if(_sw < maxwidth) {
		$('#logo').hide();
	}
}

//-------------------------------cookie-----------------------------------------------------------------------------------start
function getCookie(name) {
	var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
	if(arr = document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}

function setCookie(c_name, value, expiredays) //setCookie("na",1,-1)表示删除
{
	if(expiredays == undefined)
		expiredays = 1; //默认保存一天
	var exdate = new Date()
	exdate.setDate(exdate.getDate() + expiredays)
	document.cookie = c_name + "=" + escape(value) +
		((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; path=/"; //“ path=/”定义全局cookie
}

function GetAllCookie() {
	var strCookie = document.cookie; //这将获得该域名下的所有cookie。
	return strCookie;
}

function delCookie(name) { //删除cookie
	setCookie(name, "", -1);
}
//-------------------------------cookie-------------------------------------------------------------------end

//-------------------------------------Js原生拓展方法-------------------------------start
//——————————————————————原生js
//原生js使用Object的拓展方法会导致jq出错

/* String转化为Number
 * eg:
 * '333'.ToInt()
 */
String.prototype.ToInt = function() {
	return isNaN(parseInt(this)) ? this.toString() : parseInt(this);
};

/*将str转为Num，小数点后保留指定数目的数字，没有四舍五入
 * eg：
 * '123.33'.ToDecimal(3)
 */
String.prototype.ToDecimal = function(n) {
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
Number.prototype.Round = function(fractiondigits) {
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
	if(arguments.length == 0) return this;
	var param = arguments[0];
	var s = this;
	if(typeof(param) == 'object') {
		for(var key in param)
			s = s.replace(new RegExp("\\{" + key + "\\}", "g"), param[key]);
		return s;
	} else {
		for(var i = 0; i < arguments.length; i++)
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

//-------------------------------------Js拓展方法-------------------------------end

console.log("df loaded");
