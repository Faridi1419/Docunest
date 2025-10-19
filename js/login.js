// js/login.js

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");

  form.addEventListener("submit", (e) => {
    //e.preventDefault(); // prevent page reload

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    // Retrieve users from localStorage (mock database)
    const users = JSON.parse(localStorage.getItem("users")) || [];


    // Find matching user
    const user = users.find(
      (u) => u.email === email && u.password === password
    );

    if (user) {
      // Store logged-in user in localStorage
      localStorage.setItem("loggedInUser", JSON.stringify(user));

      alert(`Welcome back, ${user.username || "User"}!`);

      // Redirect to vault (library) page
      window.location.href = "vault.php";
    } else {
      alert("Invalid email or password. Please try again.");
    }
  });
});
