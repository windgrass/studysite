
try aplly 原型链
this call clousur with 


# IIFE

Immediately-Invoked Function Expression
```js
(function(){})();
```


--------------------------------------------
# ES6 是会计作用域

在{} 里面的就是块, 用 let 声明




## 块作用域的兼容实现原理??

ES6的 `let` 声明的变量块级作用域

用 try { } catch 模拟
```js
if (true) {
    let a = 1;
    try {
        throw 1;
    } catch (a) {
        alert(a);
    }
}
```

> let先使用后声明的问题???


## with会延长作用域链

没有的值会创建一个
```js
var yideng = {
    a: 1
};
with(yideng) {
    b: 2;
}
alert(b); // undefined 因为只有存在的变量才会复制, 不存在会执行语句, 导致全局里面生成了一个 b
```


--------------------------------------------
# 对象

引用类型, 变量里面保存的是对象的指针, 再赋值对象后之后是个新的指针


--------------------------------------------
# 变量提升

函数声明提升的优先级 > 变量提升
变量的赋值, 会保留当前的词法作用域

```
function a() {};
var a; // 声明会被忽略

a = 1; // 赋值保留当前词法作用域

```

--------------------------------------------
# vo对象, ao对象


--------------------------------------------
# 闭包内存回收

闭包执行的时候, 有引用到当前环境的变量, 内存就会保存该变量
没有引用任何变量, 执行完了会垃圾回收掉, 释放内存
但是, 有3个特殊的函数:
`eval()`: 执行一段代码, 由于不知道是否使用当前环境变量, 就不会释放
`with()`: 
`try(){} catch(){}`
```js
function test () {
    var a = 1;
    return function () {
        // eval
        // with
        // try(){}catch(){}
    }
}
```


--------------------------------------------
## this

谁调用的就指向谁; 箭头函数中的this是他爹
分清楚是函数赋值还是调用

> 箭头函数中的this ??


--------------------------------------------
# 原型链访问顺序

访问对象属性, 优先访问自己的, 自己没有再去原型链找
原型链神图



--------------------------------------------
# 对象函数参数

对象作为函数参数时, 是值传递, 传递的是 "保存对象地址的变量"
当函数内给该变量赋值的时候, 引用类型的的会替换掉原来的指针

```js
function foo (obj) {
    // 函数中的obj和外面的没毛线的关系, 叫做 oo 也可以, 只是指向了外面obj的地址而已
    obj = { 
        n : 10;
    };
}

var obj = { m : 5 };
foo(obj);
console.log(obj.n);
```

--------------------------------------------
# 代码小技巧

网速 1-1000, 得出网速的等级 1,2,3,4,5,6,7,8,9,10

`10 - Math.floor(speed/100);`

字符串成数组
```
split
Array.prototype.splice.call();
```





```js
// 自执行函数的写法, 少用~这种, 一般都用()()
    ! function () {}();




// ---------------
// 对象, 引用类型, 变量里面保存的是对象的指针, 再赋值对象后之后是个新的指针
    var yideng = {
        a: 1
    };
    with(yideng) {
        b: 2;
    }
    alert(b);

// ---------------
// 函数声明提升的优先级 > 变量提升
function test () {
    function a () {};
    var a = 1;
    alert (a);
}

// ---------------
(function () {
    var a = b = 1;
})();
alert (a);
alert (b);

// ---------------
// eval with trycatch 的块级作用域     eval with try 频率高

function test () {
    var a = 1;
    return function (){

    }
}

// ---------------
// this 谁调用的就指向谁; 箭头函数中的this是他爹
this.a = 20;
var bar = {
    a:30,
    init:function(){
        alert(this.a);
    },
    init2:function(){
        function in(){
            alert(this.a);
        }
        in();//会找到外层, 因为是在内部调用的, this指向内部函数作用域
    },
    init3:()=>{
        alert(this.a); // 里面使用了bind 会找到 他爹 的, 外面一层
    }
}
bar.init();

var s = bar.init();
s();


// ---------------
// 访问对象属性, 优先访问自己的, 自己没有再去原型链找
// 原型链神图
function test () {
    this.a = 20;
}
test.prototype.a=30;
alert((new test()).a):

class test() {
    a () {
        console.log(1);
    }
}
test.prototype.a = function () {
    console.log(2);
}
(new test()).a(); // 2 本质还是es3, 都是看用es3来实现的原理

// ---------------
// 原型链图 王福朋 的博客


// ---------------
// let 会改变变量的作用域, 成了块级
var i;
if (1) {
    i = 1;
    let i;
}
console.log(i);


// ---------------
// 对象作为函数参数时, 是值传递, 传递的是 "保存对象指针的变量"
// 当函数内给该变量赋值的时候, 引用类型的的会替换掉原来的指针
function test (m) {
    m = { // 这里的m和外面的没毛线的关系 可以用 n
        v:5
    };
}

var m = {
    k: 30
};

test (m);
alert(m.v);

```