document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.getElementById("registerForm");

    registerForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        // Verificar que las contraseñas coincidan
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        
        if (password !== confirmPassword) {
            alert("Las contraseñas no coinciden.");
            return;
        }

        if (!document.getElementById("terms").checked) {
            alert("Debes aceptar los términos y condiciones.");
            return;
        }

        const formData = new FormData(registerForm);

        try {
            const response = await fetch("php/register.php", {
                method: "POST",
                body: formData
            });

            // Verifica el estado de la respuesta
            if (!response.ok) {
                throw new Error(`Error del servidor: ${response.status}`);
            }

            // Verifica la respuesta como texto primero
            const textResponse = await response.text(); // Obtiene la respuesta como texto
            console.log(textResponse); // Muestra la respuesta en la consola

            // Luego intenta procesar la respuesta como JSON
            let data;
            try {
                data = JSON.parse(textResponse); // Analiza la respuesta como JSON
            } catch (e) {
                throw new Error("Error al procesar la respuesta JSON: " + e.message);
            }

            // Manejo de la respuesta JSON
            if (data.message) {
                alert(data.message);
            }

            if (data.status === "success") {
                registerForm.reset();
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Hubo un problema en el servidor. Inténtalo más tarde.");
        }
    });
});
