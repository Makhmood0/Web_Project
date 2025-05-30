document.addEventListener("DOMContentLoaded", () => {
    fetch("../backend/get_programmes.php")
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById("programme");
            data.forEach(p => {
                const option = document.createElement("option");
                option.value = p.id;
                option.textContent = p.title;
                select.appendChild(option);
            });
        });

    document.getElementById("withdrawForm").addEventListener("submit", async (e) => {
        e.preventDefault();
        const email = document.getElementById("email").value.trim();
        const programme_id = document.getElementById("programme").value;

        const res = await fetch("../backend/delete_interest.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email, programme_id })
        });

        const result = await res.json();
        const msg = document.getElementById("messageBox");
        msg.textContent = result.success ? "✅ Interest withdrawn successfully!" : "❌ " + result.message;
    });
});
