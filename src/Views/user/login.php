<section class="max-w-md mx-auto mt-12 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
  <h1 class="text-2xl font-semibold mb-6 text-center">Login to Camagru</h1>

  <?php require_once('../src/Views/partials/flash.php'); ?>
  <form method="POST" action="/login" class="space-y-5">
    <div>
      <label class="block text-sm font-medium mb-1" for="email">Email</label>
      <input
        id="email"
        type="email"
        name="email"
        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
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
      <span class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
        <a href ="/password/forgot" class="text-plum hover:underline">Forgotten password ?</a>
      </span>
    </div>
    <button
      type="submit"
      class="w-full bg-plum hover:bg-fire-brick text-white font-semibold py-2 rounded-lg transition"
    >
      Log In
    </button>
  </form>

  <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
    Don’t have an account?
    <a href="/register" class="text-plum hover:underline">Sign up</a>
</section>

