<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="container mx-auto px-4 py-10">
        <!-- Profile Header -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-8">
            <div class="flex justify-center md:justify-end">
                <img <?= getThumbnailAttributes($data['thumbnail']['url'], $data['pornstar']['name']); ?> class="object-cover w-[234px] h-[344px] rounded-lg border-2 border-orange-700" />
            </div>
            <div class="text-center md:text-left flex flex-col justify-center space-y-4">
                <h1 class="text-4xl font-bold text-orange-700"><?= $data['pornstar']['name'] ?></h1>
                <p class="text-white mt-1">License: <?= $data['pornstar']['license'] ?></p>
                <p class="text-white mt-1">Wl Status: <?= $data['pornstar']['wlStatus'] ?></p>
                <a class="block mb-1 px-4 py-2 bg-orange-500 text-black rounded hover:bg-orange-600 max-w-40" target='_blank' href="<?= $data['pornstar']['link'] ?>">View on Pornhub</a>
            </div>
        </div>

        <!-- Profile Sections -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Attributes -->
            <section class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-orange-700 mb-4">Characteristics</h2>
                <ul class="space-y-4 text-white">
                    <li><span class="font-bold">Hair Color:</span> <?= $data['attributes']['hairColor'] ?></li>
                    <li><span class="font-bold">Ethnicity:</span> <?= $data['attributes']['ethnicity'] ?></li>
                    <li><span class="font-bold">Tattoos:</span> <?= $data['attributes']['tattoos'] ?></li>
                    <li><span class="font-bold">Piercings:</span> <?= $data['attributes']['piercings'] ?></li>
                    <li><span class="font-bold">Breast Size:</span> <?= $data['attributes']['breastSize'] ?></li>
                    <li><span class="font-bold">Breast Type:</span> <?= $data['attributes']['breastType'] ?></li>
                    <li><span class="font-bold">Gender:</span> <?= $data['attributes']['gender'] ?></li>
                    <li><span class="font-bold">Orientation:</span> <?= $data['attributes']['orientation'] ?></li>
                    <li><span class="font-bold">Age:</span> <?= $data['attributes']['age'] ?></li>
                </ul>
            </section>

            <!-- Stats -->
            <section class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-orange-700 mb-4">Stats</h2>
                <ul class="space-y-4 text-white">
                    <li><span class="font-bold">Subscriptions:</span> <?= $data['stats']['subscriptions'] ?></li>
                    <li><span class="font-bold">Monthly Searches:</span> <?= $data['stats']['monthlySearches'] ?></li>
                    <li><span class="font-bold">Total Views:</span> <?= $data['stats']['views'] ?></li>
                    <li><span class="font-bold">Videos Count:</span> <?= $data['stats']['videosCount'] ?></li>
                    <li><span class="font-bold">Premium Videos:</span> <?= $data['stats']['premiumVideosCount'] ?></li>
                    <li><span class="font-bold">White Label Videos:</span> <?= $data['stats']['whiteLabelVideoCount'] ?></li>
                    <li><span class="font-bold">Rank:</span> <?= $data['stats']['rank_value'] ?></li>
                    <li><span class="font-bold">Rank Premium:</span> <?= $data['stats']['rankPremium'] ?></li>
                    <li><span class="font-bold">Rank Worlwide:</span> <?= $data['stats']['rankWl'] ?></li>
                </ul>
            </section>

            <!-- Aliases -->
            <section class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-orange-700 mb-4">Also known as:</h2>
                <?php if (!empty($data['aliases'])): ?>
                    <ul class="space-y-4 text-white">
                        <?php foreach ($data['aliases'] as $alias): ?>
                            <li><?= $alias ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-white">No known aliases</p>
                <?php endif; ?>

            </section>
        </div>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>