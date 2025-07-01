// Toggle navigation between sections
document.querySelectorAll(".menu a").forEach(link => {
  link.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelectorAll(".menu a").forEach(l => l.classList.remove("active"));
      this.classList.add("active");
      document.querySelectorAll(".content").forEach(section => section.style.display = "none");
      const target = this.getAttribute("href");
      document.querySelector(target).style.display = "block";
  });
});

// Floor update based on building
function updateFloors() {
  const building = document.getElementById("building").value;
  const floorSelect = document.getElementById("floor");
  floorSelect.innerHTML = '<option value="">Select Floor</option>';
  if (building === "Harambee Plaza") {
      for (let i = 1; i <= 5; i++) {
          floorSelect.innerHTML += `<option value="Floor ${i}">Floor ${i}</option>`;
      }
  } else if (building === "Ukulima Cooperative Sacco") {
      for (let i = 1; i <= 3; i++) {
          floorSelect.innerHTML += `<option value="Floor ${i}">Floor ${i}</option>`;
      }
  }
}

// Filter any table
function filterTable(inputId, tableId, type = '') {
  const input = document.getElementById(inputId);
  const filter = input.value.toLowerCase();
  const table = document.getElementById(tableId);
  const rows = table.getElementsByTagName("tr");
  for (let i = 1; i < rows.length; i++) {
      const cells = rows[i].getElementsByTagName("td");
      let match = false;
      for (let j = 0; j < cells.length; j++) {
          const text = cells[j].textContent.toLowerCase();
          if (text.indexOf(filter) > -1) {
              match = true;
              break;
          }
      }
      rows[i].style.display = match ? "" : "none";
  }
}

// Autocomplete for user name in assignments
document.getElementById("user_name").addEventListener("input", function () {
  const input = this.value;
  const suggestions = document.getElementById("suggestions");
  if (input.length < 2) {
      suggestions.innerHTML = "";
      suggestions.style.display = "none";
      return;
  }

  fetch("autocomplete_users.php?q=" + encodeURIComponent(input))
      .then(response => response.json())
      .then(data => {
          suggestions.innerHTML = "";
          data.forEach(user => {
              const li = document.createElement("li");
              li.textContent = `${user.username} (${user.department})`;
              li.dataset.id = user.user_id;
              li.onclick = function () {
                  document.getElementById("user_name").value = user.username;
                  document.getElementById("user_id").value = user.user_id;
                  suggestions.innerHTML = "";
                  suggestions.style.display = "none";
              };
              suggestions.appendChild(li);
          });
          suggestions.style.display = data.length ? "block" : "none";
      });
});

// Edit assignment modal
function editAssignmentModal(assignmentId, returnStatus, returnDate, returnCondition) {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "edit_assignment.php";
  form.innerHTML = `
      <h3>Edit Assignment</h3>
      <input type="hidden" name="assignment_id" value="${assignmentId}">
      <label for="return_status">Return Status:</label>
      <select name="return_status" required>
          <option value="Returned" ${returnStatus === "Returned" ? "selected" : ""}>Returned</option>
          <option value="Not Returned" ${returnStatus === "Not Returned" ? "selected" : ""}>Not Returned</option>
      </select>
      <label for="return_date">Return Date:</label>
      <input type="date" name="return_date" value="${returnDate || ""}">
      <label for="return_condition">Return Condition:</label>
      <input type="text" name="return_condition" value="${returnCondition || ""}">
      <button type="submit">Save Changes</button>
  `;
  const modal = document.createElement("div");
  modal.className = "modal";
  modal.appendChild(form);
  document.body.appendChild(modal);
  modal.addEventListener("click", function (e) {
      if (e.target === modal) modal.remove();
  });
}
