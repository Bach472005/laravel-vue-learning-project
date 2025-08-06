<template>
    <form>
        <div class="mb-4 mt-0 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center gap-2">
                <input
                    id="deleted"
                    v-model="filterForm.deleted"
                    type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <label for="deleted">Deleted</label>
            </div>

            <div>
                <select class="input-filter-l w-24" v-model="filterForm.by">
                    <option value="created_at">Added</option>
                    <option value="price">Price</option>
                </select>
                <select class="input-filter-r w-32" v-model="filterForm.order">
                    <option v-for="option in sortOptions" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
            </div>
        </div>
    </form>

    <div v-if="listings && listings.data && listings.data.length" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="listings.links"/>
    </div>
</template>

<script setup>
import { reactive, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import debounce from "lodash.debounce";
import Pagination from "@/Components/UI/Pagination.vue";

const props = defineProps({
    listings: Array,
    filters: Object,
});

const sortLabels = {
    created_at: [
        {
            label: 'Latest',
            value: 'desc',
        },
        {
            label: 'Oldest',
            value: 'asc',
        },
    ],
    price: [
        {
            label: 'Pricey',
            value: 'desc',
        },
        {
            label: 'Cheapest',
            value: 'asc',
        }
    ],
}

const sortOptions = computed(() => sortLabels[filterForm.by])
const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? 'created_at',
    order: props.filters.order ?? 'desc'
});
// reactive / ref / computed
// watch(filterForm, (newValue, oldValue) =>{ console.log(newValue, oldValue)});

// function watch is the function watching the change of ref / reactive / computed
// After changing its will run the next func 
watch(
    filterForm, debounce(() => router.get(
        route('realtor.listing.index'),
        filterForm,
        { preserveState: true, preserveScroll: true }
    ), 1000)
);
</script>
