// QuickDesk JavaScript Functions

document.addEventListener("DOMContentLoaded", () => {
  // Auto-hide alerts after 5 seconds
  const alerts = document.querySelectorAll(".alert")
  alerts.forEach((alert) => {
    if (!alert.classList.contains("alert-danger")) {
      setTimeout(() => {
        alert.style.opacity = "0"
        setTimeout(() => {
          alert.remove()
        }, 300)
      }, 5000)
    }
  })

  // File upload preview
  const fileInput = document.getElementById("attachment")
  if (fileInput) {
    fileInput.addEventListener("change", (e) => {
      const file = e.target.files[0]
      if (file) {
        const fileSize = (file.size / 1024 / 1024).toFixed(2)
        const fileName = file.name

        // Create preview element
        let preview = document.getElementById("file-preview")
        if (!preview) {
          preview = document.createElement("div")
          preview.id = "file-preview"
          preview.className = "mt-2 p-2 bg-light rounded"
          fileInput.parentNode.appendChild(preview)
        }

        preview.innerHTML = `
                    <small class="text-muted">
                        <i class="fas fa-file me-1"></i>
                        ${fileName} (${fileSize} MB)
                    </small>
                `
      }
    })
  }

  // Confirm delete actions
  const deleteButtons = document.querySelectorAll("[data-confirm-delete]")
  deleteButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      if (!confirm("Are you sure you want to delete this item?")) {
        e.preventDefault()
      }
    })
  })

  // Auto-refresh ticket status
  if (window.location.search.includes("page=ticket-detail")) {
    // Refresh every 30 seconds
    setInterval(() => {
      // You could implement AJAX refresh here
    }, 30000)
  }

  // Form validation
  const forms = document.querySelectorAll("form[data-validate]")
  forms.forEach((form) => {
    form.addEventListener("submit", (e) => {
      const requiredFields = form.querySelectorAll("[required]")
      let isValid = true

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          field.classList.add("is-invalid")
          isValid = false
        } else {
          field.classList.remove("is-invalid")
        }
      })

      if (!isValid) {
        e.preventDefault()
        alert("Please fill in all required fields.")
      }
    })
  })

  // Search functionality
  const searchInput = document.getElementById("search")
  if (searchInput) {
    let searchTimeout
    searchInput.addEventListener("input", () => {
      clearTimeout(searchTimeout)
      searchTimeout = setTimeout(() => {
        // Auto-submit search form after 500ms of no typing
        const form = searchInput.closest("form")
        if (form) {
          form.submit()
        }
      }, 500)
    })
  }

  // Tooltip initialization
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  const bootstrap = window.bootstrap // Declare the bootstrap variable
  tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))

  // Status color updates
  function updateStatusColors() {
    const statusBadges = document.querySelectorAll(".status-badge")
    statusBadges.forEach((badge) => {
      const status = badge.textContent.toLowerCase().replace(" ", "_")
      badge.className = `badge bg-${getStatusColor(status)}`
    })
  }

  function getStatusColor(status) {
    switch (status) {
      case "open":
        return "warning"
      case "in_progress":
        return "info"
      case "resolved":
        return "success"
      case "closed":
        return "secondary"
      default:
        return "secondary"
    }
  }

  // Initialize status colors
  updateStatusColors()
})

// Utility functions
function showLoading(element) {
  element.disabled = true
  element.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Loading...'
}

function hideLoading(element, originalText) {
  element.disabled = false
  element.innerHTML = originalText
}

function showNotification(message, type = "info") {
  const alertDiv = document.createElement("div")
  alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`
  alertDiv.style.cssText = "top: 20px; right: 20px; z-index: 9999; min-width: 300px;"
  alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `

  document.body.appendChild(alertDiv)

  // Auto-remove after 5 seconds
  setTimeout(() => {
    alertDiv.remove()
  }, 5000)
}

// AJAX helper function
function makeAjaxRequest(url, data, callback) {
  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => callback(data))
    .catch((error) => {
      console.error("Error:", error)
      showNotification("An error occurred. Please try again.", "danger")
    })
}
