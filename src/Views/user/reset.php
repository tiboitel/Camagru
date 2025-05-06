<section class="max-w-md mx-auto mt-12 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
  <h1 class="text-2xl font-semibold mb-6 text-center">Reset Password</h1>
  <?php if (!empty($flash)): ?>
    <div class="space-y-2 mb-6">
      <?php foreach ($flash as $type => $msg): ?>
        <div class="flash flash-<?= htmlspecialchars($type) ?>">
          <?= htmlspecialchars($msg) ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <form method="POST" action="/password/reset" class="space-y-5">
    <input type="hidden" name="token" value="<?= $token ?>">
    <div>
      <label class="block text-sm font-medium mb-1" for="password">New Password</label>
      <input id="password" type="password" name="password" required>
    </div>
    <button type="submit" class="w-full">Update Password</button>
  </form>
</section>

