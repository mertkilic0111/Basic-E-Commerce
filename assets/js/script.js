// toast.js
const toastContainer = document.getElementById('toast-container');

function showToast(message) {
    toastContainer.innerHTML = '';

    const toast = document.createElement('div');
    toast.className = 'bg-green-500 text-white p-4 rounded-lg shadow-lg mb-2 flex items-center justify-between relative toast';
    toast.innerHTML = `<span>${message}</span>`;

    const progressBar = document.createElement('div');
    progressBar.className = 'absolute bottom-0 left-0 h-1 bg-white';
    toast.appendChild(progressBar);

    toastContainer.appendChild(toast);

    let width = 100;
    const interval = setInterval(() => {
        width -= 1;
        progressBar.style.width = `${width}%`;
        if (width <= 0) {
            clearInterval(interval);
            toast.remove();
        }
    }, 50);
}

function showToastError(message) {
    toastContainer.innerHTML = '';

    const toast = document.createElement('div');
    toast.className = 'bg-red-500 text-white p-4 rounded-lg shadow-lg mb-2 flex items-center justify-between relative toast';
    toast.innerHTML = `<span>${message}</span>`;

    const progressBar = document.createElement('div');
    progressBar.className = 'absolute bottom-0 left-0 h-1 bg-white';
    toast.appendChild(progressBar);

    toastContainer.appendChild(toast);

    let width = 100;
    const interval = setInterval(() => {
        width -= 1;
        progressBar.style.width = `${width}%`;
        if (width <= 0) {
            clearInterval(interval);
            toast.remove();
        }
    }, 50);
}

function addCart(i) {
    var quantity = document.getElementById('quantity-' + i).value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText == 1) {
                showToast('Ürün sepete eklendi!');
                document.getElementById('add-to-cart-' + i).textContent = 'Sepeti Güncelle (' + quantity + ')';
                document.getElementById('add-to-cart-' + i).setAttribute('onclick', 'updateCart(' + i + ');');
                document.getElementById('remove-from-cart-div-' + i).style.display = 'block';
                document.getElementById('add-to-cart-' + i).setAttribute('id', 'update-to-cart-' + i);
            } else {
                showToastError('Hata oluştu!');
            }
        }
    };
    xhr.send('request=add-cart&quantity=' + quantity + '&i=' + i);
}

function removeCart(i) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            var e = xhr.responseText;
            if (e == 1) {
                showToast('Ürün sepetten kaldırıldı!');
                document.getElementById('quantity-' + i).selectedIndex = 0;
                document.getElementById('remove-from-cart-div-' + i).style.display = 'none';
                document.getElementById('update-to-cart-' + i).textContent = 'Sepete Ekle';
                document.getElementById('update-to-cart-' + i).setAttribute('onclick', 'addCart(' + i + ');');
                document.getElementById('update-to-cart-' + i).setAttribute('id', 'add-to-cart-' + i);
            } else {
                showToastError('Hata oluştu!');
            }
        }
    };
    xhr.send("request=remove-cart&i=" + i);
}

function removeCartFromCart(i) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            var e = xhr.responseText;
            if (e == 1) {
                location.reload();
                // showToast('Ürün sepetten kaldırıldı!');
                // var productRow = document.getElementById('product-tr-' + i);
                // if (productRow) {
                //     productRow.remove();
                // }
            } else {
                showToastError('Hata oluştu!');
            }
        }
    };
    xhr.send("request=remove-cart&i=" + i + '&c=1');
}

function updateCart(i) {
    var quantity = document.getElementById('quantity-' + i).value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText == 1) {
                showToast('Ürün sepete güncellendi!');
                document.getElementById('remove-from-cart-div-' + i).style.display = 'block';
                document.getElementById('update-to-cart-' + i).textContent = 'Sepeti Güncelle (' + quantity + ')';
            } else {
                showToastError('Hata oluştu!');
            }
        }
    };
    xhr.send('request=update-cart&quantity=' + quantity + '&i=' + i); // Fix here
}

function validateForm() {
    var fullName = document.getElementById('name_surname').value;

    if (!fullName) {
        showToastError('Lütfen ad ve soyad alanını doldurunuz.');
        return false;
    }

    saveCart(fullName);
}

function saveCart(fullName) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                if (xhr.responseText == '1') {
                    window.location = 'success.html';
                } else {
                    showToastError('Hata oluştu!');
                }
            } else {
                showToastError('Sunucu hatası oluştu!');
            }
        }
    };
    xhr.send('request=save-cart&name_surname=' + encodeURIComponent(fullName));
}