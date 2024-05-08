const mult = document.querySelector('#selectMultipleTimes');
const select = document.querySelectorAll('.select');
const non_select = document.querySelectorAll('.non-select');
const reserve = document.querySelectorAll('.reserve');
const reserve_btn = document.querySelector('#reserve-multiple');
mult.addEventListener('click', (e) => {
    e.preventDefault();
    for (let i = 0; i < select.length; i++) {
        if (mult.textContent === 'Cancel') {
            select[i].innerHTML = "";
            reserve_btn.innerHTML = "";
            reserve[i].innerHTML = "<a href='https://api.preprod.konnect.network/wQsaFMcSS'>Reserve</a>";
        } else {
            select[i].innerHTML = "<input class='form-check-input' type='checkbox' value='' style='cursor:pointer;'>";
            reserve_btn.innerHTML = "<a class='btn my-btn' style='width:auto!important;'>Reserve</a>";
            reserve[i].innerHTML = '';
        }
    }
    for (let i = 0; i < non_select.length; i++) {
        non_select[i].innerHTML = '';
    }
    mult.textContent = (mult.textContent === 'Select Multiple Times') ? 'Cancel' : 'Select Multiple Times';

    // Check the state of checkboxes after the user interaction
    const checkboxes = document.querySelectorAll('.form-check-input');
    checkboxes.forEach(function(checkbox, index) {
        if (checkbox.checked) {
            console.log('Checkbox ' + index + ' is checked');
        } else {
            console.log('Checkbox ' + index + ' is not checked');
        }
    });
});
