<h1>Login</h1>

<?php if (!empty($flash)): ?>
  <div class="flash">
    <?php foreach ($flash as $type => $msg): ?>
      <div class="flash-<?= htmlspecialchars($type) ?>">
        <?= htmlspecialchars($msg) ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<form method="POST" action"/login">
    <label>E-mail:</label></br>
    <input
        type="email"
        name="email"
        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
        required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
