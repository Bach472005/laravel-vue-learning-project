<template>
    <Box>
        <div>
            <Link :href="route('listing.show', [listing.id])">
                <div class="flex items-center">
                    <Price :price="listing.price" class="text-2xl font-bold" />
                    <div class="text-xs text-gray-500">
                        <Price :price="monthlyPayment" />
                    </div>
                    
                </div>
                <ListingAddress :listing="listing" class="text-gray-50" />
                <ListingSpace :listing="listing" class="text-lg" />
            </Link>
        </div>
        <div>
            <Link :href="route('realtor.listing.edit', { listing: listing.id })"
                >Edit</Link
            >
        </div>
    </Box>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import ListingAddress from '@/Components/Listing/ListingAddress.vue';
import Box from '@/Components/UI/Box.vue';
import ListingSpace from '@/Components/Listing/ListingSpace.vue';
import Price from '@/Components/Listing/Price.vue';
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment';
const props = defineProps({
    listing: Object,
});

const { monthlyPayment } = useMonthlyPayment(
    props.listing.price,
);
</script>
