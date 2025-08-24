<template>
  <div class="fixed z-50 bottom-6 left-6">
    <button
      @click="open = !open"
      class="inline-flex items-center gap-2 rounded-full shadow-lg border bg-white px-4 py-2"
    >
      ⚙️ <span class="text-sm">تخصيص الصفحة</span>
    </button>

    <transition name="slide-fade">
      <div v-if="open" class="mt-3 w-[min(92vw,28rem)] bg-white border rounded-3xl p-4 shadow-2xl">
        <div class="grid gap-3 text-sm">
          <input v-model="modelValue.name" placeholder="الاسم" class="border rounded px-3 py-2" />
          <input v-model="modelValue.title" placeholder="المسمى" class="border rounded px-3 py-2" />
          <textarea v-model="modelValue.about" rows="3" placeholder="نبذة" class="border rounded px-3 py-2" />
          <input type="file" @change="$emit('pick-image',$event.target.files[0])" />
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { reactive, toRefs, ref } from "vue"
const props = defineProps({
  name: String,
  title: String,
  location: String,
  about: String,
  email: String,
  phone: String,
  website: String,
})
const emit = defineEmits(["update:name","update:title","update:location","update:about","update:email","update:phone","update:website","pick-image"])
const open = ref(true)
const modelValue = reactive(toRefs(props))
</script>