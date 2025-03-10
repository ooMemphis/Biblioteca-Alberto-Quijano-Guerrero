document.getElementById("loginForm").addEventListener("submit", async function (event) {
    event.preventDefault();
    
    const userType = document.getElementById("userType").value;
    const universityCode = document.getElementById("universityCode").value;
    const password = document.getElementById("password").value;
    
    if (!userType || !universityCode || !password) {
        alert("Todos los campos son obligatorios.");
        return;
    }
    
    const formData = new FormData();
    formData.append("userType", userType);
    formData.append("universityCode", universityCode);
    formData.append("password", password);
    
    try {
        const response = await fetch("php/login.php", {
            method: "POST",
            body: formData
        });
        
        const data = await response.json();
        
        if (data.status === "success") {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error("Error en la solicitud:", error);
        alert("Hubo un problema al procesar la solicitud.");
    }
});
