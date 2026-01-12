<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps<{
  pageTitle?: string
  pageDescription?: string
  canonical?: string
  ogImage?: string
  lang?: 'es' | 'en' | 'fr' | 'it'
  // permite override por página si algún día lo necesitas
  robots?: string
}>()

const page = usePage()
const seo = computed(() => (page.props as any).seo ?? {})

const siteName = computed(() => seo.value.site_name || 'SabiaCMS')
const baseTitle = computed(() => seo.value.title || siteName.value)
const baseDesc = computed(() => seo.value.description || '')
const keywords = computed(() => seo.value.keywords || '')

const robots = computed(() => props.robots || seo.value.robots || 'index,follow')

const title = computed(() => {
  const t = props.pageTitle?.trim()
  if (t) return `${t} | ${siteName.value}`
  return baseTitle.value || siteName.value
})

const description = computed(() => (props.pageDescription?.trim() || baseDesc.value || '').slice(0, 500))

const canonical = computed(() => {
  if (props.canonical) return props.canonical
  if (typeof window !== 'undefined') return window.location.href

  // Fallback SSR
  const base = seo.value.canonical_base || ''
  return base ? base.replace(/\/$/, '') + '/' : ''
})

const ogImage = computed(() => props.ogImage || seo.value.og_image || '')

const googleVerification = computed(() => seo.value.google_site_verification || '')
const bingVerification = computed(() => seo.value.bing_site_verification || '')

const hreflangEnabled = computed(() => !!seo.value.hreflang_enabled)
const schemaEnabled = computed(() => !!seo.value.schema_enabled)

const siteOrigin = computed(() => {
  if (typeof window !== 'undefined') return window.location.origin
  const base = (seo.value.canonical_base || '').trim()
  return base ? base.replace(/\/$/, '') : ''
})

const jsonLd = computed(() => {
  if (!schemaEnabled.value) return null

  const url = canonical.value || siteOrigin.value || ''
  return {
    '@context': 'https://schema.org',
    '@type': 'WebSite',
    name: siteName.value,
    url,
    description: description.value || undefined,
  }
})
</script>

<template>
  <Head>
    <title>{{ title }}</title>

    <meta v-if="description" name="description" :content="description" />
    <meta v-if="keywords" name="keywords" :content="keywords" />

    <meta name="robots" :content="robots" />
    <link v-if="canonical" rel="canonical" :href="canonical" />

    <!-- Verifications -->
    <meta v-if="googleVerification" name="google-site-verification" :content="googleVerification" />
    <meta v-if="bingVerification" name="msvalidate.01" :content="bingVerification" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:site_name" :content="siteName" />
    <meta property="og:title" :content="title" />
    <meta v-if="description" property="og:description" :content="description" />
    <meta v-if="canonical" property="og:url" :content="canonical" />
    <meta v-if="ogImage" property="og:image" :content="ogImage" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="title" />
    <meta v-if="description" name="twitter:description" :content="description" />
    <meta v-if="ogImage" name="twitter:image" :content="ogImage" />

    <!-- Hreflang (multi-idioma) -->
    <template v-if="hreflangEnabled && siteOrigin">
      <link rel="alternate" hreflang="es" :href="`${siteOrigin}/es`" />
      <link rel="alternate" hreflang="en" :href="`${siteOrigin}/en`" />
      <link rel="alternate" hreflang="fr" :href="`${siteOrigin}/fr`" />
      <link rel="alternate" hreflang="it" :href="`${siteOrigin}/it`" />
      <link rel="alternate" hreflang="x-default" :href="`${siteOrigin}/`" />
    </template>

    <!-- Schema.org JSON-LD -->
    <script v-if="jsonLd" type="application/ld+json" v-html="JSON.stringify(jsonLd)"></script>
  </Head>
</template>
