<section class="max-w-md mx-auto mt-12 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
  <h1 class="text-2xl font-semibold mb-6 text-center">Forgot your password?</h1>
  <?php if (!empty($flash)): ?>
    <div class="space-y-2 mb-6">
      <?php foreach ($flash as $type => $msg): ?>
        <div class="flash flash-<?= htmlspecialchars($type) ?>">
          <?= htmlspecialchars($msg) ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <form method="POST" action="/password/forgot" class="space-y-5">
    <div>
      <label class="block text-sm font-medium mb-1" for="email">Email</label>
      <input id="email" type="email" name="email" required class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition">
    </div>
    <button type="submit" class="w-full bg-plum hover:bg-fire-brick text-white font-semibold py-2 rounded-lg transition">Send Reset Link</button>
  </form>
  <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
    <a href="/login" class="text-plum hover:underline">Back to Login</a>
  </p>
</section>

