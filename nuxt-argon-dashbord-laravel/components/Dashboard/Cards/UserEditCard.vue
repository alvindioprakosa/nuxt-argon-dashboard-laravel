<template>
  <div class="card">
    <div class="card-header">
      <h1>Edit Profile</h1>
    </div>
    <div class="card-body">
      <form @submit.prevent="handleProfileUpdate">
        <base-input
          label="Name"
          prepend-icon="fas fa-user"
          placeholder="Your name"
          v-model="user.name"
        />
        <validation-error :errors="apiValidationErrors.name" />

        <base-input
          label="Email"
          prepend-icon="fas fa-envelope"
          placeholder="Email"
          v-model="user.email"
        />
        <validation-error :errors="apiValidationErrors.email" />

        <div class="my-4">
          <base-button class="btn btn-sm btn-primary" native-type="submit">
            Submit
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
  name: "UserEditCard",

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

  methods: {
    async handleProfileUpdate() {
      if (parseInt(this.user.id) === 1) {
        this.$notify({
          type: "danger",
          message: "You are not allowed to change data of default users.",
        });
        return;
      }

      try {
        await this.$store.dispatch("profile/update", this.user);
        this.unsetApiValidationErrors();

        this.$notify({
          type: "success",
          message: "Profile updated successfully.",
        });

        await this.$store.dispatch("profile/me");
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
