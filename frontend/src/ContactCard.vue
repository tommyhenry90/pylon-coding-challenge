<template>
  <div class="box">
    <div class="level is-mobile">
      <div class="level-left">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        <span class="margin-left-2">{{contact.attributes.first_name}} {{contact.attributes.last_name}}</span>
      </div>
    </div>

    <div class="level is-mobile">
      <div class="level-left">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
        <span class="margin-left-2">{{contact.attributes.email}}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    contact: {
      required: true,
    },
  },
}
</script>
