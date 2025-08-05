<template>
    <Box>
        <template #header>Make an Offer</template>
        <div >
            <form @submit.prevent="makeOffer">
                <input type="text" class="input" v-model="form.amount"/>
                <input
                    v-model.number="form.amount"
                    type="range"
                    :min="min"
                    :max="max"
                    step="10000"
                    class="mt-2 h-4 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700 "
                />

                <button type="submit" class="btn-outline w-full mt-2 text-sm">
                    Make an Offer
                </button>
            </form>
        </div>
        <div class="flex justify-between text-gray-500 mt-2">
            <div>
                Diffeerence
            </div>
            <div>
                <Price :price="diffeerence" />
            </div>
        </div>
    </Box>


</template>

<script setup>
import Price from "@/Components/Listing/Price.vue";
import Box from "@/Components/UI/Box.vue";
import { useForm } from "@inertiajs/vue3";
import debounce from "lodash.debounce";
import { computed, watch } from "vue";

const props = defineProps({
    listingId: Number,
    price: Number
})

const form = useForm({
    amount: props.price 
})

const makeOffer = () => form.post(
    route('listing.offer.store', {listing: props.listingId}),
    {
        preserveScroll: true,
        preserveState: true,
    }
)

const diffeerence = computed(() => form.amount - props.price)
const min = computed(() => Math.round(props.price / 2))
const max = computed(() => Math.round(props.price * 2))

const emit = defineEmits(['offerUpdated'])
watch(
    () => form.amount,
    debounce((value) => emit('offerUpdated', value), 200)
)
</script>
