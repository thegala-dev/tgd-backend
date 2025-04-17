<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

Route::fallback(fn () => throw new HttpException(
    statusCode: \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED,
    message: 'Unauthorized'
));
