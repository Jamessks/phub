<?php

it('validates that the passed variable is a string', function () {
    expect(\Core\Validator::string('hello from string validator assertion'))->toBeTrue();
    expect(\Core\Validator::string(123))->toBeTrue();
    expect(\Core\Validator::string(''))->toBeFalse();
});

it('validates that the passed variable is an integer', function () {
    expect(\Core\Validator::integer('hello from string validator assertion'))->toBeFalse();
    expect(\Core\Validator::integer(123))->toBeTrue();
    expect(\Core\Validator::string(''))->toBeFalse();
});

it('validates correct email formats', function () {
    expect(\Core\Validator::email('user@example.com'))->toBeTrue();
    expect(\Core\Validator::email('first.last@example.com'))->toBeTrue();
    expect(\Core\Validator::email('user+name@example.com'))->toBeTrue();
    expect(\Core\Validator::email('user@subdomain.example.com'))->toBeTrue();
    expect(\Core\Validator::email('user@domain.co.uk'))->toBeTrue();
});

it('invalidates incorrect email formats', function () {
    expect(\Core\Validator::email('user@.com'))->toBeFalse();
    expect(\Core\Validator::email('user@com.'))->toBeFalse();
    expect(\Core\Validator::email('@example.com'))->toBeFalse();
    expect(\Core\Validator::email('user@com.123'))->toBeFalse();
    expect(\Core\Validator::email('user@domain..com'))->toBeFalse();
    expect(\Core\Validator::email('user@domain.com.'))->toBeFalse();
    expect(\Core\Validator::email('emailaddress'))->toBeFalse();
    expect(\Core\Validator::email('user@domain,com'))->toBeFalse();
});
