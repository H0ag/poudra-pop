const trigger = document.getElementById('zoom-trigger');
const targetImg = document.getElementById('target-img');
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');
const closeBtn = document.getElementById('close-lightbox');

// Open lightbox on click
trigger.addEventListener('click', function() {
  lightboxImg.src = targetImg.src;
  lightbox.showModal();
});

// Close lightbox on button click
closeBtn.addEventListener('click', function() {
  lightbox.close();
});

// Close lightbox when clicking outside (on the backdrop)
lightbox.addEventListener('click', function(e) {
  if (e.target === lightbox) {
    lightbox.close();
  }
});