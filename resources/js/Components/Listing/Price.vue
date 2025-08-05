<template>
  <span>{{ formattedPrice }}</span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    price: [Number, String],
})

const formattedPrice = computed(() => {
  const price = Number(props.price);
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND',
  }).format(price);
});

</script>