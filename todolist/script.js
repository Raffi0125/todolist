// Highlight deadline
document.querySelectorAll("tbody tr").forEach(row => {
    const dueDateText = row.cells[4].innerText;
    const dueDate = new Date(dueDateText.split("-").reverse().join("-"));
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (dueDate < today) {
        row.cells[4].classList.add("overdue");
    } else if (dueDate.getTime() === today.getTime()) {
        row.cells[4].classList.add("today");
    } else {
        row.cells[4].classList.add("upcoming");
    }
});

// Notifikasi popup
window.addEventListener("DOMContentLoaded", () => {
    const alertBox = document.querySelector(".alert");
    if (alertBox) {
        alertBox.classList.add("show");
        setTimeout(() => {
            alertBox.classList.remove("show");
        }, 3000);
    }
});

// Konfirmasi edit dan selesai dengan pesan yang berbeda
document.querySelectorAll(".btn.green, .btn.blue").forEach(btn => {
    btn.addEventListener("click", (e) => {
        const action = btn.classList.contains("green") ? "selesai" : "edit";
        const taskName = btn.closest("tr").cells[1].innerText.trim();
        
        let confirmMsg = "";
        if (action === "selesai") {
            confirmMsg = `Yakin ingin menandai task ${taskName} telah selesai?`;
        } else if (action === "edit") {
            confirmMsg = `Yakin ingin mengedit task ${taskName}?`;
        }
        
        if (!confirm(confirmMsg)) {
            e.preventDefault();
        }
    });
});

document.querySelector(".form").addEventListener("submit", function (e) {
    const taskName = document.getElementById("task").value.trim();
    const priority = document.getElementById("priority").value;
    const dueDate = document.getElementById("due_date").value;
    const action = document.querySelector('button[name="update"]') ? "update" : "tambah";

    if (action === "update") {
        const confirmMsg = `Yakin ingin mengupdate task "${taskName}" dengan prioritas "${priority}" dan jatuh tempo pada ${dueDate}?`;
        if (!confirm(confirmMsg)) {
            e.preventDefault();  // Mencegah form submit jika tidak dikonfirmasi
        }
    }
});

function showToast(message, type = "success") {
    const container = document.getElementById("toast-container");
    const toast = document.createElement("div");
    toast.className = `toast ${type}`;
    toast.innerText = message;

    container.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 4000);
}

document.addEventListener("DOMContentLoaded", function () {
    const notif = document.getElementById("notif");
    if (notif) {
        setTimeout(() => {
            notif.style.opacity = "0";
            setTimeout(() => notif.remove(), 600);
        }, 3000);
    }

    // Dark mode toggle
    const modeIcon = document.createElement("div");
    modeIcon.className = "toggle-mode";
    modeIcon.innerHTML = '<i class="fas fa-adjust"></i>';
    document.body.appendChild(modeIcon);

    modeIcon.addEventListener("click", () => {
        document.body.classList.toggle("dark");
        localStorage.setItem("theme", document.body.classList.contains("dark") ? "dark" : "light");
    });

    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
    }

    // Collapse/Expand Task
    document.querySelectorAll(".toggle-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const card = btn.closest(".task-card");
            const body = card.querySelector(".task-body");

            // Toggle visibility of the task content
            body.classList.toggle("collapsed");

            // Update the icon of the button (expand/collapse)
            const icon = btn.querySelector("i");
            if (body.classList.contains("collapsed")) {
                icon.classList.remove("fa-chevron-up");
                icon.classList.add("fa-chevron-down");
            } else {
                icon.classList.remove("fa-chevron-down");
                icon.classList.add("fa-chevron-up");
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const notif = document.getElementById("notif");
    if (notif) {
        setTimeout(() => {
            notif.style.opacity = "0";
            setTimeout(() => notif.remove(), 600);
        }, 3000);
    }

    const modeIcon = document.createElement("div");
    modeIcon.className = "toggle-mode";
    modeIcon.innerHTML = '<i class="fas fa-adjust"></i>';
    document.body.appendChild(modeIcon);

    modeIcon.addEventListener("click", () => {
        document.body.classList.toggle("dark");
        localStorage.setItem("theme", document.body.classList.contains("dark") ? "dark" : "light");
    });

    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
    }
});