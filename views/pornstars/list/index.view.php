<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main class="bg-black text-white">
    <?php if (!empty($paginatedResults)): ?>
        <div class="grid 2xl:grid-cols-5 lg:grid-cols-3 sm:grid-cols-2 container mx-auto gap-14 p-6 bg-black text-white">
            <?php foreach ($paginatedResults as $item): ?>
                <div class="grid place-content-center item bg-orange-700 bg-opacity-10 rounded-lg p-4 text-center transition-transform transform hover:scale-105 hover:shadow-lg">
                    <img <?= getThumbnailAttributes($item['thumbnail_url'], $item['name']); ?> class="mx-auto object-cover w-[234px] h-[344px] rounded-lg mb-2 border-2 border-orange-700" />
                    <h3 class="text-orange-500 mb-2"><?= $item['name'] ?></h3>
                    <a class="inline-block mb-1 px-4 py-2 bg-orange-500 text-black rounded hover:bg-orange-600" target='_blank' href="<?= $item['link'] ?>">View on Pornhub</a>
                    <a class="inline-block mb-1 px-4 py-2 bg-orange-500 text-black rounded hover:bg-orange-600" href="<?= '/pornstars?id=' . $item['id'] ?>">Visit Profile</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="container mx-auto">
            <p>There is nothing to see here!</p>
        </div>
    <?php endif; ?>

    <?php if (!empty($paginatedResults)): ?>
        <div class="py-20 text-4xl">
            <?php $paginator->render(); ?>
        </div>
    <?php endif; ?>
</main>


<?php require base_path('views/partials/footer.php') ?>