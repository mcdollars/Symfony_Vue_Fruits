<template>
  <div class="text-white">
    <div style="text-align: right">
      <button :disabled="pagination.currentPage <= 1" @click="pagination.currentPage--" class="rounded-3 px-2 py-1">
        Prev
      </button>
      Page {{ pagination.currentPage }} of {{ pagination.totalPages }}
      <button :disabled="pagination.currentPage >= pagination.totalPages" @click="pagination.currentPage++" class="rounded-3 px-2 py-1">
        Next
      </button>
    </div>
    <div class="form-group col-md-4">
      <input v-model="search" placeholder="Search by name or family" class="form-control">
    </div>
    <div
      :class="['alert', response?.status === 'success'? 'alert-success' : response?.status === 'error'? 'alert-danger':'']">
      {{ response?response.message:'' }}</div>
    <table class="table text-white">
      <thead>
        <tr>
          <th v-for="field in fields">
            {{ field.toUpperCase() }}
          </th>
          <th>Add to favourite</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in paginatedItems">
          <td v-for="field in fields" :key="field">
            <div v-if="field === 'nutritions'" v-for="(value, key) in item['nutritions']" class="badge text-bg-light m-1">
              <b>{{ key }}</b> : {{ value }}
            </div>
            <span v-else>
              {{item[field] }}
            </span>
          </td>
          <td>
            <div @click="addFavourite(item['id'],item['name'], $event)" class="px-3 py-1 rounded-3 bg-primary">Add to Favourites</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
  import { computed, reactive, ref, watch } from 'vue';

  const props = defineProps({
    items: {
      type: Array,
      required: true,
    },
    fields: {
      type: Array,
      required: true,
    }
  });
  const search = ref('');
  const response = ref();
  const pagination = reactive({
    currentPage: 1,
    perPage: 10,
    totalPages: computed(() =>
      Math.ceil(props.items.length / pagination.perPage)
    ),
  });
  const addFavourite = async (fruit_id, name, e) => {
    response.value = await fetch(
      '/add-favourite',
      {
        'method': 'POST',
        'body': JSON.stringify({ 'fruitId': fruit_id, 'name': name, 'action': e.target.innerHTML })
      }
    ).then
      (
        (r) => r.json()
      );
  };

  const paginatedItems = computed(() => {
    const { currentPage, perPage } = pagination;
    const start = (currentPage - 1) * perPage;
    const stop = start + perPage;
    if (search.value !== '') {
      return props.items.filter(
        (item) => (item['name'].toLowerCase().includes(search.value.toLowerCase())) ||
          (item['family'].toLowerCase().includes(search.value.toLowerCase()))
      );
    }
    return props.items.slice(start, stop);
  });

  watch(
    () => pagination.totalPages,
    () => (pagination.currentPage = 1)
  );
</script>