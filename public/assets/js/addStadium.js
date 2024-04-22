const leftContainer = document.querySelector('.info1');
const rightContainer = document.querySelector('.info2');

function resizeLeftContainer() {
    rightContainer.style.height = leftContainer.offsetHeight + 'px';
}

// on load
resizeLeftContainer();