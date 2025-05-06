const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

// matching password validation
window.onload = function () {
    var txtPassword = document.getElementById("txtPassword");
    var txtConfirmPassword = document.getElementById("txtConfirmPassword");
    txtPassword.onchange = ConfirmPassword;
    txtConfirmPassword.onkeyup = ConfirmPassword;
    function ConfirmPassword() {
        txtConfirmPassword.setCustomValidity("");
        if (txtPassword.value != txtConfirmPassword.value) {
            txtConfirmPassword.setCustomValidity("Passwords do not match.");
        }
    }

}

// pop up terms and conditions
let termsBtn = document.querySelector(".show-btn");
let termsContainer = document.querySelector(".containerBg");
let termsClose = document.querySelector("#closeTerms");

termsBtn.addEventListener('click', ()=>{
    termsContainer.classList.add('active');
});

termsClose.addEventListener('click', ()=>{
    termsContainer.classList.remove('active');
});

document.getElementById('goBackBtn').addEventListener('click', function() {
    window.location.href = '/';  // Change 'welcome.html' to your actual welcome page URL
  });
