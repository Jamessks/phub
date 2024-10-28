<?php

namespace Tests\Core;

it('ensures the directory of images exists', function () {
    $directory = './public/images';

    // Check if the directory exists
    expect(is_dir($directory))->toBeTrue();
});

it('ensures the default image exists', function () {
    $fullImagePath = '/var/www/phub/public/images/000-image_not_found.png';

    // Check if the image exists
    expect(file_exists($fullImagePath))->toBeTrue();
});
