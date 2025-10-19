// --- my-samples.js ---

// Get logged-in user
const loggedInUser = JSON.parse(localStorage.getItem("loggedInUser"));
const container = document.getElementById("samplesContainer");

if (!loggedInUser || !container) {
  container.innerHTML = "<p>No user logged in or container not found.</p>";
} else {
  // Load all samples for this user
  const allSamples = JSON.parse(localStorage.getItem("samples")) || {};
  const userSamples = allSamples[loggedInUser.email] || [];

  // Function to render all samples
  function renderSamples() {
    container.innerHTML = ""; // clear container

    if (userSamples.length === 0) {
      container.innerHTML = "<p>No documents saved yet.</p>";
      return;
    }

    userSamples.forEach((doc, index) => {
      const div = document.createElement("div");
      div.classList.add("sample-card");
      div.innerHTML = `
        <div class="sample-content" contenteditable="false">${doc.content}</div>
        <div class="buttons">
          <button class="edit-btn">Edit</button>
          <button class="save-btn" style="display:none;">Save</button>
          <button class="remove-btn">Remove</button>
        </div>
      `;
      container.appendChild(div);

      const editBtn = div.querySelector(".edit-btn");
      const saveBtn = div.querySelector(".save-btn");
      const removeBtn = div.querySelector(".remove-btn");
      const contentDiv = div.querySelector(".sample-content");

      // --- Edit button ---
      editBtn.addEventListener("click", () => {
        contentDiv.contentEditable = true;
        contentDiv.focus();
        editBtn.style.display = "none";
        saveBtn.style.display = "inline-block";
      });

      // --- Save button ---
      saveBtn.addEventListener("click", () => {
        contentDiv.contentEditable = false;
        editBtn.style.display = "inline-block";
        saveBtn.style.display = "none";

        userSamples[index].content = contentDiv.innerHTML;
        allSamples[loggedInUser.email] = userSamples;
        localStorage.setItem("samples", JSON.stringify(allSamples));

        alert("Document updated!");
      });

      // --- Remove button ---
      removeBtn.addEventListener("click", () => {
        if (confirm("Are you sure you want to delete this document?")) {
          userSamples.splice(index, 1); // remove from array
          allSamples[loggedInUser.email] = userSamples;
          localStorage.setItem("samples", JSON.stringify(allSamples));
          renderSamples(); // re-render after deletion
        }
      });
    });
  }

  // Initial render
  renderSamples();
}
