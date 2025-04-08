<template>
  <div>
    <!-- Header -->
    <div class="header bg-gradient-success py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <notifications />
        <div class="header-body text-center mb-7">
          <h1 class="text-white">Log in to Nuxt Argon Dashboard Laravel Live Preview</h1>
          <p class="text-lead text-white">
            Log in to see how you can go from frontend to fullstack in an instant
            with an API-based Laravel backend.
          </p>
          <div class="text-white">
            <h3><strong>You can log in with:</strong></h3>
            <div>
              Username <b>admin@jsonapi.com</b> Password <b>secret</b>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg viewBox="0 0 2560 100" preserveAspectRatio="none">
          <polygon class="fill-default" points="2560 0 2560 100 0 100" />
        </svg>
      </div>
    </div>

    <!-- Page Content -->
    <div class="container mt--9 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-header bg-transparent pb-5">
              <div class="text-muted text-center mt-2 mb-3">
                <small>Sign in with</small>
              </div>
              <div class="btn-wrapper text-center">
                <button class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon">
                    <img src="~/static/img/icons/common/github.svg" />
                  </span>
                  <span class="btn-inner--text">Github</span>
                </button>
                <button class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon">
                    <img src="~/static/img/icons/common/google.svg" />
                  </span>
                  <span class="btn-inner--text">Google</span>
                </button>
              </div>
            </div>

            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Or sign in with credentials</small>
              </div>

              <form @submit.prevent="handleSubmit">
                <base-input
                  alternative
                  class="mb-3"
                  name="Email"
                  prepend-icon="ni ni-email-83"
                  placeholder="Email"
                  v-model="form.data.attributes.email"
                />
                <validation-error :errors="apiValidationErrors.email" />

                <base-input
                  alternative
                  class="mb-3"
                  name="Password"
                  type="password"
                  prepend-icon="ni ni-lock-circle-open"
                  placeholder="Password"
                  v-model="form.data.attributes.password"
                />
                <validation-error :errors="apiValidationErrors.password" />

                <div class="text-center">
                  <base-button type="primary" native-type="submit" class="my-4">
                    Sign in
                  </base-button>
                </div>
              </form>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-6">
              <router-link to="/password/reset" class="text-light">
                <small>Forgot password?</small>
              </router-link>
            </div>
            <div class="col-6 text-right">
              <router-link to="/register" class="text-light">
                <small>Create new account</small>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ValidationError from "~/components/ValidationError.vue";
import formMixin from "@/mixins/form-mixin";

export default {
  layout: "AuthLayout",
  mixins: [formMixin],
  components: { ValidationError },
  middleware({ store, redirect }) {
    if (store.$auth.loggedIn) {
      return redirect("/dashboard");
    }
  },
  data() {
    return {
      form: {
        data: {
          type: "token",
          attributes: {
            email: "admin@jsonapi.com",
            password: "secret",
          },
        },
      },
    };
  },
  methods: {
    async handleSubmit() {
      try {
        await this.$auth.loginWith("local", { data: this.form });
        this.$axios.defaults.headers.common.Authorization =
          this.$auth.getToken("local");
        this.$router.push("/dashboard");
      } catch (error) {
        await this.$notify({
          type: "danger",
          message: "Invalid credentials!",
        });
        this.setApiValidation(error.response.data.errors);
      }
    },
  },
};
</script>
