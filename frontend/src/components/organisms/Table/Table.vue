<template>
  <div
    class="relative overflow-x-auto bg-gray-100 shadow-xs rounded-md border border-gray-200"
  >
    <table class="w-full text-sm text-left rtl:text-right text-body">
      <thead
        class="text-sm text-body bg-violet-200 border-b rounded-md border-gray-300"
      >
        <tr>
          <th
            v-for="heading in headings"
            :key="heading"
            scope="col"
            class="px-6 py-3"
          >
            {{ heading }}
          </th>
          <th scope="col" class="px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="row in props.tableData"
          :key="row.id"
          class="bg-gray-50 border-b border-gray-200 hover:bg-gray-50"
        >
          <td v-for="heading in headings" :key="heading" class="px-6 py-4">
            {{ row[heading] ? row[heading] : "N/A" }}
          </td>
          <td>
            <slot name="actions" :row="row" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  tableData: {
    type: Array,
    default: () => [],
  },
});

const headings = computed(() =>
  Array.from(
    new Set(props.tableData.flatMap((item) => Object.keys(item))),
  ),
);
</script>
