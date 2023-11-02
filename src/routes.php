<?php

return [
    '~^/hello/(.*)$~' => [\MyProject\Controllers\MainController::class, 'sayHello'],
    '~^/$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^/bye/(.*)$~' => [\MyProject\Controllers\MainController::class, 'sayBye'],
    '~^/articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^/articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^/articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^/articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^/users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^/users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^/users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~^/users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^/comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^/articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
];
