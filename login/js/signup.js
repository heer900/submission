document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("signupForm");
  const username = document.getElementById("username");
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const confirm = document.getElementById("confirm");
  const strengthMeter = document.getElementById("passwordStrength");

  form.addEventListener("submit", (e) => {
    let valid = true;

    // Reset errors
    document.querySelectorAll(".error").forEach(el => el.textContent = "");

    // Username validation
    if (username.value.trim().length < 3) {
      document.getElementById("usernameError").textContent = "Username must be at least 3 characters";
      valid = false;
    }

    // Email validation
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
    if (!email.value.match(emailPattern)) {
      document.getElementById("emailError").textContent = "Enter a valid email";
      valid = false;
    }

    // Password validation
    if (password.value.length < 6) {
      document.getElementById("passwordError").textContent = "Password must be at least 6 characters";
      valid = false;
    }

    // Confirm password validation
    if (password.value !== confirm.value) {
      document.getElementById("confirmError").textContent = "Passwords do not match";
      valid = false;
    }

    if (!valid) {
      e.preventDefault(); // Prevent submission if invalid
    }
  });

  // Password strength meter
  password.addEventListener("input", () => {
    let strength = 0;
    if (password.value.length >= 6) strength++;
    if (/[A-Z]/.test(password.value)) strength++;
    if (/[0-9]/.test(password.value)) strength++;
    if (/[^A-Za-z0-9]/.test(password.value)) strength++;
    strengthMeter.value = strength;
  });
});
