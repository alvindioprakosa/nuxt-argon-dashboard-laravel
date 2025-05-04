<template>
  <div class="card">
    <div class="card-header">
      <h1>Change Password</h1>
    </div>
    <div class="card-body">
      <form ref="password_form" @submit.prevent="handleChangePassword">
        <base-input
          v-model="password"
          type="password"
          name="new_password"
          autocomplete="on"
          class="mb-3"
          prepend-icon="fa fa-key"
          placeholder="New Password"
        />
        <validation-error :errors="apiValidationErrors.password" />

        <base-input
          v-model="password_confirmation"
          type="password"
          name="confirm_password"
          autocomplete="on"
          class="mb-3"
          prepend-icon="fa fa-key"
          placeholder="Confirm Password"
        />

        <div class="my-4">
          <base-button class="btn btn-sm btn-primary" native-type="submit">
            Change Password
          </base-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseInput from "~/components/argon-core/Inputs/BaseInput.vue";
import BaseButton from "~/components/argon-core/BaseButton.vue";
import ValidationError from "~/components/ValidationError.vue";
import formMixin from "@/mixins/form-mixin";

export default {
  name: "UserPasswordCard",

  components: {
    BaseInput,
    BaseButton,
    ValidationError,
  },

  mixins: [formMixin],

  props: {
    user: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      password: "",
      password_confirmation: "",
    };
  },

  methods: {
    async handleChangePassword() {
      if (parseInt(this.user.id) === 1) {
        this.$notify({
          type: "danger",
          message: "You are not allowed to change data of default users.",
        });
        return;
      }

      const payload = {
        ...this.user,
        password: this.password,
        password_confirmation: this.password_confirmation,
      };

      try {
        await this.$store.dispatch("users/update", payload);
        this.$refs.password_form.reset();
        this.unsetApiValidationErrors();

        this.$notify({
          type: "success",
          message: "Password changed successfully.",
        });
      } catch (error) {
        this.$notify({
          type: "danger",
          message: "Oops, something went wrong!",
        });
        this.setApiValidation(error.response?.data?.errors || {});
      }
    },
  },
};
</script>
