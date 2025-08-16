<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-sm bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>
        <!-- لاحظ: شلت الـ action -->
        <form id="loginForm" class="space-y-4">
            <input type="email" name="email" placeholder="Email" class="w-full border p-2 rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full border p-2 rounded" required>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                Login
            </button>
            <p id="errorMessage" class="text-red-500 text-sm mt-2 hidden"></p>
        </form>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const errorMessage = document.getElementById('errorMessage');
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = {
                email: loginForm.email.value,
                password: loginForm.password.value
            };
            try {
                const res = await fetch("http://127.0.0.1:8000/api/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(formData)
                });
                const data = await res.json();
                if (!res.ok) {
                    errorMessage.textContent = data.message || "Invalid credentials";
                    errorMessage.classList.remove("hidden");
                } else {
                    localStorage.setItem("token", data.token);
                    window.location.href = "/dashboard";
                }
            } catch (error) {
                errorMessage.textContent = "Connection error!";
                errorMessage.classList.remove("hidden");
            }
        });
    </script>
</body>
</html>
