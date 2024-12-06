# RequireJS

## 介绍

RequireJS 是一个JavaScript模块加载器。它非常适合在浏览器中使用, 它非常适合在浏览器中使用，但它也可以用在其他脚本环境, 就像 Rhino and Node. 使用RequireJS加载模块化脚本将提高代码的加载速度和质量。

IE 6+ .......... 兼容 ✔
Firefox 2+ ..... 兼容 ✔
Safari 3.2+ .... 兼容 ✔
Chrome 3+ ...... 兼容 ✔
Opera 10+ ...... 兼容 ✔



可以根据依赖关系统一调用js文件，一个页面一个script标签就够了

灵活地将script文件根据依赖关系进行排版



require.js主要解决两个问题：

1、实现js的异步加载,避免js太多加载响应时间太多导致网站超时，
2、管理模块之间的依赖性,便于编写与维护。


## 参考
//官网
https://requirejs.org/

//官网下载
https://requirejs.org/docs/download.html#requirejs

//中文官网
http://www.requirejs.cn/docs/download.html

//帮助
http://www.requirejs.cn/docs/start.html



//拓展文件
https://github.com/guybedford?tab=repositories



 ## 研究草稿


 *
 *
 * 不同版本jq不兼容，如果是用老版本jq开发的，最好不要同时调用新版本的
 *
 * 并不是所有页面都适合用rJS，要根据实际情况确定是否使用，不要为了用rJs而用rJs
 *
 *
 * 这个属于异步加载，加载的js文件的内容只在首次加载的时候调用window的load方法，如果需要每次都触发，则应该把需要触发的load内容用模块的方式返回给主函数，用主函数的load方法统一调用
 *
 *






 * 首次访问或者禁用缓存时，数据运行是正常的流程：dom和res加载完毕之后触发onload，这个时候代码的执行和数据的加载是同步执行的
 * 浏览器缓存之后，dom和res是默认已经加载完毕的，数据运行就不是正常的流程：onload触发之后js还在运行，这个时候数据加载和代码执行是异步的

* 经测试，requireJs的顶层js文件在缓存下也是能够调用到的，所以不用单独引用jq，可见页面在缓存下运行了表层的js之后才执行onload，至于js内部的异步处理，则不在onload的监测范围内
 *
 * 因为缓存之后，onload会异步于requireJs，所以需要在onload重新引用相关的js文件




 * 属于异步调用
 * 只适合加载能够适应异步调用的文件，有些js函数不支持异步调用就不适合使用requireJs
 *
 * 可以调用模块里面和外面的函数
 *
 * 当前文件组里的内容不加载完成不会进行下一步
 *
 *
 * require多次调用同一js，不会重复引用
 *
 * 有缓存之后chrome会直接跳过rJs中js的"window.onload",所以为了确保万无一失而将"window.onload"放到引用到的js文件之外

 * head中的script排序可能跟手写的顺序不一样，但是js内部是按照依赖关系依次调用的，不影响使用
 *
 *
 * 有缓存，在首次访问之后，会自动缓存，缓存数据之后，模块里的onload方法不会触发，如果需要每次访问都调用onload，则需要在requireJs之外使用onload
 *
 * 配合“end.js”使用，弥补requireJs在onload上的不足
