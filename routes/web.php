<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'verify' => false
]);

Route::get('/info', function (){
    if (Auth::check() && Auth::user()->hasRole('Admin'))
        echo phpinfo();
    else
        abort(404);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::any('/search', [\App\Http\Controllers\SearchController::class, 'index']);

    Route::post('/album', [\App\Http\Controllers\AlbumController::class, 'store'])->name('album.store');
    Route::get('/album/create', [\App\Http\Controllers\AlbumController::class, 'create'])->name('album.create');
    Route::get('/album', [\App\Http\Controllers\AlbumController::class, 'index'])->name('album.index');
    Route::post('/album/upload', [\App\Http\Controllers\AlbumController::class, 'upload'])->name('album.upload');
    Route::post('/album/{album}/move', [\App\Http\Controllers\AlbumController::class, 'move'])->name('album.move');
    Route::post('/album/{album}/update', [\App\Http\Controllers\AlbumController::class, 'update'])->name('album.update');
    Route::get('/album/{album}', [\App\Http\Controllers\AlbumController::class, 'show'])->name('album.show');
    Route::get('/album/{album}/download', [\App\Http\Controllers\AlbumController::class, 'download'])->name('album.download');
    Route::get('/album/{album}/delete', [\App\Http\Controllers\AlbumController::class, 'delete'])->name('album.delte');
    Route::get('/album/{album}/restore', [\App\Http\Controllers\AlbumController::class, 'restore'])->name('album.restore');

    Route::get('/trash', [\App\Http\Controllers\TrashController::class, 'index'])->name('trash.index');

    Route::get('/file/{file}', [\App\Http\Controllers\FileController::class, 'show'])->name('file.show');
    Route::get('/file/{file}/delete', [\App\Http\Controllers\FileController::class, 'delete'])->name('file.delete');
    Route::get('/file/{file}/download', [\App\Http\Controllers\FileController::class, 'download'])->name('file.download');
    Route::get('/file/{file}/downloadThumbail', [\App\Http\Controllers\FileController::class, 'downloadThumbail'])->name('file.downloadThumbail');
    Route::post('/file/{file}/comment', [\App\Http\Controllers\FileController::class, 'comment'])->name('file.comment');
    Route::post('/file/{file}/tag', [\App\Http\Controllers\FileController::class, 'tag'])->name('file.tag');
    Route::get('/file/{file}/tag/{tag}/delete', [\App\Http\Controllers\FileController::class, 'tagDelete'])->name('file.tag.delete');
    Route::get('/file/{file}/mark/{person}/delete', [\App\Http\Controllers\FileController::class, 'markDelete'])->name('file.mark.delete');
    Route::post('/file/{file}/mark', [\App\Http\Controllers\FileController::class, 'mark'])->name('file.mark');
    Route::post('/file/{file}/publication', [\App\Http\Controllers\FileController::class, 'publication'])->name('file.publication');
    Route::get('/file/{file}/publication/{publication}/delete', [\App\Http\Controllers\FileController::class, 'publicationDelete'])->name('file.publication.delete');
    Route::post('/file/{file}/update', [\App\Http\Controllers\FileController::class, 'update'])->name('file.update');
    Route::get('/file/{file}/restore', [\App\Http\Controllers\FileController::class, 'restore'])->name('file.restore');

    Route::get('/people', [\App\Http\Controllers\PeopleController::class, 'index'])->name('people.index');
    Route::get('/people/{person}', [\App\Http\Controllers\PeopleController::class, 'show'])->name('people.show');
    Route::get('/people/{person}/delete', [\App\Http\Controllers\PeopleController::class, 'delete'])->name('people.delete');

    Route::get('/tags', [\App\Http\Controllers\TagController::class, 'index'])->name('tags.index');
    Route::get('/tag/{tag}', [\App\Http\Controllers\TagController::class, 'show'])->name('tag.show');
    Route::get('/tag/{tag}/delete', [\App\Http\Controllers\TagController::class, 'delete'])->name('tag.delete');

    Route::get('/platforms', [\App\Http\Controllers\PlatformController::class, 'index'])->name('platform.index');
    Route::get('/platforms/{platform}', [\App\Http\Controllers\PlatformController::class, 'show'])->name('platform.show');
    Route::get('/platforms/{platform}/delete', [\App\Http\Controllers\PlatformController::class, 'delete'])->name('platform.delete');

    Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::post('/users/update', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::post('/user/store', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/delete', [\App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

    Route::get('/user/settings', [\App\Http\Controllers\UserSettingsController::class, 'index'])->name('usersettings.index');
    Route::post('/user/settings', [\App\Http\Controllers\UserSettingsController::class, 'update'])->name('usersettings.update');

    Route::get('/upload', function (){
        $file = \App\Models\File::find(149);
        $path = $file->getThumbnailPath();
        dd($path);
    });
});
