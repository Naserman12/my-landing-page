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
                <h2 class="text-lg font-bold text-gray-700">رسائل التواصل</h2>
                <p id="messages-count" class="text-3xl font-bold text-red-500">0</p>
            </div>
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
    </div>

    <script>
        async function fetchStats() {
            let achievements = await fetch('/api/achievements').then(res => res.json());
            let videos = await fetch('/api/videos').then(res => res.json());
            let contacts = await fetch('/api/contact').then(res => res.json());

            document.getElementById('achievements-count').textContent = achievements.length;
            document.getElementById('videos-count').textContent = videos.length;
            document.getElementById('messages-count').textContent = contacts.length;

            // عرض الإنجازات
            let achievementsTable = document.getElementById('achievements-table');
            achievementsTable.innerHTML = achievements.map((a, i) =>
                `<tr>
                    <td class="border p-2">${i + 1}</td>
                    <td class="border p-2">${a.title}</td>
                    <td class="border p-2">${a.description || ''}</td>
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
        }

        fetchStats();
    </script>

</body>
</html>
