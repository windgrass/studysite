# 大纲
利用image测试网速/上报数据
CSS远程攻击漏洞
iframe对远程localStorage扩容
html语义化的重要性

a file icons/vscode-icon
node写错了变红

## img 的一些好玩用法
<img crossorigin="anonymous" />
设置跨域的属性

### 上报数据
ajax并发成本高,一般浏览器是5个ajax并发
采用gif的小图片,直接通过分析access日志
```
function shujufenxi() {
    var img = new Image();
    image.src = "https://www.baidu.com/statis.gif?uid=123&country=china&city=shenzhen&.....";
    /* 
    通过服务器上, 分析access日志, 就可以得出结果
    统计不要用ajax, 因为ajax的并发有限制(很多浏览器是5个并发限制), 成本也比较高
        */
}
```

### 测试网速
```
function imgcesu() {
    var start = Date.now();
    var img = new Image();
    // 图片大小 8.8KB
    img.src = "https://timgsa.baidu.com/timg?image.jpg";
    img.onload = function () {
        var end = Date.now();
        console.log(start, end);
        var speed = 8.8 / (start - end) / 1000;
        console.log(speed);
    }
    /* 
    应用: 2倍图是否加载,根据网速来判断
    */
}
```


# CSS漏洞攻击
xss攻击   

带url的, 都可能会返回一个js代码,来注入攻击

```css
.bgxss {
    background: url('javascript:alert(333)');
}
.gbxss::content {
    content: url('javascript:alert(333)');
}
.gbxss::before {
    content: url('javascript:alert(333)')
}
<span class="bgxss"></span>
```
dom很珍贵, 尽量少用dom元素. 用伪元素 css是靠GPU来渲染的 dom是cpu来加载的


# JSONP 跨域原理
```js
<script>
    function test(data) {
        console.log(data);
    }
    // 在php中 echo json_encode(['name'=>'dog', 'age'=>'2']);
</script>
<script src="http://127.0.0.1:8081/test.php"></script>
```

`<img src="图片">` 代码压缩成图片, `jstopng`小工具，可以实现转换

采用 jstopng 的方式,生成一个图标,在客户端再解开图标里面的代码

# iframe 通信

localstorage 只有5M的大小, 这个域名下面的不够用就去其他的域名下面借用

iframe 跨域下, 无法操作dom, 但是可以 postMessage

iframe远程修改localStorage
```js
<script>
    // 页面A
    document.getElementById('my-iframe').postMessage('data', 'values');
    // 页面B
    window.addEventListener('message', function (e) {
        var data = e.data;
        document.querySelector('p').innerHTML = data;
    }, false);
</script>
```

# HTML语义话的重要性
语义话标签
html5.js 兼容低版本的浏览器

```html
<header>这里是头部</header>
<nav>导航栏</nav>
<aside>侧边栏</aside>
<article>
    文章主题
    <section>第一段</section>
    <section>第二段</section>
</article>
<footer>底部</footer>
```

