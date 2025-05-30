document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("interestForm");
    const messageBox = document.getElementById("message");

    const urlParams = new URLSearchParams(window.location.search);
    const programmeId = urlParams.get("programme_id");
    document.getElementById("programme_id").value = programmeId;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;

        console.log("Name:", name);
        console.log("Email:", email);
        console.log("Programme ID:", programmeId);

        const response = await fetch("/Web_Project/backend/register_interest.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                name,
                email,
                programme_id: programmeId
            })
        });

        const result = await response.json();

        if (result.success) {
            messageBox.innerText = "✅ Thank you for registering your interest!";
        } else {
            messageBox.innerText = "❌ Error: " + (result.message || "Submission failed");
        }

        form.reset();
    });
});
