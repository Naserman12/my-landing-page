<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-blue-600 p-4 text-white flex justify-between">
        
        <h1 class="text-xl font-bold">لوحة التحكم</h1>
        <a href="/" class="hover:underline">العودة للموقع</a>
    </nav>

    <div class="max-w-6xl mx-auto p-6">

        
        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-bold text-gray-700">عدد الإنجازات</h2>
                <p id="achievements-count" class="text-3xl font-bold text-blue-500">0</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-bold text-gray-700">عدد الفيديوهات</h2>
                <p id="videos-count" class="text-3xl font-bold text-green-500">0</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-bold text-gray-700">الخدمات</h2>
                <p id="services-count" class="text-3xl font-bold text-purple-500">0</p>
            </div>
        </div>
        <!-- فورم إعدادات الموقع -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-lg font-bold mb-4">إعدادات الموقع</h2>
        <form id="siteForm" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="site_name" placeholder="اسم الموقع" class="w-full border p-2 rounded" required>
            <textarea name="description" placeholder="الوصف" class="w-full border p-2 rounded"></textarea>
            <input type="file" name="logo" class="w-full border p-2 rounded">
            <input type="email" name="email" placeholder="البريد الإلكتروني" class="w-full border p-2 rounded">
            <input type="text" name="phone" placeholder="رقم الهاتف" class="w-full border p-2 rounded">
            <input type="url" name="facebook" placeholder="رابط فيسبوك" class="w-full border p-2 rounded">
            <input type="url" name="twitter" placeholder="رابط تويتر" class="w-full border p-2 rounded">
            <input type="url" name="instagram" placeholder="رابط إنستجرام" class="w-full border p-2 rounded">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                حفظ الإعدادات
            </button>
            <p id="siteMessage" class="text-sm mt-2 hidden"></p>
        </form>
    </div>

        <!-- فورم إضافة إنجاز -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h2 class="text-lg font-bold mb-4">إضافة إنجاز</h2>
            <form id="achievementForm" class="space-y-3" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="العنوان" class="w-full border p-2 rounded" required>
                <textarea name="description" placeholder="الوصف" class="w-full border p-2 rounded"></textarea>
                <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">إضافة</button>
            </form>
        </div>

        <!-- جدول الإنجازات -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h2 class="text-lg font-bold mb-4">الإنجازات</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">#</th>
                        <th class="border p-2">العنوان</th>
                        <th class="border p-2">الوصف</th>
                        <th class="border p-2">إجراءات</th>
                    </tr>
                </thead>
                <tbody id="achievements-table"></tbody>
            </table>
        </div>

        <!-- فورم إضافة فيديو -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h2 class="text-lg font-bold mb-4">إضافة فيديو</h2>
            <form id="videoForm" class="space-y-3">
                <input type="text" name="title" placeholder="العنوان" class="w-full border p-2 rounded" required>
                <input type="url" name="url" placeholder="رابط الفيديو" class="w-full border p-2 rounded" required>
                <button class="bg-green-500 text-white px-4 py-2 rounded">إضافة</button>
            </form>
        </div>

        <!-- جدول الفيديوهات -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">الفيديوهات</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">#</th>
                        <th class="border p-2">العنوان</th>
                        <th class="border p-2">الرابط</th>
                        <th class="border p-2">إجراءات</th>
                    </tr>
                </thead>
                <tbody id="videos-table"></tbody>
            </table>
        </div>

        <!-- فورم إضافة خدمة -->
        <div class="bg-white p-4 rounded-lg shadow mb-6 mt-6">
            <h2 class="text-lg font-bold mb-4">إضافة خدمة</h2>
            <form id="serviceForm" class="space-y-3">
                <input type="text" name="title" placeholder="العنوان" class="w-full border p-2 rounded" required>
                <textarea name="description" placeholder="الوصف" class="w-full border p-2 rounded"></textarea>
                <button class="bg-purple-500 text-white px-4 py-2 rounded">إضافة</button>
            </form>
        </div>

        <!-- جدول الخدمات -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">الخدمات</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">#</th>
                        <th class="border p-2">العنوان</th>
                        <th class="border p-2">الوصف</th>
                        <th class="border p-2">إجراءات</th>
                    </tr>
                </thead>
                <tbody id="services-table"></tbody>
            </table>
        </div>
    </div>

    <script>
        const token = localStorage.getItem("token");
        if (!token) {
            window.location.href = "/login";
        }

        async function fetchStats() {
            let achievements = await fetch('/api/achievements').then(res => res.json());
            let videos = await fetch('/api/videos').then(res => res.json());
            let services = await fetch('/api/services').then(res => res.json());

            document.getElementById('achievements-count').textContent = achievements.length;
            document.getElementById('videos-count').textContent = videos.length;
            document.getElementById('services-count').textContent = services.length;

            // عرض الإنجازات
            let achievementsTable = document.getElementById('achievements-table');
            achievementsTable.innerHTML = achievements.map((a, i) =>
                `<tr>
                    <td class="border p-2">${i + 1}</td>
                    <td class="border p-2">${a.title}</td>
                    <td class="border p-2">${a.description || ''}</td>
                     <td class="border p-2 text-center">
                     ${a.image ? `<img src="${a.image}" alt="صورة" class="w-16 h-16 object-cover mx-auto rounded">` : ''}
                    </td>
                    <td class="border p-2 text-center">
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded">تعديل</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded">حذف</button>
                    </td>
                </tr>`
            ).join('');

            // عرض الفيديوهات
            let videosTable = document.getElementById('videos-table');
            videosTable.innerHTML = videos.map((v, i) =>
                `<tr>
                    <td class="border p-2">${i + 1}</td>
                    <td class="border p-2">${v.title}</td>
                    <td class="border p-2"><a href="${v.url}" target="_blank" class="text-blue-500 underline">مشاهدة</a></td>
                    <td class="border p-2 text-center">
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded">تعديل</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded">حذف</button>
                    </td>
                </tr>`
            ).join('');

            // عرض الخدمات
            let servicesTable = document.getElementById('services-table');
            servicesTable.innerHTML = services.map((s, i) =>
                `<tr>
                    <td class="border p-2">${i + 1}</td>
                    <td class="border p-2">${s.title}</td>
                    <td class="border p-2">${s.description || ''}</td>
                    <td class="border p-2 text-center">
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded">تعديل</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded">حذف</button>
                    </td>
                </tr>`
            ).join('');
        }

        // فورم الإنجازات
        document.getElementById("achievementForm").addEventListener("submit", async (e) => {
            e.preventDefault();
            let formData = new FormData(e.target);
            // let formData = {
            //     title: e.target.title.value,
            //     description: e.target.description.value,
            // };
            await fetch("http://127.0.0.1:8000/api/admin/achievements", {
                method: "POST",
                headers: {  "Authorization": `Bearer ${token}` },
                body:formData,
            });
            fetchStats();
            e.target.reset();
        });

        // فورم الفيديوهات
        document.getElementById("videoForm").addEventListener("submit", async (e) => {
            e.preventDefault();
            let formData = {
                title: e.target.title.value,
                url: e.target.url.value,
            };
            await fetch("http://127.0.0.1:8000/api/admin/videos", {
                method: "POST",
                headers: { "Content-Type": "application/json", "Authorization": `Bearer ${token}` },
                body: JSON.stringify(formData)
            });
            fetchStats();
            e.target.reset();
        });

        // فورم الخدمات
        document.getElementById("serviceForm").addEventListener("submit", async (e) => {
            e.preventDefault();
            let formData = {
                title: e.target.title.value,
                description: e.target.description.value,
            };
            await fetch("http://127.0.0.1:8000/api/admin/services", {
                method: "POST",
                headers: { "Content-Type": "application/json", "Authorization": `Bearer ${token}` },
                body: JSON.stringify(formData)
            });
            fetchStats();
            e.target.reset();
        });
        const siteForm = document.getElementById('siteForm');
        const siteMessage = document.getElementById('siteMessage');

    siteForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        let formData = new FormData(siteForm);
        const token = localStorage.getItem("token");
        try {
            const res = await fetch("http://127.0.0.1:8000/api/admin/site-info", {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${token}`
                },
                body: formData
            });

            const data = await res.json();

            if (!res.ok) {
                siteMessage.textContent = data.message || "حدث خطأ!";
                siteMessage.className = "text-red-500";
            } else {
                siteMessage.textContent = "تم الحفظ بنجاح ✅";
                siteMessage.className = "text-green-500";
                siteMessage.classList.remove("hidden");
            }
        } catch (error) {
            siteMessage.textContent = "خطأ في الاتصال!";
            siteMessage.className = "text-red-500";
            siteMessage.classList.remove("hidden");
        }
    });
    fetchStats();
    </script>

</body>
</html>
