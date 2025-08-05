<template>
    <MainLayout>
        <h1 class="text-3xl mb-4">Your Listings</h1>
        <section class="mb-8">
            <RealtorFilters :filters="filters" />
        </section>
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-2">
            <Box v-for="listing in listings.data" :key="listing.id" :class="{
                'border-dashed border-red-500 dark:border-red-800':
                    listing.deleted_at,
            }">
                <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between">
                    <div :class="{ 'opacity-50': listing.deleted_at }">
                        <div class="xl:flex items-center gap-2">
                            <Price :price="listing.price" class="text-2xl font-medium" />
                            <ListingSpace :listing="listing" />
                        </div>
                        <ListingAddress :listing="listing" class="text-gray-500" />
                    </div>
                    <section>
                        <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                            <Link class="btn-outline text-xs font-medium" :href="route('listing.show', {
                                listing: listing.id,
                            })
                                " target="_blank">
                            Preview
                            </Link>
                            <Link class="btn-outline text-xs font-medium" :href="route('realtor.listing.edit', {
                                listing: listing.id,
                            })
                                ">
                            Edit
                            </Link>
                            <Link class="btn-outline text-xs font-medium" :href="route('realtor.listing.destroy', {
                                listing: listing.id,
                            })
                                " method="delete" as="button" v-if="!listing.deleted_at">
                            Delete
                            </Link>
                            <Link class="btn-outline text-xs font-medium" :href="route('realtor.listing.restore', {
                                listing: listing.id,
                            })
                                " method="put" as="button" v-else>
                            Restore
                            </Link>
                        </div>

                        <div class="mt-2">
                            <Link :href="route('realtor.listing.image.create', {
                                listing: listing.id,
                            })
                                " class="block w-full btn-outline text-xs font-medium text-center">Images ({{
                            listing.images_count }})</Link>
                            <Link :href="route('realtor.listing.show', {
                                listing: listing.id,
                            })
                                " class="block w-full btn-outline text-xs font-medium text-center">Offers ({{
                            listing.offers_count }})</Link>
                        </div>
                    </section>
                </div>
            </Box>
        </section>
        <div v-if="listings && listings.data && listings.data.length" class="w-full flex justify-center mt-4 mb-4">
            <Pagination :links="listings.links" />
        </div>
    </MainLayout>
</template>

<script setup>
import ListingAddress from "@/Components/Listing/ListingAddress.vue";
import ListingSpace from "@/Components/Listing/ListingSpace.vue";
import Price from "@/Components/Listing/Price.vue";
import Box from "@/Components/UI/Box.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link } from "@inertiajs/vue3";
import RealtorFilters from "@/Pages/Realtor/Index/Components/RealtorFilters.vue";
import Pagination from "@/Components/UI/Pagination.vue";

const props = defineProps({
    listings: Object,
    filters: Object,
});
console.log(props.listings);
</script>
