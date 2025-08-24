<template>
  <div dir="rtl" class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100 text-slate-800">
    <!-- الهيدر اللاصق -->
    <transition name="slide-fade">
      <header
        v-if="showSticky"
        class="fixed top-0 inset-x-0 z-40 backdrop-blur bg-white/80 border-b border-slate-200"
      >
        <div class="mx-auto max-w-6xl px-4 py-2 flex items-center gap-3">
          <img
            :src="avatar || defaultAvatar"
            class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-200"
          />
          <div class="flex-1 min-w-0">
            <div class="text-sm font-semibold truncate"> name </div>
            <div class="text-xs text-slate-600 truncate"> title </div>
          </div>
          <nav class="hidden sm:flex items-center gap-4 text-sm">
            <a href="#about" class="hover:underline">نبذة</a>
            <a href="#skills" class="hover:underline">مهارات</a>
            <a href="#projects" class="hover:underline">مشاريع</a>
            <a href="#contact" class="hover:underline">تواصل</a>
          </nav>
          <a
            :href="vcardHref"
            :download="`${name}-contact.vcf`"
            class="inline-flex items-center gap-2 rounded-2xl border px-3 py-1.5 shadow-sm hover:shadow transition"
          >
            <Download class="w-4 h-4" /> حفظ جهة اتصال
          </a>
        </div>
      </header>
    </transition>

    <!-- لوحة الإعدادات -->
    <SettingsPanel
      v-model:name="name"
      v-model:title="title"
      v-model:location="location"
      v-model:about="about"
      v-model:email="email"
      v-model:phone="phone"
      v-model:website="website"
      @pick-image="onPickImage"
    />

    <!-- قسم البطل -->
    <section ref="heroRef" class="relative overflow-hidden">
      <div class="mx-auto max-w-6xl px-4 pt-28 pb-16 grid md:grid-cols-2 gap-10 items-center">
        <div>
          <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold"> ناصر فلاته </h1>
          <p class="mt-3 text-lg text-slate-700"> مطور  Laravel PHP  </p>

          <div class="mt-6 flex flex-wrap items-center gap-3 text-sm text-slate-600">
            <span class="flex items-center gap-1.5 bg-white border rounded-2xl px-3 py-1 shadow-sm">
              <MapPin class="w-4 h-4"/>  location
            </span>
            <a :href="`mailto:${email}`" class="flex items-center gap-1.5 bg-white border rounded-2xl px-3 py-1 shadow-sm">
              <Mail class="w-4 h-4"/>  email 
            </a>
            <a :href="`tel:${phone}`" class="flex items-center gap-1.5 bg-white border rounded-2xl px-3 py-1 shadow-sm">
              <Phone class="w-4 h-4"/>  phone 
            </a>
            <a :href="`https://${website}`" class="flex items-center gap-1.5 bg-white border rounded-2xl px-3 py-1 shadow-sm">
              <Globe class="w-4 h-4"/>  website 
            </a>
          </div>
        </div>

        <div class="flex justify-center">
          <div class="relative">
            <img
              :src="avatar || defaultAvatar"
              class="w-40 h-40 sm:w-52 sm:h-52 md:w-64 md:h-64 rounded-3xl object-cover shadow-xl ring-4 ring-white/60 border"
            />
            <label class="absolute -bottom-3 left-1/2 -translate-x-1/2 inline-flex items-center gap-2 bg-white border rounded-2xl px-3 py-1.5 shadow cursor-pointer text-sm">
              <Camera class="w-4 h-4"/> تغيير الصورة
              <input type="file" class="hidden" accept="image/*" @change="e => onPickImage(e.target.files[0])" />
            </label>
          </div>
        </div>
      </div>
    </section>

    <!-- نبذة -->
    <Section id="about" title="نبذة">
      <p class="text-slate-700 leading-8"> about </p>
    </Section>

    <!-- مهارات -->
    <Section id="skills" title="المهارات">
      <ul class="grid sm:grid-cols-2 md:grid-cols-3 gap-3 text-sm">
        <li v-for="s in skills" :key="s" class="bg-white border rounded-2xl px-4 py-3 shadow-sm"> s </li>
      </ul>
    </Section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue"
import { Camera, Mail, Phone, Download, Globe, MapPin } from "lucide-vue-next"
import Section from "./Section.vue"
import SettingsPanel from "./SettingsPanel.vue"

const name = ref("ناصر عيسى")
const title = ref("مطور ويب (Back-end)")
const location = ref("برلين، ألمانيا")
const about = ref("مطور ويب شغوف ببناء أنظمة قابلة للتوسع...")
const email = ref("naser@example.com")
const phone = ref("0536529969")
const website = ref("example.com")
const avatar = ref(null)
const defaultAvatar = "https://api.iconify.design/solar:user-bold.svg?color=%2322283a"

const skills = [
  "PHP • Laravel • OOP",
  "RESTful APIs • JSON • Postman",
  "MySQL • Migrations • Eloquent",
  "Git/GitHub • CI/CD",
  "HTML • CSS • Tailwind",
  "JavaScript • TypeScript (أساسيات)"
]

const heroRef = ref(null)
const showSticky = ref(false)

onMounted(() => {
  const observer = new IntersectionObserver(([entry]) => {
    showSticky.value = !entry.isIntersecting
  }, { threshold: 0.1 })
  if (heroRef.value) observer.observe(heroRef.value)
})

const onPickImage = (file) => {
  if (!file) return
  const url = URL.createObjectURL(file)
  avatar.value = url
}
const vcardHref = computed(() => {
  const v = [
    "BEGIN:VCARD",
    "VERSION:3.0",
    `FN:${name.value}`,
    `TITLE:${title.value}`,
    `TEL;TYPE=CELL:${phone.value}`,
    `EMAIL;TYPE=INTERNET:${email.value}`,
    `ADR;TYPE=WORK:;;${location.value};;;;`,
    `URL:https://${website.value.replace(/^https?:\/\//, "")}`,
    "END:VCARD",
  ].join("\n")
  return `data:text/vcard;charset=utf-8,${encodeURIComponent(v)}`
})
</script>
<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-80px);
  opacity: 0;
}
</style>
