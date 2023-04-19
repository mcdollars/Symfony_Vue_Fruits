<template>
  <h3>NutritionSum: {{Math.round(total)}}</h3>
  <table class="table">
    <thead>
    <tr>
      <th v-for="field in fields">
        {{ field.toUpperCase() }}
      </th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="item in items">
      <td v-for="field in fields" :key="field">
        <span v-if="field === 'nutritions'" v-for="(value, key) in item['nutritions']">
          <b>{{ key }}</b> : {{ value }}, <br>
        </span>
        <span v-else>
          {{item[field] }}
        </span>
      </td>
    </tr>
    </tbody>
  </table>
</template>
<script setup>
import {onMounted, ref} from "vue";

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
  fields: {
    type: Array,
    required: true,
  },
});
let total = ref(0);
onMounted(() => {
  for(let i = 0; i < props.items.length; i++) {
    total.value = props.items[i]['nutritionSum'] ? props.items[i]['nutritionSum'] + total.value : total.value;
  }
});
</script>