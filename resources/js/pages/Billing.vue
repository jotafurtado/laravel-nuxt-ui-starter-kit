<script setup lang="ts">
  import Layout from '@/layouts/Default.vue'
  import { Head } from '@inertiajs/vue3'
  import type { TableColumn } from '@nuxt/ui'
  import { format } from 'date-fns'
  import type { Invoice, PaymentMethod, Plan } from '../types'

  defineOptions({ layout: Layout })

  defineProps<{
    plan: Plan
    payment_method: PaymentMethod
    invoices: Invoice[]
  }>()

  const UBadge = resolveComponent('UBadge')

  function formatMoney(amount: number, currency: string): string {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency }).format(amount)
  }

  const columns: TableColumn<Invoice>[] = [
    {
      accessorKey: 'id',
      header: 'Invoice',
    },
    {
      accessorKey: 'date',
      header: 'Date',
      cell: ({ row }) => format(new Date(row.original.date), 'MMM d, yyyy'),
    },
    {
      accessorKey: 'amount',
      header: 'Amount',
      cell: ({ row }) => formatMoney(row.original.amount, row.original.currency),
    },
    {
      accessorKey: 'status',
      header: 'Status',
      cell: ({ row }) =>
        h(UBadge, {
          label: row.original.status,
          color: row.original.status === 'paid' ? 'success' : 'error',
          variant: 'subtle',
          class: 'capitalize',
        }),
    },
  ]
</script>

<template>
  <UDashboardPanel id="billing">
    <template #header>
      <UDashboardNavbar title="Billing">
        <template #leading>
          <UDashboardSidebarCollapse as="button" :disabled="false" />
        </template>
      </UDashboardNavbar>
    </template>

    <template #body>
      <Head title="Billing" />

      <div class="mx-auto flex w-full flex-col gap-4 sm:gap-6 lg:max-w-3xl">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
          <UPageCard title="Current plan" variant="subtle">
            <div class="flex items-baseline gap-1">
              <span class="text-2xl font-semibold text-highlighted">{{ plan.name }}</span>
              <span class="text-muted">· {{ formatMoney(plan.price, plan.currency) }}/{{ plan.interval }}</span>
            </div>

            <ul class="space-y-2 text-sm">
              <li v-for="feature in plan.features" :key="feature" class="flex items-center gap-2">
                <UIcon name="i-lucide-check" class="size-4 text-primary" />
                {{ feature }}
              </li>
            </ul>
          </UPageCard>

          <UPageCard title="Payment method" variant="subtle">
            <div class="flex items-center gap-3">
              <UIcon name="i-lucide-credit-card" class="size-8 text-muted" />
              <div class="text-sm">
                <p class="font-medium text-highlighted">{{ payment_method.brand }} ending in {{ payment_method.last4 }}</p>
                <p class="text-muted">Expires {{ payment_method.expires }}</p>
              </div>
            </div>
          </UPageCard>
        </div>

        <UPageCard title="Invoices" variant="subtle">
          <UTable :data="invoices" :columns="columns" />
        </UPageCard>
      </div>
    </template>
  </UDashboardPanel>
</template>
