const leftContainer = document.querySelector('.info1');
const rightContainer = document.querySelector('.info2');
const uploadLinks = document.querySelectorAll('span');
const uploadInput = document.querySelector('.upload');
const uploadPlaceHolder = document.querySelector('.no-img');
const imgPreviews = document.querySelectorAll('.img-prv');
const imgContainer = document.querySelector('.img-place');
const warningUpload = document.querySelector('.warning');

function resizeLeftContainer() {
    rightContainer.style.height = (window.innerWidth > 992) ? leftContainer.offsetHeight + 'px' : 'auto';
}

// upload functionality
uploadLinks.forEach((link) => {
    link.addEventListener('click', () => {
        uploadInput.click();
    })
});

function showImages(images) {
    if (images.length > 0) {
        uploadPlaceHolder.style.setProperty('display', 'none', 'important');
        imgContainer.classList.add('img-ctn');
        uploadLinks[1].style.display = 'block'
        for (let i = images.length; i < 4; i++) {
            imgPreviews[i].style.backgroundImage = '';
        }
        for (let i = 0; i < images.length; i++) {
            imgPreviews[i].style.backgroundImage = `url(${URL.createObjectURL(images[i])})`;
        }
    }
}

uploadInput.addEventListener('change', (event) => {
    const newImages = uploadInput.files;
    if (newImages.length > 4) {
        warningUpload.style.display = 'block';
        return;
    }
    showImages(newImages);
});

// resizing left container
resizeLeftContainer();
window.addEventListener('resize', () => {
    resizeLeftContainer();
});
