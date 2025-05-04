<template>
  <base-nav
    container-classes="container-fluid"
    class="navbar-top border-bottom navbar-expand"
    :class="{ 'bg-success navbar-dark': type === 'default' }"
  >
    <!-- Search form -->
    <form
      class="navbar-search form-inline mr-sm-3"
      :class="{
        'navbar-search-light': type === 'default',
        'navbar-search-dark': type === 'light',
      }"
      id="navbar-search-main"
    >
      <div class="form-group mb-0">
        <div class="input-group input-group-alternative input-group-merge">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
          <input class="form-control" placeholder="Search" type="text" />
        </div>
      </div>
      <button
        type="button"
        class="close"
        data-action="search-close"
        data-target="#navbar-search-main"
        aria-label="Close"
      >
        <span aria-hidden="true">×</span>
        <span class="sr-only">Close search</span>
      </button>
    </form>

    <!-- Navbar icons and toggles -->
    <ul class="navbar-nav align-items-center ml-md-auto">
      <li class="nav-item d-xl-none">
        <div
          class="pr-3 sidenav-toggler"
          :class="{
            active: $sidebar.showSidebar,
            'sidenav-toggler-dark': type === 'default',
            'sidenav-toggler-light': type === 'light',
          }"
          @click="toggleSidebar"
        >
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </div>
      </li>
      <li class="nav-item d-sm-none">
        <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
          <i class="ni ni-zoom-split-in"></i>
        </a>
      </li>

      <!-- Notifications -->
      <base-dropdown
        class="nav-item"
        tag="li"
        title-classes="nav-link"
        title-tag="a"
        icon="ni ni-bell-55"
        menu-classes="dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden"
      >
        <template #default>
          <div class="px-3 py-3">
            <h6 class="text-sm text-muted m-0">
              You have <strong class="text-primary">{{ notifications.length }}</strong> notifications.
            </h6>
          </div>
          <div class="list-group list-group-flush">
            <a
              v-for="(notif, i) in notifications"
              :key="i"
              href="#!"
              class="list-group-item list-group-item-action"
            >
              <div class="row align-items-center">
                <div class="col-auto">
                  <img :src="notif.avatar" class="avatar rounded-circle" />
                </div>
                <div class="col ml--2">
                  <div class="d-flex justify-content-between align-items-center">
                    <div><h4 class="mb-0 text-sm">{{ notif.name }}</h4></div>
                    <div class="text-right text-muted">
                      <small>{{ notif.time }}</small>
                    </div>
                  </div>
                  <p class="text-sm mb-0">{{ notif.message }}</p>
                </div>
              </div>
            </a>
          </div>
          <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">
            View all
          </a>
        </template>
      </base-dropdown>
    </ul>

    <!-- User profile -->
    <ul class="navbar-nav align-items-center ml-auto ml-md-0">
      <base-dropdown menu-on-right class="nav-item" tag="li" title-tag="a" title-classes="nav-link pr-0">
        <template #title-container>
          <a href="#" class="nav-link pr-0" @click.prevent>
            <div class="media align-items-center">
              <span
                class="avatar avatar-sm rounded-circle avatar-image"
                :style="{ backgroundImage: `url('${profileImage}')` }"
              ></span>
              <div class="media-body ml-2 d-none d-lg-block">
                <span class="mb-0 text-sm font-weight-bold">{{ $auth.user.name }}</span>
              </div>
            </div>
          </a>
        </template>

        <template #default>
          <div class="dropdown-header noti-title">
            <h6 class="text-overflow m-0">Welcome!</h6>
          </div>
          <nuxt-link :to="{ name: 'examples-user-profile' }" class="dropdown-item">
            <i class="ni ni-single-02"></i>
            <span>My profile</span>
          </nuxt-link>
          <div class="dropdown-divider"></div>
          <a @click.prevent="logout" class="dropdown-item">
            <i class="ni ni-user-run"></i>
            <span>Logout</span>
          </a>
        </template>
      </base-dropdown>
    </ul>
  </base-nav>
</template>

<script>
import { CollapseTransition } from "vue2-transitions";
import BaseNav from "@/components/argon-core/Navbar/BaseNav.vue";
import Modal from "@/components/argon-core/Modal.vue";

export default {
  components: {
    CollapseTransition,
    BaseNav,
    Modal,
  },
  props: {
    type: {
      type: String,
      default: "default",
    },
  },
  data() {
    return {
      activeNotifications: false,
      showMenu: false,
      searchModalVisible: false,
      searchQuery: "",
      notifications: [
        {
          name: "John Snow",
          avatar: "/img/theme/team-1.jpg",
          time: "2 hrs ago",
          message: "Let's meet at Starbucks at 11:30. Wdyt?",
        },
        {
          name: "Arya Stark",
          avatar: "/img/theme/team-2.jpg",
          time: "3 hrs ago",
          message: "A new issue has been reported for Argon.",
        },
        {
          name: "Tyrion Lannister",
          avatar: "/img/theme/team-3.jpg",
          time: "5 hrs ago",
          message: "Your posts have been liked a lot.",
        },
      ],
    };
  },
  computed: {
    profileImage() {
      return this.$auth.user.profile_image || "/img/placeholder.jpg";
    },
  },
  methods: {
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
    },
    async logout() {
      try {
        await this.$auth.logout();
      } catch (error) {
        this.$toast.error(error?.response?.data?.message || "Logout failed.");
      }
    },
  },
};
</script>

<style scoped>
.avatar-image {
  background-size: cover;
  background-position: center;
  width: 40px;
  height: 40px;
}
</style>
