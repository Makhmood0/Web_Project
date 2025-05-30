document.addEventListener("DOMContentLoaded", () => {
    fetch("backend/get_programmes.php")
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById("programmeList");
            container.innerHTML = ""; 

            data.forEach(prog => {
                const card = document.createElement("div");
                card.className = "programme-card";
                card.innerHTML = `
          <h3>${prog.title}</h3>
          <p>${prog.description}</p>
          <a href="programme.html?id=${prog.id}">View Details</a>
        `;
                container.appendChild(card);
            });
        })
        .catch(err => {
            console.error("Failed to load programmes:", err);
        });
});