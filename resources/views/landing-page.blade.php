<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $siteInfo->site_name ?? 'صفحة ترحيبية' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
     <!-- النافبار -->
  <nav class="bg-blue-600 p-4 text-white flex justify-between">
    <a href="/dashboard" class="hover:underline"><h1 class="text-xl font-bold">لوحة التحكم</h1></a>
    <a href="/" class="hover:underline"><h1 class="text-2xl font-bold">{{ $siteInfo->site_name ?? 'اسم الموقع' }}</h1></a>
    @auth
    <button id="logoutBtn" class="bg-red-600 text-white px-4 py-2 rounded">تسجيل الخروج</button>
    @endauth
</nav>
<header class="bg-white shadow p-4 text-center">
        <p class="text-gray-600">{{ $siteInfo->description ?? 'لا يوجد' }}</p>
          @if($siteInfo && $siteInfo->logo)
        <img src="{{ asset('storage/'.$siteInfo->logo) }}" alt="شعار الموقع" class="mx-auto mt-2 h-16">
         @endif
    </header>
    <main class="max-w-4xl mx-auto p-4">
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">🏆 الإنجازات</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($achievements as $a)
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="font-bold">{{ $a->title ?? 'لا يوجد' }}</h3>
                        <p>{{ $a->description ?? 'لا يوجد'}}</p>
                        @if($a->short_code)
                        <a href="{{ url('/s/'.$a->short_code) }}" class="text-blue-500">عرض المزيد</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">🎥 الفيديوهات</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($videos as $v)
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-bold">{{ $v->title ?? 'لا يوجد' }}</h3>
                    <p>Views : {{ $v->shortLink->clicks ?? 'لا يوجد'}}</p>
                        <p>الرابط المختصر :{{ $v->shortLink->full_short_url ?? 'لم يتم العثور على رابط'}}</p>
                        <iframe width="100%" height="200" src="https://www.youtube.com/embed/{{ $v->shortLink->full_short_url }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="text-xl font-semibold mb-2">📩 تواصل معنا</h2>
            <form action="/api/contact" method="POST" class="bg-white p-4 rounded shadow">
                @csrf
                <input type="text" name="name" placeholder="الاسم" class="border p-2 w-full mb-2">
                <input type="email" name="email" placeholder="البريد الإلكتروني" class="border p-2 w-full mb-2">
                <textarea name="message" placeholder="رسالتك" class="border p-2 w-full mb-2"></textarea>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">إرسال</button>
            </form>
        </section>
    </main>
</body>
</html>
