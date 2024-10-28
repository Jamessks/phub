<?php

use Core\App;
use Core\Database;
use Dotenv\Dotenv;
use Core\Container;
use Http\models\Pornstar;


it('creates a Pornstar object from JSON data', function () {
    $data = [
        "attributes" => [
            "hairColor" => "Blonde",
            "ethnicity" => "White",
            "tattoos" => true,
            "piercings" => true,
            "breastSize" => 34,
            "breastType" => "A",
            "gender" => "female",
            "orientation" => "straight",
            "age" => 43,
            "stats" => [
                "subscriptions" => 5736,
                "monthlySearches" => 803200,
                "views" => 462294,
                "videosCount" => 52,
                "premiumVideosCount" => 26,
                "whiteLabelVideoCount" => 40,
                "rank_value" => 4535,
                "rankPremium" => 4632,
                "rankWl" => 4189,
            ],
        ],
        "id" => 2,
        "name" => "Aaliyah Jolie",
        "license" => "REGULAR",
        "wlStatus" => "1",
        "aliases" => [
            "Aliyah Julie",
            "Aliyah Jolie",
            "Aaliyah",
            "Macy"
        ],
        "link" => "https://www.pornhub.com/pornstar/aaliyah-jolie",
        "thumbnails" => [
            [
                "height" => 344,
                "width" => 234,
                "type" => "pc",
                "urls" => ["https://ei.phncdn.com/pics/pornstars/000/000/002/(m=lciuhScOb_c)(mh=5Lb6oqzf58Pdh9Wc)thumb_22561.jpg"],
            ],
            [
                "height" => 344,
                "width" => 234,
                "type" => "mobile",
                "urls" => ["https://ei.phncdn.com/pics/pornstars/000/000/002/(m=lciuhScOb_c)(mh=5Lb6oqzf58Pdh9Wc)thumb_22561.jpg"],
            ],
            [
                "height" => 344,
                "width" => 234,
                "type" => "tablet",
                "urls" => ["https://ei.phncdn.com/pics/pornstars/000/000/002/(m=lciuhScOb_c)(mh=5Lb6oqzf58Pdh9Wc)thumb_22561.jpg"],
            ],
        ],
    ];

    $pornstar = new Pornstar(
        $data['attributes'],
        $data['id'],
        $data['name'],
        $data['license'],
        $data['wlStatus'],
        $data['aliases'],
        $data['link'],
        $data['thumbnails']
    );

    // Assertions to check if the object has the correct values
    expect($pornstar->getId())->toBe(2);
    expect($pornstar->getName())->toBe('Aaliyah Jolie');
    expect($pornstar->getLicense())->toBe('REGULAR');
    expect($pornstar->getWlStatus())->toBe('1');
    expect($pornstar->getLink())->toBe('https://www.pornhub.com/pornstar/aaliyah-jolie');
    expect($pornstar->getAttributes()->getHairColor())->toBe('Blonde');
    expect($pornstar->getAttributes()->getStats()->getViews())->toBe(462294);
});
