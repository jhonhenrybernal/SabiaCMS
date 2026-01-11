<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  content: '',
  author: '',
  language: 'es',
  source: '',
})

const submit = () => form.post('/admin/messages')
</script>

<template>
  <AdminLayout>
    <div class="flex items-center justify-between">
      <h1 class="text-xl font-semibold">Nuevo mensaje</h1>
      <Link href="/admin/messages" class="rounded-md border px-3 py-2 text-sm hover:bg-gray-50">
        Volver
      </Link>
    </div>

    <div class="mt-6 rounded-lg border bg-white p-6">
      <form class="space-y-4" @submit.prevent="submit">
        <div>
          <label class="text-sm font-medium">Mensaje</label>
          <textarea
            v-model="form.content"
            rows="6"
            class="mt-1 w-full rounded-md border px-3 py-2 text-sm"
            placeholder="Escribe el mensaje…"
          />
          <div v-if="form.errors.content" class="mt-1 text-xs text-red-600">
            {{ form.errors.content }}
          </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
          <div>
            <label class="text-sm font-medium">Autor (entre paréntesis)</label>
            <input v-model="form.author" class="mt-1 w-full rounded-md border px-3 py-2 text-sm" />
            <div v-if="form.errors.author" class="mt-1 text-xs text-red-600">
              {{ form.errors.author }}
            </div>
          </div>

          <div>
            <label class="text-sm font-medium">Idioma</label>
            <select v-model="form.language" class="mt-1 w-full rounded-md border px-3 py-2 text-sm">
              <option value="es">Español</option>
              <option value="en">Inglés</option>
              <option value="fr">Francés</option>
              <option value="it">Italiano</option>
            </select>
            <div v-if="form.errors.language" class="mt-1 text-xs text-red-600">
              {{ form.errors.language }}
            </div>
          </div>

          <div>
            <label class="text-sm font-medium">Fuente (opcional)</label>
            <input v-model="form.source" class="mt-1 w-full rounded-md border px-3 py-2 text-sm" />
            <div v-if="form.errors.source" class="mt-1 text-xs text-red-600">
              {{ form.errors.source }}
            </div>
          </div>
        </div>

        <div class="flex gap-2">
          <button
            type="submit"
            class="rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:opacity-90"
            :disabled="form.processing"
          >
            Guardar
          </button>

          <Link href="/admin/messages" class="rounded-md border px-4 py-2 text-sm hover:bg-gray-50">
            Cancelar
          </Link>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
