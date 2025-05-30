document.addEventListener("DOMContentLoaded", () => {
    fetch("../backend/get_programmes.php")
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById("programmeList");
            container.innerHTML = "";
            data.forEach(p => {
                const titleEscaped = p.title.replace(/'/g, "\\'");
                container.innerHTML += `
                    <div class="card">
                        <img src="${p.image}" alt="${p.title}" />
                        <div class="card-body">
                            <div class="card-title">${p.title}</div>
                            <div class="card-text">${p.description}</div>
                            <div class="card-buttons">
                                <button class="info-btn" onclick='showInfo("${titleEscaped}", \`${p.description}\`, \`${JSON.stringify(p.modules)}\`, \`${JSON.stringify(p.tutors)}\`)'>
                                    More info about this programme
                                </button>
                                <button class="register-btn" onclick="openModal(${p.id}, '${titleEscaped}')">
                                    Register for this course
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
        })
        .catch(error => {
            console.error("❌ Error loading programmes:", error);
        });
});

// Modal for Registration
function openModal(id, title) {
    document.getElementById("programme_id").value = id;
    document.getElementById("modalTitle").textContent = title;
    document.getElementById("modal").style.display = "flex";
}

document.getElementById("closeModal").onclick = () => {
    document.getElementById("modal").style.display = "none";
};
document.getElementById("closeInfoModal").onclick = () => {
    document.getElementById("infoModal").style.display = "none";
};

function showInfo(title, description, modules, tutors) {
    if (!description.trim() && !modules.trim() && !tutors.trim()) return;

    let modulesObj, tutorsObj;
    try {
        modulesObj = JSON.parse(modules);
        tutorsObj = JSON.parse(tutors);
    } catch (e) {
        console.error("❌ Failed to parse modules or tutors", e);
        modulesObj = {};
        tutorsObj = {};
    }

    let modulesHTML = "";
    let tutorsHTML = "";

    for (const year in modulesObj) {
        modulesHTML += `<p><strong>${year} Modules:</strong> ${modulesObj[year].join(", ")}</p>`;
    }

    for (const year in tutorsObj) {
        tutorsHTML += `<p><strong>${year} Tutors:</strong> ${tutorsObj[year].join(", ")}</p>`;
    }

    document.getElementById("infoTitle").textContent = title;
    document.getElementById("infoDescription").innerHTML = `<strong>Description:</strong><br>${description}`;
    document.getElementById("infoModules").innerHTML = modulesHTML;
    document.getElementById("infoTutors").innerHTML = tutorsHTML;
    document.getElementById("infoModal").style.display = "flex";
}

// Submit Interest Form
document.getElementById("interestForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const payload = {
        programme_id: parseInt(document.getElementById("programme_id").value),
        gender: document.getElementById("gender").value,
        first_name: document.getElementById("firstName").value.trim(),
        last_name: document.getElementById("lastName").value.trim(),
        email: document.getElementById("email").value.trim(),
        phone: document.getElementById("phone").value.trim(),
    };

    try {
        const response = await fetch("../backend/register_interest.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();
        document.getElementById("messageBox").textContent = result.success
            ? "✅ Registered successfully!"
            : "❌ Error: " + (result.message || "Something went wrong");

        if (result.success) {
            document.getElementById("interestForm").reset();
            setTimeout(() => {
                document.getElementById("modal").style.display = "none";
            }, 2000);
        }

    } catch (err) {
        document.getElementById("messageBox").textContent = "❌ Request failed: " + err.message;
    }
});
