<?php

use Tiboitel\Camagru\Helpers\Flash;

if (Flash::has()):
  $flashes = Flash::get();
  foreach ($flashes as $flash):
    $type = htmlspecialchars($flash['type']);
    $message = htmlspecialchars($flash['message']);
?>
    <div class="flash flash-<?= $type ?>">
        <?= $message ?>
    </div>
  <?php endforeach;
endif; ?>

