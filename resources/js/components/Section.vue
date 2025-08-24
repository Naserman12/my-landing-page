<template>
  <section :id="id" class="mx-auto max-w-6xl px-4 py-14">
    <div class="flex items-end justify-between gap-4 mb-6">
      <h2 class="text-2xl md:text-3xl font-extrabold">{{ title }}</h2>
      <div class="h-px flex-1 bg-gradient-to-l from-slate-300" />
    </div>
    <slot />
  </section>
</template>

<script setup>
defineProps({ id: String, title: String })
</script>
