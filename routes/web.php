<?php

use App\Http\Controllers\Admin\AdminAmenityController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminFeatureController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPhotoController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminSlideController;
use App\Http\Controllers\Admin\AdminSubscriberController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminVideoController;
use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\Customer\CustomerHomeController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PhotoController;
use App\Http\Controllers\Front\PrivacyController;
use App\Http\Controllers\Front\RoomController;
use App\Http\Controllers\Front\SubscriberController;
use App\Http\Controllers\Front\TermsController;
use App\Http\Controllers\Front\VideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Front routes */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{id}', [BlogController::class, 'single_blog'])->name('single_blog');
Route::get('/photo-gallery', [PhotoController::class, 'index'])->name('photo_gallery');
Route::get('/video-gallery', [VideoController::class, 'index'])->name('video_gallery');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/terms-and-conditions', [TermsController::class, 'index'])->name('terms');
Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send-email', [ContactController::class, 'send_email'])->name('contact_send_email');
Route::post('/subscriber/send-email', [SubscriberController::class, 'send_email'])->name('subscriber_send_email');
Route::post('/subscriber/verify/{email}/{token}', [SubscriberController::class, 'verify'])->name('subscriber_verify');

//Room Front Routes
Route::get('/room/{id}', [RoomController::class, 'single_room'])->name('room_detail');
Route::get('/room', [RoomController::class, 'index'])->name('room');
Route::post('/booking/submit', [BookingController::class, 'cart_submit'])->name('cart_submit');
Route::get('/cart', [BookingController::class, 'cart_view'])->name('cart');
Route::get('/cart/delete/{id}', [BookingController::class, 'cart_delete'])->name('cart_delete');
Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');

Route::get('/payments', [BookingController::class, 'paymentOption'])->name('payments');
// Route::post('/payment/option', [BookingController::class, 'payment'])->name('payment_option');

// Route::get('/payment/paypal', [BookingController::class, 'paypal'])->name('paypal');
// Route::get('/payment/mpesa', [PaymentController::class, 'customerMpesaSTKPush'])->name('mpesa');
// Route::get('/payment/mpesa', [PaymentController::class, 'customerMpesaSTKPush'])->name('mpesa');
// Route::get('/payment/cash', [PaymentController::class, 'cash'])->name('cash');

Route::post('/payment-option', [BookingController::class, 'choose_option'])->name('choose_option');
Route::get('/payment/cash', [BookingController::class, 'cash'])->name('cash');
Route::get('/payment/stk-push', [BookingController::class, 'initiateStkPush'])->name('initiate_push');
Route::post('/payment/stk-callback', [BookingController::class, 'stkCallback'])->name('stk_callback');

// Route::get('/mpesa/generate-token', [PaymentController::class, 'generateAccessToken'])->name('generate_token');
// Route::get('/mpesa/generate-password', [PaymentController::class, 'lipaNaMpesaPassword'])->name('generate_password');
// Route::post('/mpesa/stk-push', [PaymentController::class, 'customerMpesaSTKPush'])->name('stk_push');


//admin Public routes
Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('admin_login');
Route::post('/admin/login-submit', [AdminLoginController::class, 'login_submit'])->name('admin_login_submit');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin_logout');
Route::get('/admin/forget-password', [AdminLoginController::class, 'forget_password'])->name('admin_forget_password');
Route::post('/admin/forget-password-submit', [AdminLoginController::class, 'forget_password_submit'])->name('admin_forget_password_submit');
Route::get('/admin/reset-password/{token}/{email}', [AdminLoginController::class, 'reset_password'])->name('admin_reset_password');
Route::post('/admin/reset-password-submit', [AdminLoginController::class, 'reset_password_submit'])->name('admin_reset_password_submit');


// Customer Public Routes
Route::get('/login', [CustomerAuthController::class, 'login'])->name('customer_login');
Route::get('/signup', [CustomerAuthController::class, 'signup'])->name('customer_signup');
Route::post('/signup-submit', [CustomerAuthController::class, 'signup_submit'])->name('customer_signup_submit');
Route::post('/login-submit', [CustomerAuthController::class, 'login_submit'])->name('customer_login_submit');
Route::get('/logout', [CustomerAuthController::class, 'logout'])->name('customer_logout');
Route::get('/signup-verify/{email}/{token}', [CustomerAuthController::class, 'signup_verify'])->name('customer_signup_verify');


Route::get('/forget-password', [CustomerAuthController::class, 'forget_password'])->name('customer_forget_password');
Route::post('/forget-password-submit', [CustomerAuthController::class, 'forget_password_submit'])->name('customer_forget_password_submit');
Route::get('/reset-password/{token}/{email}', [CustomerAuthController::class, 'reset_password'])->name('customer_reset_password');
Route::post('/reset-password-submit', [CustomerAuthController::class, 'reset_password_submit'])->name('customer_reset_password_submit');


//Customer Protected Routes
Route::group(['middleware'=>['customer:customer']], function(){
    Route::get('/customer/home', [CustomerHomeController::class, 'index'])->name('customer_home');
    Route::get('/customer/edit-profile', [CustomerProfileController::class, 'index'])->name('customer_profile');
    Route::post('/customer/edit-profile-submit', [CustomerProfileController::class, 'profile_submit'])->name('customer_profile_submit');
    Route::get('/customer/order/view', [CustomerOrderController::class, 'index'])->name('customer_order_view');
    Route::get('/customer/order/detail', [CustomerOrderController::class, 'detail'])->name('customer_order_detail');
    Route::get('/customer/invoice/{id}', [CustomerOrderController::class, 'invoice'])->name('customer_invoice');
});


//Admin Protected Routes with Middleware
Route::group(['middleware'=>['admin:admin']], function(){
    Route::get('/admin/edit-profile', [AdminProfileController::class, 'index'])->name('admin_profile');
    Route::post('/admin/edit-profile-submit', [AdminProfileController::class, 'profile_submit'])->name('admin_profile_submit');


    Route::get('/admin/home', [AdminHomeController::class, 'index'])->name('admin_home');
    Route::get('/admin/order/payment/status', [BookingController::class, 'getStkQuery'])->name('admin_order_payment_status');
    Route::post('/admin/order/payment/status', [BookingController::class, 'stkQuery'])->name('admin_order_payment_status_store');

    Route::get('/admin/customers', [AdminCustomerController::class, 'index'])->name('admin_customer');
    Route::get('/admin/customers/change-status/{id}', [AdminCustomerController::class, 'change_status'])->name('admin_customer_change_status');
    Route::get('/admin/order/view', [AdminOrderController::class, 'index'])->name('admin_orders');
    Route::get('/admin/order/invoice/{id}', [AdminOrderController::class, 'invoice'])->name('admin_invoice');
    Route::get('/admin/order/{id}/delete', [AdminOrderController::class, 'delete'])->name('admin_order_delete');



    //Slider Admin Routes
    Route::get('/admin/slide/view', [AdminSlideController::class, 'index'])->name('admin_slide_view');
    Route::get('/admin/slide/add', [AdminSlideController::class, 'add'])->name('admin_slide_add');
    Route::post('/admin/slide/store', [AdminSlideController::class, 'store'])->name('admin_slide_store');
    Route::get('/admin/slide/{id}/edit', [AdminSlideController::class, 'edit'])->name('admin_slide_edit');
    Route::put('/admin/slide/{id}/update', [AdminSlideController::class, 'update'])->name('admin_slide_update');
    Route::get('/admin/slide/{id}/delete', [AdminSlideController::class, 'destroy'])->name('admin_slide_delete');

    //Features Admin Routes
    Route::get('/admin/feature/view', [AdminFeatureController::class, 'index'])->name('admin_feature_view');
    Route::get('/admin/feature/add', [AdminFeatureController::class, 'add'])->name('admin_feature_add');
    Route::post('/admin/feature/store', [AdminFeatureController::class, 'store'])->name('admin_feature_store');
    Route::get('/admin/feature/{id}/edit', [AdminFeatureController::class, 'edit'])->name('admin_feature_edit');
    Route::put('/admin/feature/{id}/update', [AdminFeatureController::class, 'update'])->name('admin_feature_update');
    Route::get('/admin/feature/{id}/delete', [AdminFeatureController::class, 'destroy'])->name('admin_feature_delete');


    //Testimonials Admin Routes
    Route::get('/admin/testimonial/view', [AdminTestimonialController::class, 'index'])->name('admin_testimonial_view');
    Route::get('/admin/testimonial/add', [AdminTestimonialController::class, 'add'])->name('admin_testimonial_add');
    Route::post('/admin/testimonial/store', [AdminTestimonialController::class, 'store'])->name('admin_testimonial_store');
    Route::get('/admin/testimonial/{id}/edit', [AdminTestimonialController::class, 'edit'])->name('admin_testimonial_edit');
    Route::put('/admin/testimonial/{id}/update', [AdminTestimonialController::class, 'update'])->name('admin_testimonial_update');
    Route::get('/admin/testimonial/{id}/delete', [AdminTestimonialController::class, 'destroy'])->name('admin_testimonial_delete');



    //Post Admin Routes
    Route::get('/admin/post/view', [AdminPostController::class, 'index'])->name('admin_post_view');
    Route::get('/admin/post/add', [AdminPostController::class, 'add'])->name('admin_post_add');
    Route::post('/admin/post/store', [AdminPostController::class, 'store'])->name('admin_post_store');
    Route::get('/admin/post/{id}/edit', [AdminPostController::class, 'edit'])->name('admin_post_edit');
    Route::put('/admin/post/{id}/update', [AdminPostController::class, 'update'])->name('admin_post_update');
    Route::get('/admin/post/{id}/delete', [AdminPostController::class, 'destroy'])->name('admin_post_delete');


    //Photo Admin Routes
    Route::get('/admin/photo/view', [AdminPhotoController::class, 'index'])->name('admin_photo_view');
    Route::get('/admin/photo/add', [AdminPhotoController::class, 'add'])->name('admin_photo_add');
    Route::post('/admin/photo/store', [AdminPhotoController::class, 'store'])->name('admin_photo_store');
    Route::get('/admin/photo/{id}/edit', [AdminPhotoController::class, 'edit'])->name('admin_photo_edit');
    Route::put('/admin/photo/{id}/update', [AdminPhotoController::class, 'update'])->name('admin_photo_update');
    Route::get('/admin/photo/{id}/delete', [AdminPhotoController::class, 'destroy'])->name('admin_photo_delete');


    //Photo Admin Routes
    Route::get('/admin/video/view', [AdminVideoController::class, 'index'])->name('admin_video_view');
    Route::get('/admin/video/add', [AdminVideoController::class, 'add'])->name('admin_video_add');
    Route::post('/admin/video/store', [AdminVideoController::class, 'store'])->name('admin_video_store');
    Route::get('/admin/video/{id}/edit', [AdminVideoController::class, 'edit'])->name('admin_video_edit');
    Route::put('/admin/video/{id}/update', [AdminVideoController::class, 'update'])->name('admin_video_update');
    Route::get('/admin/video/{id}/delete', [AdminVideoController::class, 'destroy'])->name('admin_video_delete');

    //FAQ Admin Routes
    Route::get('/admin/faq/view', [AdminFaqController::class, 'index'])->name('admin_faq_view');
    Route::get('/admin/faq/add', [AdminFaqController::class, 'add'])->name('admin_faq_add');
    Route::post('/admin/faq/store', [AdminFaqController::class, 'store'])->name('admin_faq_store');
    Route::get('/admin/faq/{id}/edit', [AdminFaqController::class, 'edit'])->name('admin_faq_edit');
    Route::put('/admin/faq/{id}/update', [AdminFaqController::class, 'update'])->name('admin_faq_update');
    Route::get('/admin/faq/{id}/delete', [AdminFaqController::class, 'destroy'])->name('admin_faq_delete');


    //About Admin Routes
    Route::get('/admin/page/about', [AdminPageController::class, 'about'])->name('admin_page_about');
    Route::post('/admin/page/about/update', [AdminPageController::class, 'about_update'])->name('admin_page_about_update');
    //Terms &  Conditions Admin Routes
    Route::get('/admin/page/terms', [AdminPageController::class, 'terms'])->name('admin_page_terms');
    Route::post('/admin/page/terms/update', [AdminPageController::class, 'terms_update'])->name('admin_page_terms_update');


    //Privacy Policy Admin Routes
    Route::get('/admin/page/privacy', [AdminPageController::class, 'privacy'])->name('admin_page_privacy');
    Route::post('/admin/page/privacy/update', [AdminPageController::class, 'privacy_update'])->name('admin_page_privacy_update');

    //Contact Admin Routes
    Route::get('/admin/page/contact', [AdminPageController::class, 'contact'])->name('admin_page_contact');
    Route::post('/admin/page/contact/update', [AdminPageController::class, 'contact_update'])->name('admin_page_contact_update');



    //Photo Gallery Admin Routes
    Route::get('/admin/page/photo-gallery', [AdminPageController::class, 'photo_gallery'])->name('admin_page_photo_gallery');
    Route::post('/admin/page/photo-gallery/update', [AdminPageController::class, 'photo_gallery_update'])->name('admin_page_photo_gallery_update');

    //Video Gallery Admin Routes
    Route::get('/admin/page/video-gallery', [AdminPageController::class, 'video_gallery'])->name('admin_page_video_gallery');
    Route::post('/admin/page/video-gallery/update', [AdminPageController::class, 'video_gallery_update'])->name('admin_page_video_gallery_update');
    //FAQ Admin Routes
    Route::get('/admin/page/faq', [AdminPageController::class, 'faq'])->name('admin_page_faq');
    Route::post('/admin/page/faq/update', [AdminPageController::class, 'faq_update'])->name('admin_page_faq_update');

    //Blog Admin Routes
    Route::get('/admin/page/blog', [AdminPageController::class, 'blog'])->name('admin_page_blog');
    Route::post('/admin/page/blog/update', [AdminPageController::class, 'blog_update'])->name('admin_page_blog_update');

    //Rooms Admin Routes
    Route::get('/admin/page/room', [AdminPageController::class, 'room'])->name('admin_page_room');
    Route::post('/admin/page/room/update', [AdminPageController::class, 'room_update'])->name('admin_page_room_update');

    //Cart Admin Routes
    Route::get('/admin/page/cart', [AdminPageController::class, 'cart'])->name('admin_page_cart');
    Route::post('/admin/page/cart/update', [AdminPageController::class, 'cart_update'])->name('admin_page_cart_update');

    //Checkout Admin Routes
    Route::get('/admin/page/checkout', [AdminPageController::class, 'checkout'])->name('admin_page_checkout');
    Route::post('/admin/page/checkout/update', [AdminPageController::class, 'checkout_update'])->name('admin_page_checkout_update');

    //Payment Admin Routes
    Route::get('/admin/page/payment', [AdminPageController::class, 'payment'])->name('admin_page_payment');
    Route::post('/admin/page/payment/update', [AdminPageController::class, 'payment_update'])->name('admin_page_payment_update');

    //Sign Up Admin Routes
    Route::get('/admin/page/signup', [AdminPageController::class, 'signup'])->name('admin_page_signup');
    Route::post('/admin/page/signup/update', [AdminPageController::class, 'signup_update'])->name('admin_page_signup_update');

    //Sign In Admin Routes
    Route::get('/admin/page/signin', [AdminPageController::class, 'signin'])->name('admin_page_signin');
    Route::post('/admin/page/signin/update', [AdminPageController::class, 'signin_update'])->name('admin_page_signin_update');

    //Forget Password Admin Routes
    Route::get('/admin/page/forget-password', [AdminPageController::class, 'forget_password'])->name('admin_page_forget_password');
    Route::post('/admin/page/forget-password/update', [AdminPageController::class, 'forget_password_update'])->name('admin_page_forget_password_update');

    //Reset Password Admin Routes
    Route::get('/admin/page/reset-password', [AdminPageController::class, 'reset_password'])->name('admin_page_reset_password');
    Route::post('/admin/page/reset-password/update', [AdminPageController::class, 'reset_password_update'])->name('admin_page_reset_password_update');


    //Subscribers Admin Routes
    Route::get('/admin/subscriber/show', [AdminSubscriberController::class, 'show'])->name('admin_subscriber_show');
    Route::get('/admin/subscriber/send-email', [AdminSubscriberController::class, 'send_email'])->name('admin_subscriber_send_email');
    Route::post('/admin/subscriber/send-email-submit', [AdminSubscriberController::class, 'send_email_submit'])->name('admin_subscriber_send_email_submit');


    //Amenities Admin Routes
    Route::get('/admin/amenity/view', [AdminAmenityController::class, 'index'])->name('admin_amenity_view');
    Route::get('/admin/amenity/add', [AdminAmenityController::class, 'add'])->name('admin_amenity_add');
    Route::post('/admin/amenity/store', [AdminAmenityController::class, 'store'])->name('admin_amenity_store');
    Route::get('/admin/amenity/{id}/edit', [AdminAmenityController::class, 'edit'])->name('admin_amenity_edit');
    Route::put('/admin/amenity/{id}/update', [AdminAmenityController::class, 'update'])->name('admin_amenity_update');
    Route::get('/admin/amenity/{id}/delete', [AdminAmenityController::class, 'destroy'])->name('admin_amenity_delete');


    //Rooms Admin Routes
    Route::get('/admin/room/view', [AdminRoomController::class, 'index'])->name('admin_room_view');
    Route::get('/admin/room/add', [AdminRoomController::class, 'add'])->name('admin_room_add');
    Route::post('/admin/room/store', [AdminRoomController::class, 'store'])->name('admin_room_store');
    Route::get('/admin/room/{id}/edit', [AdminRoomController::class, 'edit'])->name('admin_room_edit');
    Route::put('/admin/room/{id}/update', [AdminRoomController::class, 'update'])->name('admin_room_update');
    Route::get('/admin/room/{id}/delete', [AdminRoomController::class, 'destroy'])->name('admin_room_delete');

    //Gallery Admin Routes
    Route::get('/admin/room/gallery/{id}', [AdminRoomController::class, 'gallery'])->name('admin_room_gallery');
    Route::post('/admin/room/gallery/store/{id}', [AdminRoomController::class, 'gallery_store'])->name('admin_room_gallery_store');
    Route::get('/admin/room/gallery/{id}/delete', [AdminRoomController::class, 'gallery_delete'])->name('admin_room_gallery_delete');

});
