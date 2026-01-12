<script setup lang="ts">
import type { HTMLAttributes } from 'vue'

defineOptions({
  inheritAttrs: false,
})

interface Props {
  className?: HTMLAttributes['class']
  alt?: string
}

withDefaults(defineProps<Props>(), {
  alt: 'SabiaCMS',
})
</script>

<template>
  <img
    src="/public/icon-sabiacms.png"
    :alt="alt"
    :class="className"
    v-bind="$attrs"
  />
</template>
