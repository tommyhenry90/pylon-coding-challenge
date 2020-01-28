<template>
  <div>
    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
          <img src="https://observer.getpylon.com/img/pylon-logo.png" height="28" width="auto">
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item">
            Home
          </a>

          <a class="navbar-item">
            Documentation
          </a>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              More
            </a>

            <div class="navbar-dropdown">
              <a class="navbar-item">
                About
              </a>
              <a class="navbar-item">
                Jobs
              </a>
              <a class="navbar-item">
                Contact
              </a>
              <hr class="navbar-divider">
              <a class="navbar-item">
                Report an issue
              </a>
            </div>
          </div>
        </div>

        <div class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
              <a class="button is-primary">
                <strong>Sign up</strong>
              </a>
              <a class="button is-light">
                Log in
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="container">
      <div v-if="!projects">
        Loading...
      </div>

      <div v-else>
        <ul>
          <li v-for="project in projects" :key="project.id">
            {{project.id}}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import api from './api.js';

export default {
  data() {
    return {
      projects: null,
    };
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      let response = await api.get('/solar_projects');
      this.projects = response.data.data;
    },
  },
}
</script>
