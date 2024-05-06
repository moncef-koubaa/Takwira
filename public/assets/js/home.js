// Get the range input and the label
var rangeInputmax = document.getElementById("priceMax");
var labelmax = document.getElementById('realprice1');
var rangeInputmin = document.getElementById("priceMin");
var labelmin = document.getElementById('realprice2');

// Function to update the label text
function updateLabel1() {
    // Calculate the percentage
    var percentage = (rangeInputmax.value  *1+50   );
    // Update the label text
    rangeInputmin.max = this.value;
    // Ensure that range2 value doesn't exceed its new max
    if (parseInt(rangeInputmin.value) > parseInt(rangeInputmin.max)) {
        rangeInputmin.value = rangeInputmin.max;
    }
    labelmax.textContent = percentage.toFixed(0) + "dt";
}
function updateLabel2() {
    rangeInputmax.min = this.value;
    // Ensure that range2 value doesn't exceed its new max
    if (parseInt(rangeInputmax.value) < parseInt(rangeInputmax.min)) {
        rangeInputmax.value = rangeInputmax.min;
    }
    var percentage = (rangeInputmin.value  *1+50   );
    // Update the label text
    labelmin.textContent = percentage.toFixed(0) + "dt";
}

// Call the function initially
updateLabel1();
updateLabel2();

// Add event listener to the range input
rangeInputmax.addEventListener("input", updateLabel1);
rangeInputmin.addEventListener("input", updateLabel2);