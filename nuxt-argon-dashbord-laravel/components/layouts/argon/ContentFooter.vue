<template>
  <footer class="footer px-4 mx-2">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-lg-6">
        <ul class="nav nav-footer">
          <li
            v-for="(link, index) in footerLinks"
            :key="index"
            class="nav-item"
          >
            <a
              :href="link.href"
              class="nav-link"
              target="_blank"
              rel="noopener"
            >
              {{ link.label }}
            </a>
          </li>
        </ul>
      </div>

      <div class="col-lg-6">
        <div class="copyright text-center text-lg-right text-muted">
          © {{ year }}, made with <i class="fa fa-heart heart"></i> by
          <a
            href="https://www.creative-tim.com"
            class="font-weight-bold ml-1"
            target="_blank"
            rel="noopener"
          >
            Creative Tim
          </a>
          and
          <a
            href="https://www.updivision.com"
            class="font-weight-bold ml-1"
            target="_blank"
            rel="noopener"
          >
            UPDIVISION
          </a>
          for a better web.
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "AppFooter",
  data() {
    return {
      year: new Date().getFullYear(),
      footerLinks: [
        { label: "CREATIVE TIM", href: "https://www.creative-tim.com" },
        { label: "UPDIVISION", href: "https://www.updivision.com" },
        { label: "ABOUT US", href: "https://www.creative-tim.com/presentation" },
        { label: "BLOG", href: "https://blog.creative-tim.com" },
        { label: "LICENSES", href: "https://www.creative-tim.com/license" },
      ],
    };
  },
};
</script>

<style scoped>
.footer {
  padding-top: 1rem;
  padding-bottom: 1rem;
}
.heart {
  color: red;
}
</style>
