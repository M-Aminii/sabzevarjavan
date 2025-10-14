document.addEventListener("DOMContentLoaded", () => {
    const loginTab = document.getElementById("loginTab");
    const registerTab = document.getElementById("registerTab");
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const underline = document.querySelector(".tab-underline");

    loginTab.addEventListener("click", () => {
        loginTab.classList.add("active");
        registerTab.classList.remove("active");
        loginForm.style.display = "flex";
        registerForm.style.display = "none";
        underline.style.right = "0%";
    });

    registerTab.addEventListener("click", () => {
        registerTab.classList.add("active");
        loginTab.classList.remove("active");
        loginForm.style.display = "none";
        registerForm.style.display = "flex";
        underline.style.right = "50%";
    });
});

