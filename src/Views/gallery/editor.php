<?php
// src/Views/gallery/editor.php
?>
<section class="max-w-6xl mx-auto mt-16 bg-white dark:bg-gray-800 p-10 rounded-2xl shadow-xl">
  <h1 class="text-3xl font-bold mb-10 text-center text-gray-900 dark:text-white">Snapshot</h1>

  <form method="POST" action="/editor" enctype="multipart/form-data">
    <div class="flex flex-col grid-cols-1 gap-10">
      <!-- Preview & Capture Section -->
      <div class="flex-1 flex flex-col items-center">
        <div class="relative w-full max-w-xl aspect-video bg-black rounded-xl overflow-hidden shadow-lg">
          <video id="videoPreview" autoplay playsinline class="w-full h-full object-cover"></video>
          <canvas id="canvasPreview" class="absolute inset-0 w-full h-full hidden"></canvas>
        </div>

        <!-- Controls -->
        <div class="mt-6 flex flex-wrap gap-4 justify-center">
          <button id="captureBtn" type="button" class="bg-plum hover:bg-fire-brick text-white font-semibold py-2 px-6 rounded-lg transition disabled:opacity-50" disabled>
            Capture
          </button>
          <label for="fileUpload" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 font-semibold py-2 px-6 rounded-lg cursor-pointer hover:bg-gray-300 transition">
            Upload File
            <input type="file" id="fileUpload" name="photo" accept="image/*" class="hidden">
          </label>
        </div>

        <!-- Hidden input to store data URL for server post -->
        <input type="hidden" name="captured_image" id="capturedImage">
        <input type="hidden" name="overlay_id" id="overlayId">
      </div>

      <!-- Overlay Selection & Thumbnails -->
      <div class="flex-1">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Select Overlay</h2>
        <div id="overlayList" class="grid grid-cols-3 sm:grid-cols-4 gap-4 mb-10">
          <?php if (empty($overlays)): ?>
          <p class="text-gray-500">No overlays yet.</p>
          <?php else: ?>
          <?php foreach ($overlays as $ov): ?>
            <img src="<?= htmlspecialchars($ov['url']) ?>" 
                 alt="Overlay <?= htmlspecialchars($ov['name']) ?>" 
                 data-id="<?= $ov['id'] ?>" 
                 class="overlay-thumb w-24 h-24 object-cover rounded-xl cursor-pointer border-2 border-transparent hover:border-plum transition">
          <?php endforeach; ?>
          <?php endif;?>
        </div>

        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Your Past Photos</h2>
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
          <?php if (empty($images)): ?>
            <p class="text-gray-500">No photos yet.</p>
          <?php else: ?>
            <?php foreach ($images as $img): ?>
              <img src="<?= htmlspecialchars($img['filename']) ?>" alt="Your photo" class="w-full h-24 object-cover rounded-xl shadow-md">
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="mt-10 text-center">
      <button type="submit" class="bg-plum hover:bg-fire-brick text-white font-semibold py-3 px-8 rounded-lg text-lg transition">
        Submit Photo
      </button>
    </div>
  </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const video = document.getElementById('videoPreview');
  const canvas = document.getElementById('canvasPreview');
  const captureBtn = document.getElementById('captureBtn');
  const overlayList = document.getElementById('overlayList');
  const overlayIdInput = document.getElementById('overlayId');
  const capturedImageInput = document.getElementById('capturedImage');
  const fileInput = document.getElementById('fileUpload');

  let selectedOverlay = null;

  // Webcam initialization
  if (navigator.mediaDevices?.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(stream => {
        video.srcObject = stream;
        captureBtn.disabled = false;
      })
      .catch(() => {
        console.warn('Webcam unavailable, fallback to file upload.');
        fileInput.parentElement.style.display = 'block';
      });
  }

  // Overlay selection
  overlayList.addEventListener('click', event => {
    const target = event.target;
    if (target.tagName === 'IMG') {
      document.querySelectorAll('.overlay-thumb').forEach(img => img.classList.remove('border-plum'));
      target.classList.add('border-plum');
      selectedOverlay = target.src;
      overlayIdInput.value = target.dataset.id;
      captureBtn.disabled = false;
    }
  });

  // Capture snapshot and draw overlay
  captureBtn.addEventListener('click', () => {
    const ctx = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.classList.remove('hidden');

    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    if (selectedOverlay) {
      const overlayImg = new Image();
      overlayImg.crossOrigin = 'anonymous';
      overlayImg.src = selectedOverlay;
      overlayImg.onload = () => {
        ctx.drawImage(overlayImg, 0, 0, canvas.width, canvas.height);
      };
    }
    const imageData = canvas.toDataURL('image/jpeg');
    capturedImageInput.value = imageData;
  });
});
</script>

