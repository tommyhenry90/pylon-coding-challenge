<!--A fairly basic page to edit projects-->
<template>
    <div class="edit-project">
        <header>
            <div class="level is-mobile margin-bottom-3">
                <router-link :to="'/projects/'+ $route.params.project_id" class="level-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg>
                    <span class="margin-left-2">Back</span>
                </router-link>
            </div>
        </header>
        <article v-if="project" class="columns">
            <div class="column">
                <div class="box">
                <form
                        id="edit-project"
                        @submit="onSubmit"
                >
                    <div class="field">
                        <label class="label" for="title">Title</label>
                        <div class="control">
                            <input required
                                   class="input"
                                   id="title"
                                   v-model="project.attributes.title"
                                   type="text"
                                   name="title">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="system_size">Size</label>
                        <div class="control">
                            <input class="input"
                                   id="system_size"
                                   v-model="project.attributes.system_size"
                                   type="number"
                                   step="any"
                                   name="system_size">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="site_latitude">Latitude</label>
                        <div class="control">
                            <input required
                                   class="input"
                                   id="site_latitude"
                                   v-model="project.attributes.site_latitude"
                                   type="number"
                                   step="any"
                                   name="site_latitude">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="site_longitude">Longitude</label>
                        <div class="control">
                            <input required
                                   class="input"
                                   id="site_longitude"
                                   v-model="project.attributes.site_longitude"
                                   type="number"
                                   step="any"
                                   name="site_longitude">
                        </div>
                    </div>
                </form>
                </div>
                <div class="box">
                <!--TODO: change to a modal with a search / select contact option-->
                <form @submit="addContact">
                    <div class="field">
                        <label class="label" for="new_contact_id">Add Contact by ID</label>
                        <div class="control">
                            <input required
                                   class="input"
                                   id="new_contact_id"
                                   v-model="new_contact_id"
                                   type="text"
                                   name="new_contact_id">
                        </div>
                    </div>
                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" class="button is-link">Add</button>
                        </div>
                    </div>
                </form>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button @click="onSubmit" class="button is-link">Submit All and Save</button>
                    </div>
                </div>
            </div>
            <div class="column">
                <edit-contact-card v-for="contact in contacts"
                              :key="contact.id"
                              :contact="contact"
                              class="view-project__contact" />
            </div>
        </article>
    </div>
</template>

<script>
    import {http} from "./api";
    import EditContactCard from "./EditContactCard";

    export default {
        name: "EditProject",
        components: {EditContactCard},
        data() {
            return {
                project: null,
                contacts: [],
                new_contact_id: null
            }
        },
        mounted() {
            this.fetchProjectDetails();
            this.fetchProjectContacts();
        },
        methods: {
            onSubmit (evt) {
                evt.preventDefault()
                http.put('/solar_projects/' + this.$route.params.project_id, {
                    title: this.project.attributes.title,
                    system_size: this.project.attributes.system_size,
                    site_latitude: this.project.attributes.site_latitude,
                    site_longitude: this.project.attributes.site_longitude,
                }).then(response => {
                    console.log(response.data.id)
                    console.log(this.contacts)
                })
                let contacts = [];
                let temp = [];
                this.contacts.forEach((contact, index) => {
                    if (!contact.to_delete) {
                        contacts.push(contact.data)
                        temp.push(contact)
                    }
                })
                this.contacts.forEach(async contact => {
                    http.put('/contacts/' + contact.data.id, contact.data.attributes)
                        .catch(error => {
                            console.error(error)
                        })
                })
                http.put('/solar_projects/' + this.$route.params.project_id + '/contacts', {data: contacts})
                this.contacts = temp;
            },
            async fetchProjectDetails() {
                let response = await http.get('/solar_projects/' + this.$route.params.project_id);
                this.project = response.data.data;
                console.log(this.project);
            },
            async fetchProjectContacts() {
                this.contacts = [];
                let response = await http.get('/solar_projects/' + this.$route.params.project_id + '/contacts');
                response.data.data.forEach(async contact => {
                    const response = await http.get('/contacts/' + contact.id);
                    this.contacts.push({
                        to_delete: false,
                        data: response.data.data
                    });
                });
            },
            // TODO: reject duplicate contacts
            async addContact (evt) {
                evt.preventDefault();
                http.get('/contacts/' + this.new_contact_id).then(response => {
                    this.contacts.push({
                        to_delete: false,
                        data: response.data.data
                    });
                });
                this.new_contact_id = null
            }
        }
    }
</script>

<style scoped>
    .edit-project {
        padding: 1rem;
    }
</style>