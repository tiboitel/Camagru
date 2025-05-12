<section class="max-w-md mx-auto mt-12 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
  <h1 class="text-2xl font-semibold mb-6 text-center">Reset Password</h1>

  <?php if (!empty($flash)): ?>
    <div class="space-y-2 mb-6">
      <?php foreach ($flash as $type => $msg): ?>
        <div class="flash flash-<?= htmlspecialchars($type) ?> flex items-center">
          <svg class="w-5 h-5 mr-2" fill="currentColor"><!-- icon --></svg>
          <span><?= htmlspecialchars($msg) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="/password/reset" class="space-y-5">
    <input type="hidden" name="token" value="<?= $token ?>">

    <div>
      <label class="block text-sm font-medium mb-1" for="password">New Password</label>
      <input
        id="password"
        type="password"
        name="password"
        required
        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition"
      >
    </div>

    <div>
      <label class="block text-sm font-medium mb-1" for="password_confirmation">Confirm New Password</label>
      <input
        id="password_confirmation"
        type="password"
        name="password_confirmation"
        required
        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition"
      >
    </div>

    <button
      type="submit"
      class="w-full bg-plum hover:bg-fire-brick text-white font-semibold py-2 rounded-lg transition"
    >
      Update Password
    </button>
  </form>
</section>

