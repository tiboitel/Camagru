<section class="max-w-md mx-auto mt-12 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
  <h1 class="text-2xl font-semibold mb-6 text-center">Your Profile</h1>
  <?php require_once('../src/Views/partials/flash.php'); ?>
  <form method="POST" action="/profile" class="space-y-5">
    <div>
      <label class="block text-sm font-medium mb-1" for="username">Username</label>
      <input
        id="username"
        name="username"
        type="text"
        value="<?= htmlspecialchars($user['username']) ?>"
        required
        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition"
      >
    </div>
    <div>
      <label class="block text-sm font-medium mb-1" for="email">Email</label>
      <input
        id="email"
        type="email"
        name="email"
        value="<?= htmlspecialchars($user['email']) ?>"
        required
        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition"
      >
    </div>
    <div>
      <label class="block text-sm font-medium mb-1" for="password">
        New Password <span class="text-xs text-gray-500">(leave blank to keep)</span>
      </label>
      <input
        id="password"
        type="password"
        name="password"
        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition"
      >
    </div>
    <div class="flex items-center space-x-2">
      <input
        id="notify"
        type="checkbox"
        name="notify"
        <?= $user['notify_on_comment'] ? 'checked' : '' ?>
        class="accent-plum"
      >
      <label for="notify" class="text-sm">Notify me on new comments</label>
    </div>
    <button
      type="submit"
      class="w-full bg-plum hover:bg-fire-brick text-white font-semibold py-2 rounded-lg transition"
    >
      Save Changes
    </button>
  </form>

  <h2 class="text-xl font-semibold mt-12 mb-4">Your Photos</h2>

  <?php if (empty($images)): ?>
    <p class="text-gray-500 dark:text-gray-400 text-center">You haven’t uploaded any photos yet.</p>
  <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($images as $img): ?>
        <div class="relative bg-white dark:bg-gray-700 rounded-2xl overflow-hidden shadow">
          <img src="<?= htmlspecialchars($img['url']) ?>" class="w-full h-40 object-cover">
          <form method="POST" action="/image/delete" class="absolute top-2 right-2">
            <input type="hidden" name="id" value="<?= $img['id'] ?>">
            <button type="submit" class="bg-ou-crimson hover:bg-fire-brick text-white p-1 rounded-full">✕</button>
          </form>
          <div class="p-3 text-xs text-gray-500 dark:text-gray-400">
            <?= htmlspecialchars($img['created_at']) ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

