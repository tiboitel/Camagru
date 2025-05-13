<section class="max-w-md mx-auto mt-12 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
  <h1 class="text-2xl font-semibold mb-6 text-center">Create an Account</h1>

  <?php require_once('../src/Views/partials/flash.php'); ?>
  <form method="POST" action="/register" class="space-y-5">
    <div>
      <label class="block text-sm font-medium mb-1" for="username">Username</label>
      <input
        id="username"
        type="text"
        name="username"
        value="<?= htmlspecialchars($old['username'] ?? ''); ?>"
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
        value="<?= htmlspecialchars($old['email'] ?? ''); ?>"
        required
        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition"
      >
    </div>
    <div>
      <label class="block text-sm font-medium mb-1" for="password">Password</label>
      <input
        id="password"
        type="password"
        name="password"
        required
        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition"
      >
    </div>
    <div>
      <label class="block text-sm font-medium mb-1" for="confirm_password">Confirm your password</label>
      <input
        id="confirm_password"
        type="password"
        name="confirm_password"
        required
        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-plum transition"
      >
    </div>
    <button
      type="submit"
      class="w-full bg-plum hover:bg-fire-brick text-white font-semibold py-2 rounded-lg transition"
    >
      Register
    </button>
  </form>

  <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
    Already have an account?
    <a href="/login" class="text-plum hover:underline">Log in</a>
  </p>
</section>

