<template>
  <div>
    <!-- Header -->
    <div class="header bg-gradient-success py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <notifications />
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Create an account</h1>
              <p class="text-lead text-white">
                Use these awesome forms to login or create new account in your
                project for free.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>

    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary border-0">
            <div class="card-header bg-transparent pb-5">
              <div class="text-muted text-center mt-2 mb-4">
                <small>Sign up with</small>
              </div>
              <div class="text-center">
                <a href="#" class="btn btn-neutral btn-icon mr-4">
                  <span class="btn-inner--icon">
                    <img src="~/static/img/icons/common/github.svg" />
                  </span>
                  <span class="btn-inner--text">Github</span>
                </a>
                <a href="#" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon">
                    <img src="~/static/img/icons/common/google.svg" />
                  </span>
                  <span class="btn-inner--text">Google</span>
                </a>
              </div>
            </div>

            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Or sign up with credentials</small>
              </div>

              <form @submit.prevent="handleRegister">
                <!-- Name -->
                <base-input
                  alternative
                  class="mb-3"
                  prepend-icon="ni ni-hat-3"
                  placeholder="Name"
                  name="Name"
                  v-model="form.data.attributes.name"
                />
                <validation-error :errors="apiValidationErrors.name" />

                <!-- Email -->
                <base-input
                  alternative
                  class="mb-3"
                  prepend-icon="ni ni-email-83"
                  placeholder="Email"
                  name="Email"
                  v-model="form.data.attributes.email"
                />
                <validation-error :errors="apiValidationErrors.email" />

                <!-- Password -->
                <base-input
                  alternative
                  class="mb-3"
                  prepend-icon="ni ni-lock-circle-open"
                  placeholder="Password"
                  type="password"
                  name="Password"
                  v-model="form.data.attributes.password"
                />
                <password
                  class="mb-3"
                  v-model="form.data.attributes.password"
                  :strength-meter-only="true"
                  @score="showScore"
                  :showStrengthMeter="false"
                />
                <validation-error :errors="apiValidationErrors.password" />

                <!-- Confirm Password -->
                <base-input
                  alternative
                  class="mb-3"
                  prepend-icon="ni ni-lock-circle-open"
                  placeholder="Confirm Password"
                  type="password"
                  name="Password confirmation"
                  v-model="form.data.attributes.password_confirmation"
                />
                <validation-error :errors="apiValidationErrors.password_confirmation" />

                <!-- Password Strength Indicator -->
                <div class="text-muted font-italic">
                  <small>
                    Password strength:
                    <template v-if="form.data.attributes.score === 0">
                      <span class="text-danger font-weight-700">very weak</span>
                    </template>
                    <template v-else-if="form.data.attributes.score === 1">
                      <span class="text-danger font-weight-700">weak</span>
                    </template>
                    <template v-else-if="form.data.attributes.score === 2">
                      <span class="text-warning font-weight-700">medium</span>
                    </template>
                    <template v-else-if="form.data.attributes.score === 3">
                      <span class="text-success font-weight-700">strong</span>
                    </template>
                    <template v-else-if="form.data.attributes.score === 4">
                      <span class="text-success font-weight-700">very strong</span>
                    </template>
                  </small>
                </div>

                <!-- Agree to Terms -->
                <div class="row my-4">
                  <div class="col-12">
                    <base-input name="Privacy Policy">
                      <base-checkbox
                        v-model="form.data.attributes.agree"
                        name="agree"
                      >
                        <span class="text-muted">
                          I agree with the
                          <a href="#!">Terms and conditions</a>
                        </span>
                      </base-checkbox>
                    </base-input>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                  <base-button
                    type="primary"
                    native-type="submit"
                    class="my-4"
                  >
                    Create account
                  </base-button>
                </div>
              </form>
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
import Password from "vue-password-strength-meter";
import BaseCheckbox from "~/components/argon-core/Inputs/BaseCheckbox.vue";

export default {
  layout: "AuthLayout",
  name: "Register",
  mixins: [formMixin],
  components: {
    ValidationError,
    Password,
    BaseCheckbox,
  },
  auth: "guest",
  data() {
    return {
      form: {
        data: {
          type: "token",
          attributes: {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            agree: false,
            score: "", // <- diperbaiki dari scors
          },
        },
      },
    };
  },
  methods: {
    showScore(score) {
      this.form.data.attributes.score = score;
    },
    async handleRegister() {
      if (!this.form.data.attributes.agree) {
        this.$notify({
          type: "danger",
          message: "You need to agree with our terms and conditions.",
        });
        return;
      }

      try {
        await this.$store.dispatch("register/create", this.form.data);
        await this.$auth.loginWith("local", { data: this.form });
        this.$router.push("/dashboard");
      } catch (error) {
        this.setApiValidation(error.response?.data?.errors);
        this.$notify({
          type: "danger",
          message: "Oops, something went wrong!",
        });
      }
    },
  },
};
</script>
