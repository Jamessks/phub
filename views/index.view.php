<?php require('partials/head.php') ?>
<?php require('partials/nav.php') ?>
<?php require('partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <p>Hello, <?= $_SESSION['user']['email'] ?? 'Guest' ?>. Welcome to the home page.</p>

        <div class="mt-6">
            <div class="bg-gray-800 text-white p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-orange-700">Discover Our Pornstars</h2>
                <a class="block mb-1 px-4 py-2 bg-orange-500 text-black rounded hover:bg-orange-600 max-w-[140px] mt-10" href="/pornstars/list">View Pornstars</a>
            </div>
        </div>
    </div>
</main>

<?php require('partials/footer.php') ?>