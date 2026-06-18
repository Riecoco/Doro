<template>
  <div class="m-5">
    <!-- Modals -->
    <Transition name="bounce">
      <QuoteAction @submitQuote="handleAdd" action="Add" v-if="showAddModal" @close="showAddModal=false"/>
    </Transition>
    <Transition name="bounce">
      <QuoteAction @submitQuote="handleEdit" action="Edit" v-if="showEditModal" @close="showEditModal=false"/>
    </Transition>
    <Transition name="bounce">
      <DeleteModal @deleteQuote="handleDelete" v-if="showDeleteModal" @close="showDeleteModal=false"/>
    </Transition>

    <!-- Header -->
    <div class="flex flex-row justify-between items-center mb-10 mt-4">
      <SignInButton class="w-fit p-2"
        >Back to App<RouterLink to="/"
      /></SignInButton>
      <TitleLogo class="text-2xl">DORO</TitleLogo>
      <SignInButton class="w-fit p-2" @click="handleLogout()"
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
      <SignInButton @click="openAddModal()" class="w-fit p-2">
        Add New Quote
      </SignInButton>
    </section>

    <!-- Table -->
    <section>
      <p
        v-if="!quotesStore.loading && quotesStore.quotes.length === 0"
        class="text font-dm-sans text-sm text-gray-500"
      >
        No quotes available. Add new quotes to populate the dashboard.
      </p>

      <Table
        v-else-if="!quotesStore.loading"
        :tableData="quotesStore.quotes ?? []"
      >
        <template #actions="{ row }">
          <button
            class="text-blue-500 hover:text-blue-700 transition-all"
            @click="openEditModal(row.id)"
          >
            Edit
          </button>

          <button
            class="text-red-500 hover:text-red-700 transition-all ml-4"
            @click="openDeleteModal(row.id)"
          >
            Delete
          </button>
        </template>
      </Table>

      <!-- Pagination -->
      <section class="flex justify-center mt-6" v-if="quotesStore.totalPages > 1">
        <nav class="flex items-center gap-x-1" aria-label="Pagination">
          <button @click="goToPreviousPage()" type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-foreground hover:bg-muted-hover focus:outline-hidden focus:bg-muted-focus disabled:opacity-50 disabled:pointer-events-none" aria-label="Previous">
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            <span class="sr-only">Previous</span>
          </button>
          <div class="flex items-center gap-x-1">
            <span class="min-h-9.5 min-w-9.5 flex justify-center items-center border border-line-2 text-foreground py-2 px-3 text-sm rounded-lg focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">{{quotesStore.currentPage}}</span>
            <span class="min-h-9.5 flex justify-center items-center text-muted-foreground-1 py-2 px-1.5 text-sm">of</span>
            <span class="min-h-9.5 flex justify-center items-center text-muted-foreground-1 py-2 px-1.5 text-sm">{{quotesStore.totalPages}}</span>
          </div>
          <button @click="goToNextPage()" type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-foreground hover:bg-muted-hover focus:outline-hidden focus:bg-muted-focus disabled:opacity-50 disabled:pointer-events-none" aria-label="Next">
            <span class="sr-only">Next</span>
            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
          </button>
        </nav>
      </section>
    </section>
  </div>
</template>

<script setup>
import SignInButton from "../../atoms/Button/SignInButton.vue";
import { onMounted, ref } from "vue";
import Table from "../../organisms/Table/Table.vue";
import TitleLogo from "../../atoms/Titles/TitleLogo.vue";
import { useRouter } from "vue-router";
import { useQuotesStore } from "../../../stores/quotes";
import { setAuthToken } from "../../../utils/axios.js";
import QuoteAction from "../../organisms/QuoteAction/QuoteAction.vue";
import DeleteModal from "../../organisms/DeleteModal/DeleteModal.vue";

const quotesStore = useQuotesStore();
const router = useRouter();
const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const quoteObj = ref({
  id: null,
  text:"", 
  author:""
})

onMounted(async () => {
  try {
    await quotesStore.getAllQuotes(quotesStore.currentPage);
  } catch (err) {
    console.error("Error fetching quotes:", err);
  }
});

function openAddModal() {
  showAddModal.value = true;
}

function openEditModal(id) {
  // TODO: api call to get quote by id and populate quoteObj
  showEditModal.value = true;
}

function openDeleteModal(id) {
  // TODO: populate quoteObj with the quote to be deleted
  quoteObj.value.id = id;
  showDeleteModal.value = true;
}

async function goToPreviousPage() {
  if (quotesStore.currentPage > 1) {
    await quotesStore.getAllQuotes(quotesStore.currentPage - 1);
  }
}

async function goToNextPage() {
  if (quotesStore.currentPage < quotesStore.totalPages) {
    await quotesStore.getAllQuotes(quotesStore.currentPage + 1);
  }
}

async function handleAdd(quote) {
  // TODO: turn on loader
  quoteObj.value.text = quote.text
  quoteObj.value.author = quote.author

  // TODO: api call to add quote
  await quotesStore.createQuote(quoteObj.value)

  // TODO: turn off loader

  showAddModal.value = false
}

async function handleEdit(quote) {
  // TODO: turn on loader
  // TODO: api call to edit quote by id with quoteObj
  // TODO: turn off loader
  showEditModal.value = false
};

function handleDelete() {
  showDeleteModal.value = false
}

const handleLogout = () => {
  setAuthToken(null);
  router.push("/login");
};
</script>

<style scoped>
.bounce-enter-active {
  animation: bounce-in 0.5s;
}
.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
</style>
