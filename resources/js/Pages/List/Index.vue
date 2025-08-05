<template>
    <MainLayout>
        <Filters :filters="filters"></Filters>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
            <Listing v-for="listing in listings.data" :key="listing.id" :listing="listing" />
        </div>

        <section v-if="listings && listings.data && listings.data.length" class="w-full flex justify-center mt-4 mb-4">
            <Pagination :links="listings.links"/>
        </section>
    </MainLayout>
</template>

<script setup>
import Pagination from '@/Components/UI/Pagination.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import Listing from '@/Pages/List/Index/Components/Listing.vue';
import Filters from '@/Pages/List/Index/Components/Filters.vue';
defineProps({
  listings: {
    type: Object,
    required: true,
  },
  filters: Object
});

</script>
