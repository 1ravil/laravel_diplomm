<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\basketcontroller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('index');
});

Route::get('/store', [MainController::class, 'index'])->name('index');

Route::get('/garanty', [MainController::class, 'garanty'])->name('garanty');

Route::get('/installment', [MainController::class, 'installment'])->name('installment');

Route::get('/contacts', [MainController::class, 'contacts'])->name('contacts');

Route::get('/catalog/{category}', [MainController::class, 'categoriesByPhone'])->name('categoriesByPhone');
// че означает нейм? че он дает?xdddd
// Маршрут для каталога с указанием категории
//Route::get('/catalog/{category}', [MainController::class, 'categoriesByPhone'])->name('catalog.category');

Route::get('/question', [MainController::class, 'question'])->name('question');






Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/login/auth', [AuthController::class, 'loginAuth'])->name('loginAuth');


Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::get('/verify', [AuthController::class, 'verify'])->name('verify');

Route::post('/register/add', [AuthController::class, 'store'])->name('userCreate');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');




Route::get('/catalog_accessory', [MainController::class, 'catalog_accessory']);

//Route::get('/categories', [MainController::class, 'categories'])->name('categories');;

//Route::get('/categories/{phone}', [MainController::class, 'categoriesByPhone']);

Route::get('/catalog', [MainController::class, 'catalog'])->name('catalog');

Route::get('/adminPanel', [MainController::class, 'adminPanel'])->name('adminPanel');

Route::get('/adminPanel/orders', [MainController::class, 'adminPanelOrders'])->name('adminPanelOrders');

Route::get('/adminPanelCategory/categories', [MainController::class, 'adminPanelCategory'])->name('adminPanelCategory');

Route::get('/adminPanel/customers', [MainController::class, 'adminPanelCustomers'])->name('adminPanelCustomers');

Route::get('/adminPanel/users', [MainController::class, 'adminPanelUsers'])->name('adminPanelUsers');


Route::get('/adminPanel/productCard/{id}', [MainController::class, 'adminPanelProductCard'])->name('adminPanelProductCard');

Route::put('/adminPanel/productCard/update/{id}', [MainController::class, 'ProductsUpdate'])->name('products.update');


Route::get('/adminPanelCategory/categories/edit/{id}', [MainController::class, 'CategoriesEdit'])->name('CategoriesEdit');


Route::put('/adminPanelCategory/categories/update/{id}', [MainController::class, 'CategoriesUpdate'])->name('CategoriesUpdate');

Route::get('/adminPanelinsertUsers/edit/{id}', [MainController::class, 'adminPanelinsertUsers'])->name('adminPanelEditUser');


Route::put('/adminPanelinsertUsers/update/{id}', [MainController::class, 'usersUpdate'])->name('usersUpdate');

Route::delete('/adminPanel/delete', [MainController::class, 'deleteProduct'])->name('ProductsDelete');


Route::get('/adminPanel/products/create', [MainController::class, 'createProduct'])->name('adminPanelProductCreate');
Route::post('/adminPanel/products/store', [MainController::class, 'storeProduct'])->name('adminPanelProductStore');

Route::delete('/adminPanelCategory/categories/delete', [MainController::class, 'deleteCategories'])->name('CategoriesDelete');

Route::get('/adminPanel/categories/create', [MainController::class, 'createCategory'])->name('adminPanelCategoryCreate');
Route::post('/adminPanel/categories/store', [MainController::class, 'storeCategory'])->name('adminPanelCategoryStore');



Route::delete('/adminPanel/orders/delete', [MainController::class, 'deleteOrders'])->name('OrdersDelete');

Route::get('/adminPanel/orders', [MainController::class, 'adminPanelOrders'])->name('adminPanelOrders');

Route::delete('/adminPanel/udelete', [MainController::class, 'UsersDelete'])->name('UsersDelete');

Route::get('/adminPanel/user/create', [MainController::class, 'createUser'])->name('adminPanelUserCreate');
Route::post('/adminPanel/user/store', [MainController::class, 'storeUser'])->name('adminPanelUserStore');

Route::delete('/adminPanel/Cdelete', [MainController::class, 'deleteCustomers'])->name('CustomersDelete');

Route::get('/adminPanel/filter', [MainController::class, 'adminPanelFilter'])->name('adminPanelFilter');

Route::get('/adminPanel/Catfilter', [MainController::class, 'adminPanelCategoryFilter'])->name('adminPanelCategoryFilter');

Route::get('/adminPanel/Ofilter', [MainController::class, 'adminPanelOrdersFilter'])->name('adminPanelOrdersFilter');

Route::get('/adminPanel/Cfilter', [MainController::class, 'adminPanelCustomersFilter'])->name('adminPanelCustomersFilter');

Route::get('/adminPanel/Ufilter', [MainController::class, 'adminPanelUsersFilter'])->name('adminPanelUsersFilter');




Route::get('/cart', [basketcontroller::class, 'cart']);

Route::get('/cartProduct', [basketcontroller::class, 'cartProduct']);

Route::get('/cartProduct/{id}', [basketcontroller::class, 'show'])->name('cartProduct');

//Route::post('/cartProduct/add/{id}', [basketcontroller::class, 'add'])->name('cartProduct.add');

Route::post('/catalog/{category}/add', [basketcontroller::class, 'add'])->name('cartProduct.add');


Route::get('/cartProduct', [basketcontroller::class, 'cartPage'])->name('cartPage');

Route::post('/cartProduct/{id}', [basketcontroller::class, 'basketRemove'])->name('cartPageDelete');


Route::post('/cartProduct/remove/{id}', [basketcontroller::class, 'removeProduct'])->name('cart.remove');


Route::get('/placeOrder/{id}', [basketcontroller::class, 'placeOrder'])->name('placeOrder');


Route::post('/placeOrder/{id}', [basketcontroller::class, 'sendOrder'])->name('sendOrder');




Route::post('/cart/add/{id}', [basketcontroller::class, 'add'])->name('cart.add');
Route::post('/cart/decrement/{id}', [basketcontroller::class, 'decrement'])->name('cart.decrement');
Route::post('/cart/remove/{id}', [basketcontroller::class, 'remove'])->name('cart.remove');



