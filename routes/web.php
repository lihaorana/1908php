<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $name='盛传利';
    return view('welcome',['name'=>$name]);
});
/*
////1：实现两种方式访问http://www.1908.com/show 输出“这里是商品详情页”字样
//Route::get('/show','ShopController@index');
//Route::view('/shows','shop.index');
////2：访问http://www.1908.com/show/1 输出“商品Id是：1”字样
////3：访问http://www.1908.com/show/23/裤子 输出“商品Id是：23，关键字是：裤子”字样
//Route::get('/show/{id}/{name?}',function($id,$name=null){
//echo "商品Id是: $id.<br>";
//    if(empty($name)){
//        $name=null;
//    }else{
//        $name='关键字是:'.$name;
//    }
//    echo $name;
//});
//
////4：实现两种方式访问http://www.1908.com/brand/add显示添加界面
//Route::get('/brand/add','ShopController@brand_add');
//Route::view('/brand/adds','shop/brand_add');
////5：实现访问http://www.1908.com/category/add显示添加分类界面，并带过去参数 变量 fid=“服装”;
//Route::view('/category/add','shop.cate_add',['fid'=>'服装']);
*/
/*
Route::get('/goods/{id}',function($id){
echo "商品id是:";
    echo $id;
});


Route::get('/goods/{id}/{name}',function($id,$name){
    echo "商品id是:";
    echo $id;
    echo "名称是：".$name;
})->where('name','[a-z]+');

Route::get('/show','ShopController@brand_add')->name('bb');
*/

//武汉人口统计
Route::prefix('people')->middleware('checklogin')->group(function(){
        Route::get('create','PeopleController@create');
        Route::post('store','PeopleController@store');
        Route::get('/','PeopleController@index');
        Route::get('edit/{id}','PeopleController@edit');
        Route::post('update/{id}','PeopleController@update');
        Route::get('destroy/{id}','PeopleController@destroy');
});
Route::view('/admin/login','login');
Route::post('/admin/logindo','LoginController@logindo');



//学生
Route::prefix('study')->group(function(){
    Route::get('/','StudyController@create');
    Route::post('store','StudyController@store');
    Route::get('index','StudyController@index');
    Route::get('destroy/{id}','StudyController@destroy');
    Route::get('edit/{id?}','StudyController@edit');
    Route::post('update/{id}','StudyController@update');
});


//商品品牌
Route::prefix('brand')->middleware('checklogin')->group(function(){
    Route::get('create','BrandController@create');
    Route::post('store','BrandController@store');
    Route::get('/','BrandController@index');
    Route::get('destroy/{id}','BrandController@destroy');
    Route::get('edit/{id}','BrandController@edit');
    Route::post('update/{id}','BrandController@update');
});

Route::prefix('article')->middleware('checklogin')->group(function(){
    Route::get('create','ArticleController@create');
    Route::post('store','ArticleController@store');
    Route::get('index','ArticleController@index');
    Route::post('destroy/{id}','ArticleController@destroy');
    Route::get('edit/{id}','ArticleController@edit');
    Route::post('update/{id}','ArticleController@update');
    Route::post('uniqueness','ArticleController@uniqueness');
//    Route::post('edit/uniqueness','ArticleController@uniqueness');
});
//分类
Route::prefix('cate')->middleware('checklogin')->group(function(){
    Route::get('create','CateController@create');
    Route::post('store','CateController@store');
    Route::get('/','CateController@index');
    Route::get('destroy/{id}','CateController@destroy');
    Route::get('edit/{id}','CateController@edit');
    Route::post('update/{id}','CateController@update');
    Route::post('ajaxtest','CateController@ajaxtest');

});
//商品
Route::prefix('shop')->middleware('checklogin')->group(function(){
    Route::get('create','ShopController@create');
    Route::post('store','ShopController@store');
    Route::post('destroy/{id}','ShopController@destroy');
    Route::get('edit/{id}','ShopController@edit');
    Route::post('update/{id}','ShopController@update');
    Route::get('/','ShopController@index');
    Route::post('ajaxtest','ShopController@ajaxtest');
});

Route::prefix('admin')->middleware('checklogin')->group(function(){
    Route::get('create','AdminController@create');
    Route::post('store','AdminController@store');
    Route::get('destroy/{id}','AdminController@destroy');
    Route::get('edit/{id}','AdminController@edit');
    Route::post('update/{id}','AdminController@update');
    Route::get('/','AdminController@index');
});


Route::get('/','Index\IndexController@index');//首页
Route::get('/pro/{id?}','Index\ProController@prolist');//商品展示页
Route::get('/getshop','Index\ProController@getshop');//商品重新获取页
Route::get('/proinfo/{id}','Index\ProController@proinfo');//商品详情车页

Route::get('/addcart','Index\CartController@addcart');//添加购物车
Route::get('/cart','Index\CartController@cart');//购物车页
Route::post('/cart/upd_cart_num','Index\CartController@upd_cart_num');//购物车获取购买数量
Route::get('/cart/upd_cart_nums','Index\CartController@upd_cart_num');//购物车获取购买数量
Route::post('/cart/getnewtotal','Index\CartController@getnewtotal');//购物车获取小计
Route::post('/cart/del','Index\CartController@del');//购物车删除
Route::post('/cart/getmoery','Index\CartController@getmoery');//购物车获取总价
Route::post('/is_address','Index\AddressController@is_address');//购物车判断收货地址页
Route::get('/add_address/{ids?}','Index\AddressController@add_address');//购物地址收货页
Route::post('/address_do/','Index\AddressController@address_do');//购物地址收货页
Route::get('/address/site','Index\AddressController@site');//购物地址三级联动
Route::get('/add_order/{ids}','Index\OrderController@add_order');//购物车添加收货页

//Route::get('/getcookie','Index\IndexController@getcookie');
Route::post('login/reg','Index\LoginController@reg');//注册
Route::post('login/logindo','Index\LoginController@logindo');//登录执行
Route::get('login/getsms','Index\LoginController@getsms');//调用短信方法
Route::get('login/getemail','Index\LoginController@getemail');//调用邮箱方法
Route::get('login/unsetsession','Index\LoginController@unsetsession');//退出登录
Route::get('login/AccountAjax','Index\LoginController@AccountAjax');//验证账号
Route::view('/login','index/login');//登录页
Route::view('/reg','index/reg');//注册页



//管理员+超级
Route::prefix('/admins')->middleware('adminslogin')->group(function() {
    Route::get('create', 'admins\AdminsController@create');//超级管理员添加
    Route::get('show', 'admins\AdminsController@show');//超级管理员功能
    Route::get('tc', 'admins\LoginController@tc');//超级管理员退出
    Route::post('store', 'admins\AdminsController@store');//超级管理员添加执行
    Route::post('update/{id}', 'admins\AdminsController@update');//超级管理员添加执行
    Route::get('index', 'admins\AdminsController@index');//超级管理员展示
    Route::get('destroy/{id}', 'admins\AdminsController@destroy');//超级管理员展示
    Route::get('edit/{id}', 'admins\AdminsController@edit');//超级管理员展示
});
Route::view('/admins/login','admins\login');//超级管理员登录
Route::post('/admins/logindo','admins\LoginController@logindo');//超级管理员登录
