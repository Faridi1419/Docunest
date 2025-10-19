document.addEventListener("DOMContentLoaded", () => {

  // --- Redirect if not logged in ---
  const loggedInUser = JSON.parse(localStorage.getItem("loggedInUser"));
  if (!loggedInUser) {
    window.location.href = "log-in.html";
    return;
  }

  // --- Display logged in user ---
  const userInfo = document.querySelector(".user-info p");
  if (userInfo) {
    userInfo.textContent = loggedInUser.username || loggedInUser.email;
  }

  // --- Dark Mode Toggle ---
  const toggleButton = document.getElementById("darkModeToggle");

  if (toggleButton) {
    toggleButton.addEventListener("click", () => {
      document.body.classList.toggle("dark-mode");
      const isDark = document.body.classList.contains("dark-mode");
      localStorage.setItem("darkMode", isDark ? "enabled" : "disabled");
    });

    if (localStorage.getItem("darkMode") === "enabled") {
      document.body.classList.add("dark-mode");
    }
  }

  // --- Sign Out Button ---
  const signOutBtn = document.getElementById("signOutBtn");
  if (signOutBtn) {
    signOutBtn.addEventListener("click", () => {
      localStorage.removeItem("loggedInUser");
      window.location.href = "log-in.html";
    });
  }

  // --- Save Document to My Samples ---
const saveDocBtn = document.getElementById("saveDocBtn");
const editor = document.getElementById("editor");

if (saveDocBtn && editor) {
  saveDocBtn.addEventListener("click", () => {
    const content = editor.innerHTML.trim();
    if (!content) return alert("Document is empty!");

    // Get all samples from localStorage
    const allSamples = JSON.parse(localStorage.getItem("samples")) || {};

    // Get existing samples for this user or initialize empty array
    const userSamples = allSamples[loggedInUser.email] || [];

    // Add new document
    userSamples.push({
      id: Date.now(),
      content: content,
      title: content.split(" ").slice(0, 3).join(" ") + "..."
    });

    // Save back to localStorage
    allSamples[loggedInUser.email] = userSamples;
    localStorage.setItem("samples", JSON.stringify(allSamples));

    alert("Document saved!");
    editor.innerHTML = "";
  });
}


  // --- My Samples Button ---
  const mySamplesBtn = document.getElementById("mySamplesBtn");
  if (mySamplesBtn) {
    mySamplesBtn.addEventListener("click", () => {
      // Go to my-samples.html page
      window.location.href = "my-samples.html";
    });
  }

});


// --- My Documents Button ---
const myDocumentsBtn = document.getElementById("myDocumentsBtn");
if (myDocumentsBtn) {
  myDocumentsBtn.addEventListener("click", () => {
    window.location.href = "my-documents.html";
  });
}
