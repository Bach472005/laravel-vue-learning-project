<template>
    <MainLayout>
        <div class="flex flex-col-reverse gap-4 md:grid md:grid-cols-12">
            <Box v-if="listing.images.length" class="w-full flex items-center md:col-span-7">
                <div  class="grid grid-cols-2 gap-1">
                    <img v-for="image in listing.images" :key="image.id" :src="image.src" class="h-3/5 w-full">
                </div>
            </Box>
            
            <EmptyState v-else class="flex w-full items-center md:col-span-7">No images</EmptyState>
            
            <div class="flex flex-col gap-4 md:col-span-5">
                <Box>
                    <template #header>Basic info</template>
                    <Price :price="listing.price" class="text-2xl font-bold" />
                    <ListingAddress :listing="listing" class="text-gray-50" />
                    <ListingSpace :listing="listing" class="text-lg" />
                </Box>
                <Box>
                    <template #header> Monthly Payment </template>
                    <div>
                        <label class="label" for="">Interst rate ({{ interstRate }}%)</label>
                        <input
                            v-model.number="interstRate"
                            type="range"
                            min="0.1"
                            max="30"
                            step="0.1"
                            class="h-4 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700"
                        />

                        <label class="label" for="">Duration ({{duration}} years)</label>
                        <input
                            v-model.number="duration"
                            type="range"
                            min="3"
                            max="35"
                            step="1"
                            class="h-4 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700"
                        />

                        <div class="mt-2 text-gray-600 dark:text-gray-300">
                            <div class="text-gray-400">
                                Your monthly payment
                            </div>
                            <Price :price="monthlyPayment" class="text-3xl" />
                        </div>
                        <div class="mt-2 text-gray-500">
                            <div class="flex justify-between">
                                <div>Total Paid</div>
                                <Price :price="totalPaid" class="font-medium"/>
                            </div>
                        </div>
                        <div class="mt-2 text-gray-500">
                            <div class="flex justify-between">
                                <div>Principal Price</div>
                                <Price :price="listing.price" class="font-medium"/>
                            </div>
                        </div>
                        <div class="mt-2 text-gray-500">
                            <div class="flex justify-between">
                                <div>Total Interest</div>
                                <Price :price="totalInterest" class="font-medium"/>
                            </div>
                        </div>
                    </div>
                </Box>
                <MakeOffer
                    v-if="user && !offerMade"
                    :listing-id="listing.id"
                    :price="listing.price"
                    @offer-updated="offer = $event"
                />

                <OfferMade
                    v-if="user && offerMade"
                    :offer="offerMade"
                />
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import ListingAddress from '@/Components/Listing/ListingAddress.vue';
import ListingSpace from '@/Components/Listing/ListingSpace.vue';
import Price from '@/Components/Listing/Price.vue';
import Box from '@/Components/UI/Box.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import MakeOffer from '@/Pages/List/Show/Components/MakeOffer.vue';
import OfferMade from '@/Pages/List/Show/Components/OfferMade.vue';
import { computed, ref } from 'vue';
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment';
import { usePage } from '@inertiajs/vue3';
import EmptyState from '@/Components/UI/EmptyState.vue';

const interstRate = ref(2.5);
const duration = ref(25);

const props = defineProps({
    listing: Object,
    error: Object,
    offerMade: Object,
});

const offer = ref(props.listing.price);

const { monthlyPayment, totalPaid, totalInterest  } = useMonthlyPayment(offer, interstRate, duration)

const page = usePage()

const user = computed(
    () => page.props.user,
)
</script>
