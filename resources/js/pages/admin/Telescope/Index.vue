<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'

const props = defineProps<{
  telescopeUrl: string
}>()
</script>

<template>
  <AdminLayout>
    <h1 class="text-xl font-semibold">Telescope</h1>

    <div class="mt-4 rounded-md border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900">
      <strong>¿Qué es este panel?</strong><br />
      Telescope es una herramienta de depuración para Laravel que muestra:
      requests, queries SQL, jobs, excepciones, logs y más.
      <br /><br />
      <strong>Seguridad:</strong> este módulo debe estar disponible solo para administradores.
    </div>

    <div class="mt-4 rounded-lg border bg-white p-4">
      <div class="text-sm font-medium text-gray-700">Acceso</div>
      <a :href="props.telescopeUrl" class="underline text-sm" target="_blank">
        {{ props.telescopeUrl }}
      </a>

      <div class="mt-4">
        <a
          :href="props.telescopeUrl"
          target="_blank"
          class="inline-flex rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:opacity-90"
        >
          Abrir Telescope
        </a>
      </div>
    </div>
  </AdminLayout>
</template>
