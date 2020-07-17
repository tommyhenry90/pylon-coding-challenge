<template>
  <div class="list-contacts">
    <pagination v-if="pagination !== null" :data="pagination" v-model="page" @input="fetchContacts" />

    <div v-if="contacts !== null">
      <table class="table is-fullwidth">
        <tbody>
          <tr v-for="contact in contacts" :key="contact.id">
            <td>{{contact.attributes.first_name}}</td>
            <td>{{contact.attributes.last_name}}</td>
            <td>{{contact.attributes.email}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style>
.list-contacts {
  padding: 1rem;
}
</style>

<script>
import {http} from './api.js';

import Pagination from './Pagination.vue';

export default {
  components: {
    Pagination,
  },

  data() {
    return {
      page: 1,
      pagination: null,
      contacts: null,
    };
  },

  mounted() {
    this.fetchContacts();
  },

  methods: {
    // Replaced forEach loop with a map which returns an array of Promises,
    // which we can then await before filling in the contacts list
    // Also added .then and .catch methods when getting contact information
    async fetchContacts() {
      this.contacts = null;
      let contacts = [];
      let params = {page: this.page};
      let response = await http.get('/contacts', {params});
      this.pagination = response.data.meta;
      await Promise.all(response.data.data.map(async contact => {
        await http
                .get('/contacts/' + contact.id)
                .then(response => {
                  contacts.push(response.data.data);
                })
                .catch(error => {
                  console.error(error);
                })
      }))
      this.contacts = contacts;
    },
  },
}
</script>
