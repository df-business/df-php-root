/*
 * requireJs的初始界面
 *
 *
 *
 * 这里定义所有需要引用的文件
 *
 * 在share文件进行引用
 */
//基本参数

var url = '/assets/';
require.config({
	//版本信息，会自动放到所有加载的文件之后，用来保证首次访问都会刷新缓存
	urlArgs: 'v=' + (new Date()).getTime(),
	//所有文件都会以此路径进行加载
	baseUrl: url,
	//引用其余路径的文件
	paths: {
		//public
		jq: 'jquery.min',
		df: 'df', //自定义函数
		siteCloud: 'siteCloud/init', //流量统计初始化
		layui: 'layui/layui', //
		fontFamily: 'fontFamily/init', //自定义字体文件的初始化
		loaders: 'loaders/main', //加载效果初始化
		mui: 'mui/mui.min', //wap网页框架
		jqTemplate: 'jqTemplate/jquery.tmpl', //动态加载数据的框架
		mui_Ext: 'mui/func', //关于mui的自定义函数
		jqExt: 'jquery.ext', //jq拓展方法
		//homepage
		homepage: 'homepage/js/init'

	},
	//载入rJs的css.js
	map: {
		'*': {
			'css': 'requireJs/css'
		}
	},
	shim: {
		'mui': {
			deps: ['css!/assets/mui/mui.min']
		},
		'layui': {
			deps: ['css!/assets/layui/css/layui']
		},
		//homepage
		'homepage': {
			deps: ['css!/assets/homepage/css/init']
		}

	}

});
