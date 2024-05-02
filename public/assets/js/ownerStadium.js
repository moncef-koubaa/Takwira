const route = document.querySelector("#addButton").getAttribute("data-route");
document.querySelector("#addButton").addEventListener("click", () => {
    window.location.href = route;
});
