document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  const username = document.getElementById("username");
  const password = document.getElementById("password");

  form.addEventListener("submit", (e) => {
    let valid = true;

    document.querySelectorAll(".error").forEach(el => el.textContent = "");

    if (username.value.trim().length < 3) {
      document.getElementById("usernameError").textContent = "Enter a valid username";
      valid = false;
    }

    if (password.value.trim().length < 6) {
      document.getElementById("passwordError").textContent = "Password must be at least 6 characters";
      valid = false;
    }

    if (!valid) {
      e.preventDefault();
    }
  });
});
