document.addEventListener("DOMContentLoaded", () => {
  const loggedInUser = JSON.parse(localStorage.getItem("loggedInUser"));
  if (!loggedInUser) {
    alert("Please log in first!");
    window.location.href = "login.html";
    return;
  }

  const fileList = document.getElementById("fileList");
  const dropArea = document.getElementById("drop-area");
  const uploadInput = document.getElementById("uploadInput");
  const uploadBtn = document.querySelector(".upload-btn");

  // --- Load documents from localStorage ---
  const allDocs = JSON.parse(localStorage.getItem("documents")) || {};
  const userDocs = allDocs[loggedInUser.email] || [];

  // --- Display existing files ---
  function displayFiles() {
    fileList.innerHTML = "";
    if (userDocs.length === 0) {
      fileList.innerHTML = "<p>No documents uploaded yet.</p>";
      return;
    }

    userDocs.forEach((doc, index) => {
      const div = document.createElement("div");
      div.classList.add("file-item");
      div.innerHTML = `
        <p>${doc.name}</p>
        ${
          doc.type.startsWith("image/")
            ? `<img src="${doc.url}" alt="${doc.name}" class="preview-img">`
            : `<embed src="${doc.url}" type="application/pdf" class="preview-pdf">`
        }
        <button class="remove-btn" data-index="${index}">Remove</button>
      `;
      fileList.appendChild(div);
    });

    // ----- add and remove Button Functionality 
    document.querySelectorAll(".remove-btn").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        const index = e.target.getAttribute("data-index");
        userDocs.splice(index, 1);
        allDocs[loggedInUser.email] = userDocs;
        localStorage.setItem("documents", JSON.stringify(allDocs));
        displayFiles();
      });
    });
  }

  // --- Handle file uploads ---
  function handleFiles(files) {
    Array.from(files).forEach((file) => {
      const reader = new FileReader();
      reader.onload = (e) => {
        userDocs.push({
          name: file.name,
          type: file.type,
          url: e.target.result,
        });
        allDocs[loggedInUser.email] = userDocs;
        localStorage.setItem("documents", JSON.stringify(allDocs));
        displayFiles();
      };
      reader.readAsDataURL(file);
    });
  }

  // --- Drag & Drop support ---
  dropArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropArea.style.background = "#ffe2ee";
  });

  dropArea.addEventListener("dragleave", () => {
    dropArea.style.background = "#fff6fa";
  });

  dropArea.addEventListener("drop", (e) => {
    e.preventDefault();
    dropArea.style.background = "#fff6fa";
    handleFiles(e.dataTransfer.files);
  });

  // --- File select button ---
  uploadBtn.addEventListener("click", () => uploadInput.click());
  uploadInput.addEventListener("change", (e) => handleFiles(e.target.files));

  // --- Show files on page load ---
  displayFiles();
});
