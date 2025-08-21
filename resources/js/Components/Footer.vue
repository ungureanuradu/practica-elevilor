<template>
    <footer class="site-footer" id="site-footer">
      <div class="footer-inner container">
        <div class="footer-col" v-for="(col, i) in cols" :key="i">
          <h4 class="footer-title">{{ col.title }}</h4>
          <ul class="footer-list">
            <li v-for="(link, j) in col.links" :key="j">
              <a
                :href="link.url"
                :target="link.external ? '_blank' : undefined"
                :rel="link.external ? 'noopener noreferrer' : undefined"
              >
                <span class="chev" aria-hidden="true">»</span>
                <span>{{ link.label }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
  
      <div class="footer-bottom">
        <div class="container">
          <p>{{ data?.copyright || '© All Right Reserved.' }}</p>
        </div>
      </div>
  
      <button class="back-to-top" @click="toTop" aria-label="Înapoi sus">▲</button>
    </footer>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  
  const props = defineProps({
    data: { type: Object, required: true }
  })
  
  const cols = computed(() => props.data?.columns || [])
  
  function toTop () {
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
  </script>
  
  <style scoped>
  .site-footer { background:rgb(29 78 216 / var(--tw-bg-opacity, 1)); color:#cfd2d6; position:relative; }
  .container { max-width:1200px; margin:0 auto; padding:0 16px; }
  .footer-inner { display:grid; grid-template-columns:repeat(4,1fr); gap:32px; padding:40px 0; padding: 15px; }
  .footer-title { color:#fff; font-size:14px; letter-spacing:.08em; margin:0 0 12px; }
  .footer-list { list-style:none; margin:0; padding:0; }
  .footer-list li { margin:8px 0; }
  .footer-list a { display:inline-flex; align-items:center; gap:8px; color:#cfd2d6; text-decoration:none; transition:color .2s; }
  .footer-list a:hover { color:#fff; }
  .footer-list .chev { font-weight:700; transform:translateY(-1px); }
  .footer-bottom { border-top:1px solid #3a3a3a; padding:12px 0 16px; text-align:center; font-size:12px; color:#aab0b6; }
  .back-to-top { position:fixed; right:20px; bottom:20px; background:#cc0000; color:#fff; width:38px; height:38px; border-radius:8px; border:none; cursor:pointer; box-shadow:0 6px 16px rgba(0,0,0,.25); }
  .back-to-top:hover { filter:brightness(1.05); }
  
  /* Responsive */
  @media (max-width: 992px){ .footer-inner{ grid-template-columns:repeat(2,1fr);} }
  @media (max-width: 576px){ .footer-inner{ grid-template-columns:1fr;} }
  </style>
  