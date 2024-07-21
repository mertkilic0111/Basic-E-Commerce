
function initializeZoom() {
    const mainImage = document.getElementById('main-image');
    const zoomBox = document.getElementById('zoom-box');
    const zoomBoxMobile = document.getElementById('zoom-box-mobile');
    const thumbnails = document.querySelectorAll('.thumbnail');

    thumbnails.forEach(item => {
        item.addEventListener('click', event => {
            const newSrc = event.target.src.replace('150', '600x400');
            mainImage.src = newSrc;
            thumbnails.forEach(thumbnail => {
                thumbnail.classList.remove('selected-thumbnail');
                thumbnail.classList.add('border-transparent');
            });
            event.target.classList.add('selected-thumbnail');
            event.target.classList.remove('border-transparent');
        });
    });

    mainImage.addEventListener('click', function () {
        if (!isMobile()) {
            if (zoomBox.classList.contains('hidden')) {
                const mainImageRect = mainImage.getBoundingClientRect();
                zoomBox.style.right = `${-320}px`;
                zoomBox.style.top = `${mainImageRect.top - 130}px`;
                zoomBox.classList.remove('hidden');
                zoomBox.style.display = 'block';
            } else {
                zoomBox.classList.add('hidden');
                zoomBox.style.display = 'none';
            }
        }
    });

    mainImage.addEventListener('mousemove', function (e) {
        if (!zoomBox.classList.contains('hidden') && !isMobile()) {
            const x = e.offsetX / this.width * 100;
            const y = e.offsetY / this.height * 100;
            zoomBox.style.backgroundImage = `url(${this.src})`;
            zoomBox.style.backgroundSize = `${this.width}px ${this.height}px`;
            zoomBox.style.backgroundPosition = `${x}% ${y}%`;
        }
    });

    mainImage.addEventListener('touchstart', function (e) {
        if (isMobile()) {
            e.preventDefault();
            const mainImageRect = mainImage.getBoundingClientRect();
            zoomBoxMobile.style.top = `${mainImageRect.bottom - 88}px`;
            zoomBoxMobile.style.left = `${mainImageRect.left - 18}px`;
            zoomBoxMobile.classList.remove('hidden');
            zoomBoxMobile.style.display = 'block';
        }
    });

    mainImage.addEventListener('touchmove', function (e) {
        if (isMobile()) {
            const touch = e.touches[0];
            const x = (touch.pageX - mainImage.getBoundingClientRect().left) / mainImage.width * 100;
            const y = (touch.pageY - mainImage.getBoundingClientRect().top) / mainImage.height * 100;
            zoomBoxMobile.style.backgroundImage = `url(${mainImage.src})`;
            zoomBoxMobile.style.backgroundSize = `${mainImage.width}px ${mainImage.height}px`;
            zoomBoxMobile.style.backgroundPosition = `${x}% ${y}%`;
        }
    });

    mainImage.addEventListener('touchend', function () {
        if (isMobile()) {
            zoomBoxMobile.classList.add('hidden');
            zoomBoxMobile.style.display = 'none';
        }
    });

    document.addEventListener('click', function (e) {
        if (!mainImage.contains(e.target) && !zoomBox.contains(e.target)) {
            zoomBox.classList.add('hidden');
            zoomBox.style.display = 'none';
            zoomBoxMobile.classList.add('hidden');
            zoomBoxMobile.style.display = 'none';
        }
    });

    function isMobile() {
        return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    }
}