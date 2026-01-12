<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useHead } from '@vueuse/head'

type Props = {
  pageTitle?: string
  description?: string
  keywords?: string
  canonical?: string
  ogImage?: string
  jsonLd?: Record<string, any> | null
}

const props = defineProps<Props>()

const page = usePage()

// Ajusta si ya tienes settings compartidos en Inertia
const siteName = computed(() => (page.props as any)?.name ?? 'SabiaCMS')

// Title final
const title = computed(() => {
  const t = props.pageTitle?.trim()
  return t ? `${t} - ${siteName.value}` : siteName.value
})

const description = computed(() => props.description ?? '')
const keywords = computed(() => props.keywords ?? '')
const canonical = computed(() => props.canonical ?? '')
const ogImage = computed(() => props.ogImage ?? '')

// ✅ JSON-LD: se inyecta con useHead (NO template <script>)
useHead(() => {
  if (!props.jsonLd) return {}

  return {
    script: [
      {
        type: 'application/ld+json',
        // vueuse/head permite string
        children: JSON.stringify(props.jsonLd),
      },
    ],
  }
})
</script>

<template>
  <Head>
    <title>{{ title }}</title>

    <meta v-if="description" name="description" :content="description" />
    <meta v-if="keywords" name="keywords" :content="keywords" />

    <link v-if="canonical" rel="canonical" :href="canonical" />

    <!-- OpenGraph -->
    <meta property="og:title" :content="title" />
    <meta v-if="description" property="og:description" :content="description" />
    <meta property="og:site_name" :content="siteName" />
    <meta v-if="canonical" property="og:url" :content="canonical" />
    <meta v-if="ogImage" property="og:image" :content="ogImage" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="title" />
    <meta v-if="description" name="twitter:description" :content="description" />
    <meta v-if="ogImage" name="twitter:image" :content="ogImage" />
  </Head>
</template>
