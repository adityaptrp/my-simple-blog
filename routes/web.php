<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReadingListController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialController;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// GLOBAL SETTING
Auth::routes(['verify' => true, 'login' => false, 'register' => false]);
Route::get('/', [HomeController::class, 'index'])->name('home');

// Set password for user login with provider
Route::patch('/set-password/{user:email}', [RegisterController::class, 'setPasswordsUserProvider'])->name('passwords.setPassword')->middleware('auth');

// Login and register
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->middleware('throttle:5,0.6');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Socialite
Route::get('oauth/{driver}', [SocialController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [SocialController::class, 'handleProviderCallback'])->name('social.callback');

// CMS
Route::middleware(['verified', 'checkPasswordEmpty', 'auth', 'checkPasswordEmpty'])->group(function () {
    Route::get('/dashboard', [CmsController::class, 'show'])->name('dashboard');
});
// Post
Route::middleware(['verified', 'checkPasswordEmpty', 'auth'])->group(function () {
    Route::delete('/posts/multiple-delete', [PostController::class, 'multipleDelete'])->name('posts.multipleDelete');
    Route::resource('posts', PostController::class)->parameters([ 'posts' => 'post:slug' ])->except(['show']);
    Route::get('/posts/all-posts', [PostController::class, 'allPosts'])->name('posts.allPosts')->middleware('isAdmin');
});
Route::get('/@{user:username}/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/post-like/{post:id}', [PostController::class, 'postLiked']);

// Category
Route::middleware(['verified', 'checkPasswordEmpty', 'isAdmin', 'auth'])->group(function () {
    Route::delete('/categories/multiple-delete', [CategoryController::class, 'multipleDelete'])->name('categories.multipleDelete');
    Route::resource('categories', CategoryController::class)->parameters([ 'categories' => 'category:slug' ])->except(['show']);
    Route::get('/categories/{category:slug}/posts', [CategoryController::class, 'categoryPosts'])->name('category.posts');
});
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Tag
Route::middleware(['verified', 'checkPasswordEmpty', 'isAdmin', 'auth'])->group(function () {
    Route::delete('/tags/multiple-delete', [TagController::class, 'multipleDelete'])->name('tags.multipleDelete');
    Route::resource('tags', TagController::class)->parameters([ 'tags' => 'tag:slug' ])->except(['show']);
    Route::get('/tags/{tag:slug}/posts', [TagController::class, 'tagPosts'])->name('tag.posts');
});
Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tags.show');


// Comment
Route::middleware(['throttle:3,0.6'])->group(function () {
    Route::post('/comments/store', [CommentController::class, 'store']);
    Route::post('/comments/reply', [CommentController::class, 'store']);
});
Route::delete('/comments/delete', [CommentController::class, 'delete']);
Route::post('/comment-like/update', [CommentController::class, 'likesComment']);
Route::post('/comment/read-more/{comment:id}', [CommentController::class, 'readMore']);
Route::middleware(['verified', 'checkPasswordEmpty', 'auth'])->group(function () {
    Route::delete('/comments/multiple-delete', [CommentController::class, 'multipleDelete'])->name('comments.multipleDelete');
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/viewCUnapproved/{comment:id}', [CommentController::class, 'viewCUnapproved']);
    Route::post('/comments/approve', [CommentController::class, 'approveComment']);
    Route::delete('/comments/{comment:id}', [CommentController::class, 'cmsDelete'])->name('comments.cmsDelete');
});

// Search
Route::get('/search', [SearchController::class, 'searchPost'])->name('search.posts');
Route::get('/search/all-posts', [SearchController::class, 'allPosts'])->name('search.all_post');
Route::get('/search/popular-posts', [SearchController::class, 'popularPosts'])->name('search.popular_posts');
Route::get('/search/popular-categories-tags', [SearchController::class, 'popularCategoriesTags'])->name('search.pop_categories_tags');

// Check Post ID Bookmark
Route::post('/checkPostId', function () {
    $postId = request()->postId;
    $post = Post::where('id', $postId)->first();
    if( isset($post) ) {
        return Post::where('id', $postId)->first();
    } else {
        return 0;
    }
});

// Reading List
Route::get('/list/saved', [ReadingListController::class, 'bookmarkedPost'])->name('readingList.saved');
Route::get('/list/archived', [ReadingListController::class, 'archivedPost'])->name('readingList.archived');

// Shortcut Link Post
Route::get("{post:shotLink}", function () {
    $fullURL = request()->url();
    $explode = explode('/', $fullURL);
    $codePost = end($explode);
    $post = Post::where('slug', 'like', "%$codePost%")->first();
    if ($post) {
        return redirect()->route('posts.show', ['user'=>$post->user->username,'post'=>$post->slug]);
    } else {
        return abort(404);
    }
});

// Profile
Route::get('/profile/@{user:username}', [UserController::class, 'show'])->name('profile.show')->middleware('checkPasswordEmpty');
Route::post('/likes-profile/{user:id}', [UserController::class, 'likesProfile']);
Route::get('/profile/@{user:username}/all-posts', [UserController::class, 'allPosts'])->name('profile.allPosts');
Route::get('/profile/@{user:username}/most-popular', [UserController::class, 'mostPopular'])->name('profile.mostPopular');
Route::get('/profile/@{user:username}/social-media', [UserController::class, 'socialMedia'])->name('profile.socialMedia');
// Edit Profile
Route::middleware(['checkUserToEdit', 'auth', 'verified', 'checkPasswordEmpty'])->group(function () {
    Route::patch('users/{user:id}', [UserController::class, 'update'])->name('profile.update');
    Route::patch('users/update-banner/{user:id}', [UserController::class, 'updateBanner'])->name('profile.updateBanner');
});

// Edit Auth Wallpaper
Route::middleware(['isAdmin', 'auth'])->group(function () {
    Route::patch('auth/update-banner', [SettingController::class, 'updateWallpaper'])->name('auth.updateWallpaper');
    Route::patch('auth/update-setting', [SettingController::class, 'updateAuthSetting'])->name('auth.updateSetting');
});


// Setting Account
Route::middleware(['checkUserToEdit', 'auth', 'verified', 'password.confirm'])->group(function () {
    Route::get('/settings/account/@{username}', [UserController::class, 'showSettingAccount'])->name('settings.account');
});
Route::middleware(['auth', 'verified', 'password.confirm'])->group(function () {
    Route::patch('/passwords/update', [UserController::class, 'updatePassword'])->name('password.update');
    Route::patch('/emails/update', [UserController::class, 'updateEmail'])->name('email.update');
    Route::delete('/account/delete', [UserController::class, 'deleteAccount'])->name('account.delete');
});

// Setting Application
Route::middleware(['auth', 'verified', 'isAdmin'])->group(function () {
    Route::get('/settings/application', [SettingController::class, 'showSettingApplication'])->name('settings.application');
});