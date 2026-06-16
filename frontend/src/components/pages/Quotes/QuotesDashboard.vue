<template>
  <div class="m-5">
    <div class="flex flex-row justify-between items-center mb-10 mt-4">
      <SignInButton class="w-fit p-2"
        >Back to App<RouterLink to="/"
      /></SignInButton>
      <TitleLogo class="text-2xl">DORO</TitleLogo>
      <SignInButton class="w-fit p-2" @click="handleLogout"
        >Log out</SignInButton
      >
    </div>
    <section class="flex flex-row justify-between align-center mb-6">
      <div class="flex flex-col space-y-2 flex-4">
        <h1 class="text font-dm-sans font-bold text-3xl">Quotes Dashboard</h1>
        <p class="text font-dm-sans text-sm text-gray-500">
          Manage and review all quotes displayed in the app.
        </p>
      </div>
      <SignInButton class="flex-1"
        >Add New Quote<RouterLink to="/quotes/new"
      /></SignInButton>
    </section>
    <section>
      <p v-if="quotes === null" class="text font-dm-sans text-sm text-gray-500">
        No quotes available. Add new quotes to populate the dashboard.
      </p>
      <Table v-else :tableData="quotes">
        <template #actions="{ row }">
          <button class="text-blue-500 hover:text-blue-700 transition-all">
            Edit <RouterLink :to="`/quotes/edit/${row.id}`" />
          </button>
          <button
            class="text-red-500 hover:text-red-700 transition-all ml-4"
            @click="handleDelete(row.id)"
          >
            Delete
          </button>
        </template>
      </Table>
    </section>
  </div>
</template>

<script setup>
import SignInButton from "../../atoms/Button/SignInButton.vue";
import { ref } from "vue";
import Table from "../../organisms/Table/Table.vue";
import { RouterLink } from "vue-router";
import TitleLogo from "../../atoms/Titles/TitleLogo.vue";

const quotes = ref(null);

function handleLogout() {
  // Implement logout logic here
  console.log("Logout clicked");
}

const quotesData = [
  {
    id: 1,
    author: "Albert Einstein",
    text: "Life is like riding a bicycle. To keep your balance you must keep moving.",
  },
  {
    id: 2,
    author: "Isaac Newton",
    text: "If I have seen further it is by standing on the shoulders of Giants.",
  },
  { id: 3, author: "Yoda", text: "Do or do not. There is no try." },
];
quotes.value = quotesData;
</script>
