<script setup lang="ts">
  import AuthSimpleLayout from '@/layouts/auth/AuthSimpleLayout.vue'
  import AuthSplitLayout from '@/layouts/auth/AuthSplitLayout.vue'

  /**
   * Layout used by every authentication page (login, register, password reset,
   * email verification, two-factor challenge and password confirmation).
   *
   * - 'simple': centered card (default)
   * - 'split': brand panel with an inspiring quote on the left, form on the right
   */
  const layouts = { simple: AuthSimpleLayout, split: AuthSplitLayout }

  const AUTH_LAYOUT: keyof typeof layouts = 'simple'

  const layout = layouts[AUTH_LAYOUT]

  defineProps<{
    title?: string
    description?: string
    variant?: 'outline' | 'solid' | 'soft' | 'subtle' | 'naked' | 'ghost'
  }>()
</script>

<template>
  <component :is="layout" :title :description :variant>
    <slot />
  </component>
</template>
