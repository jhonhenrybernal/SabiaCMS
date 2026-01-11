<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps<{
  slot?: string
  format?: 'auto' | 'rectangle' | 'vertical' | 'horizontal'
}>()

const page = usePage()

const adsense = computed(() => (page.props as any).adsense ?? {})
const enabled = computed(() => !!adsense.value.enabled)
const client = computed(() => adsense.value.client || '')
const slot = computed(() => props.slot || adsense.value.slotDefault || '')

const loadAd = () => {
  // Si está apagado o no hay client/slot, no hacemos nada
  if (!enabled.value) return
  if (!client.value || !slot.value) return

  try {
    // @ts-ignore
    if (window.adsbygoogle) {
      // @ts-ignore
      window.adsbygoogle.push({})
    }
  } catch (e) {
    // Evita romper la app si AdSense falla
    console.warn('AdSense init error', e)
  }
}

onMounted(loadAd)

// Para SPA: cuando cambias de página con Inertia, vuelve a intentar cargar
watch(
  () => page.url,
  () => loadAd()
)
</script>

<template>
  <!-- Si está apagado globalmente, no renderiza nada -->
  <div v-if="enabled && client && slot">
    <ins
      class="adsbygoogle"
      style="display:block"
      :data-ad-client="client"
      :data-ad-slot="slot"
      data-full-width-responsive="true"
      :data-ad-format="format || 'auto'"
    />
  </div>
</template>
