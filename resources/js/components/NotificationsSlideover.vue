<script setup lang="ts">
  import { formatTimeAgo } from '@vueuse/core'
  import { Link, router, usePage } from '@inertiajs/vue3'
  import { useDashboard } from '../composables/useDashboard'

  const { isNotificationsSlideoverOpen } = useDashboard()

  const page = usePage()
  const notifications = computed(() => page.props.notifications ?? [])

  // Notifications are an optional shared prop: load them only when the slideover opens
  watch(isNotificationsSlideoverOpen, (open) => {
    if (open && !page.props.notifications) {
      router.reload({ only: ['notifications'] })
    }
  })
</script>

<template>
  <USlideover v-model:open="isNotificationsSlideoverOpen" title="Notifications">
    <template #body>
      <Link
        v-for="notification in notifications"
        :key="notification.id"
        :href="`/inbox?id=${notification.id}`"
        class="relative -mx-3 flex items-center gap-3 rounded-md px-3 py-2.5 first:-mt-3 last:-mb-3 hover:bg-elevated/50"
      >
        <UChip color="error" :show="!!notification.unread" inset>
          <UAvatar :alt="notification.sender.name" size="md" />
        </UChip>

        <div class="flex-1 text-sm">
          <p class="flex items-center justify-between">
            <span class="font-medium text-highlighted">{{ notification.sender.name }}</span>

            <time :datetime="notification.date" class="text-xs text-muted" v-text="formatTimeAgo(new Date(notification.date))" />
          </p>

          <p class="text-dimmed">
            {{ notification.body }}
          </p>
        </div>
      </Link>
    </template>
  </USlideover>
</template>
