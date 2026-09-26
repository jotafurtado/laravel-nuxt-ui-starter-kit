<script setup lang="ts">
  import Layout from '@/layouts/Default.vue'
  import { Head } from '@inertiajs/vue3'
  import { format } from 'date-fns'

  defineOptions({ layout: Layout })

  defineProps<{
    twoFactorEnabled: boolean
  }>()

  const auth = useAuth()
  const { getInitials } = useInitials()

  const user = computed(() => auth.value.user)
  const memberSince = computed(() => format(new Date(user.value.created_at), 'MMMM d, yyyy'))
</script>

<template>
  <UDashboardPanel id="profile">
    <template #header>
      <UDashboardNavbar title="Profile">
        <template #leading>
          <UDashboardSidebarCollapse as="button" :disabled="false" />
        </template>
      </UDashboardNavbar>
    </template>

    <template #body>
      <Head title="Profile" />

      <div class="mx-auto flex w-full flex-col gap-4 sm:gap-6 lg:max-w-2xl">
        <UPageCard variant="subtle">
          <div class="flex flex-col items-center gap-4 sm:flex-row">
            <UAvatar :text="getInitials(user.name)" :alt="user.name" size="3xl" />

            <div class="min-w-0 flex-1 text-center sm:text-left">
              <p class="truncate text-lg font-semibold text-highlighted">{{ user.name }}</p>
              <p class="truncate text-muted">{{ user.email }}</p>
            </div>

            <UButton label="Edit profile" icon="i-lucide-pencil" color="neutral" variant="outline" to="/settings/profile" />
          </div>
        </UPageCard>

        <UPageCard title="Account" variant="subtle">
          <dl class="divide-y divide-default text-sm">
            <div class="flex items-center justify-between gap-4 py-3">
              <dt class="text-muted">Email</dt>
              <dd>
                <UBadge v-if="user.email_verified_at" label="Verified" color="success" variant="subtle" />
                <UBadge v-else label="Not verified" color="warning" variant="subtle" />
              </dd>
            </div>

            <div class="flex items-center justify-between gap-4 py-3">
              <dt class="text-muted">Two-factor authentication</dt>
              <dd class="flex items-center gap-2">
                <UBadge v-if="twoFactorEnabled" label="Enabled" color="success" variant="subtle" />
                <UBadge v-else label="Disabled" color="neutral" variant="subtle" />
                <UButton label="Manage" color="neutral" variant="link" size="xs" to="/settings/security" />
              </dd>
            </div>

            <div class="flex items-center justify-between gap-4 py-3">
              <dt class="text-muted">Member since</dt>
              <dd class="text-highlighted">{{ memberSince }}</dd>
            </div>
          </dl>
        </UPageCard>
      </div>
    </template>
  </UDashboardPanel>
</template>
