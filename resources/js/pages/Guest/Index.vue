<script setup lang="ts">
import Contact from "@/pages/Guest/Contact.vue";
import Features from "@/pages/Guest/Features.vue";
import Hero from "@/pages/Guest/Hero.vue";
import Header from "@/layouts/guest/Header.vue";
import Footer from "@/layouts/guest/Footer.vue";
</script>

<template>
    <div class="bg-white">
        <Header />

        <main class="isolate">
            <!-- Hero section -->
            <Hero />

            <!-- Feature section -->
            <Features id="features" />

            <!-- Contact section -->
            <Contact id="contact" />
        </main>

        <Footer />
    </div>
</template>
