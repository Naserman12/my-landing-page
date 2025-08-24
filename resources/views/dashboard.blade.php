<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة التحكم</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

 <nav class="bg-blue-600 p-4 text-white flex justify-between">
    <a href="/dashboard" class="hover:underline"><h1 class="text-xl font-bold">لوحة التحكم</h1></a>
    <a href="/" class="hover:underline"><h1 class="text-2xl font-bold">{{ $siteInfo->site_name ?? 'اسم الموقع' }}</h1></a>
    @auth
    <button id="logoutBtn" class="bg-red-600 text-white px-4 py-2 rounded">تسجيل الخروج</button>
    @endauth
</nav>
<header class="bg-white shadow p-4 text-center">
        <p class="text-gray-600">{{ $siteInfo->description ?? 'لا يوجد' }}</p>
</header>
  <div class="max-w-6xl mx-auto p-6">
    <!-- الإحصائيات -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-bold text-gray-700">عدد الإنجازات</h2>
        <p id="achievements-count" class="text-3xl font-bold text-blue-500">0</p>
      </div>
      <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-bold text-gray-700">عدد الفيديوهات</h2>
        <p id="videos-count" class="text-3xl font-bold text-green-500">0</p>
      </div>
      <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-bold text-gray-700">عدد الخدمات</h2>
        <p id="services-count" class="text-3xl font-bold text-purple-500">0</p>
      </div>
      <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-lg font-bold text-gray-700">عدد المشاهدات</h2>
        <p id="show-count" class="text-3xl font-bold text-pink-500">0</p>
      </div>
    </div>
    <!-- إعدادات الموقع -->
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

    <!-- إضافة إنجاز -->
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
            <th class="border p-2">الصورة</th>
            <th class="border p-2">إجراءات</th>
          </tr>
        </thead>
        <tbody id="achievements-table"></tbody>
      </table>
    </div>

    <!-- إضافة فيديو -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
      <h2 class="text-lg font-bold mb-4">إضافة فيديو</h2>
      <form id="videoForm" class="space-y-3">
        <input type="text" name="title" placeholder="العنوان" class="w-full border p-2 rounded" required>
        <input type="url" name="url" placeholder="رابط الفيديو" class="w-full border p-2 rounded" required>
        <button class="bg-green-500 text-white px-4 py-2 rounded">إضافة</button>
      </form>
    </div>

    <!-- جدول الفيديوهات -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
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

    <!-- إضافة خدمة -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
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
    const API_URL = "http://127.0.0.1:8000/api/admin"; // 
    // تأكد من تسجيل الدخول
    document.addEventListener("DOMContentLoaded", () => {
      const token = localStorage.getItem('token');
      if (!token) {
        window.location.href = "/login";
      } else {
        fetchStats();
      }
    });
    // Logout
    document.getElementById("logoutBtn").addEventListener("click", async () => {
    const token = localStorage.getItem("token");
    await fetch("http://127.0.0.1:8000/api/logout", {
        method: "POST",
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json",
        } 
        });

    // احذف التوكن من التخزين
    localStorage.removeItem("token");

    // حوّل لصفحة تسجيل الدخول
    window.location.href = "/login";
    });

    // جلب الإحصائيات والجداول
    async function fetchStats() {
      const achievements = await fetch("/api/achievements").then(res => res.json());
      const videos = await fetch("/api/videos").then(res => res.json());
      const services = await fetch("/api/services").then(res => res.json());

      document.getElementById("achievements-count").textContent = achievements.length;
      document.getElementById("videos-count").textContent = videos.length;
      document.getElementById("services-count").textContent = services.length;
      document.getElementById("show-count").textContent = achievements.reduce((s, a) => s + (a.click || 0), 0);
      // إنجازات
      document.getElementById("achievements-table").innerHTML = achievements.map((a, i) => `
        <tr>
          <td class="border p-2">${i + 1}</td>
          <td class="border p-2">${a.title}</td>
          <td class="border p-2">${a.description || ""}</td>
          <td class="border p-2 text-center">
            ${a.image ? `<img src="${a.image}" class="w-16 h-16 object-cover mx-auto rounded">` : ""}
          </td>
          <td class="border p-2 text-center">
            <button class="bg-yellow-500 text-white px-2 py-1 rounded">تعديل</button>
            <button class="bg-red-500 text-white px-2 py-1 rounded">حذف</button>
          </td>
        </tr>
      `).join("");
      // فيديوهات
      document.getElementById("videos-table").innerHTML = videos.map((v, i) => `
        <tr>
          <td class="border p-2">${i + 1}</td>
          <td class="border p-2">${v.title}</td>
          <td class="border p-2"><a href="${v.url}" target="_blank" class="text-blue-500 underline">مشاهدة</a></td>
          <td class="border p-2 text-center">
            <button class="bg-yellow-500 text-white px-2 py-1 rounded">تعديل</button>
            <button class="bg-red-500 text-white px-2 py-1 rounded">حذف</button>
          </td>
        </tr>
      `).join("");
      // خدمات
      document.getElementById("services-table").innerHTML = services.map((s, i) => `
        <tr>
          <td class="border p-2">${i + 1}</td>
          <td class="border p-2">${s.title}</td>
          <td class="border p-2">${s.description || ""}</td>
          <td class="border p-2 text-center">
            <button class="bg-yellow-500 text-white px-2 py-1 rounded">تعديل</button>
            <button class="bg-red-500 text-white px-2 py-1 rounded">حذف</button>
          </td>
        </tr>
      `).join("");
    }
    // إرسال فورم مع FormData
    async function sendFormData(form, endpoint) {
      const token = localStorage.getItem("token");
      let formData = new FormData(form);
      await fetch(`${API_URL}/${endpoint}`, {
        method: "POST",
        headers: { "Authorization": `Bearer ${token}` },
        body: formData
      });
      form.reset();
    }
    // إرسال فورم مع JSON
    async function sendJson(data, endpoint) {
      const token = localStorage.getItem("token");
      await fetch(`${API_URL}/${endpoint}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify(data)
      });
      fetchStats();
    }
    // فورم الإنجازات (يدعم الصور)
    document.getElementById("achievementForm").addEventListener("submit", e => {
      e.preventDefault();
      sendFormData(e.target, "achievements");
    });
    // فورم الفيديوهات
    document.getElementById("videoForm").addEventListener("submit", e => {
      e.preventDefault();
      let data = {
        title: e.target.title.value,
        url: e.target.url.value
      };
      sendJson(data, "videos");
      e.target.reset();
    });
    // فورم الخدمات
    document.getElementById("serviceForm").addEventListener("submit", e => {
      e.preventDefault();
      let data = {
        title: e.target.title.value,
        description: e.target.description.value
      };
      sendJson(data, "services");
      e.target.reset();
    });
    // فورم إعدادات الموقع
    document.getElementById("siteForm").addEventListener("submit", async e => {
        e.preventDefault();
        const token = localStorage.getItem("token");
      let formData = new FormData(e.target);
      const siteMessage = document.getElementById("siteMessage");
      try {
        let res = await fetch(`${API_URL}/site-info`, {
          method: "POST",
          headers: { "Authorization": `Bearer ${token}` },
          body: formData
        });
        let data = await res.json();
        if (!res.ok) {
          siteMessage.textContent = data.message || "حدث خطأ!";
          siteMessage.className = "text-red-500";
        } else {
          siteMessage.textContent = "تم الحفظ بنجاح ✅";
          siteMessage.className = "text-green-500";
        }
        siteMessage.classList.remove("hidden");
      } catch {
        siteMessage.textContent = "خطأ في الاتصال!";
        siteMessage.className = "text-red-500";
        siteMessage.classList.remove("hidden");
      }
      fetchStats();
    });
  </script>
</body>
</html>
