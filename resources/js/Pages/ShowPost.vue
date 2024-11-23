<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CardShowProduct from '@/Components/CardShowProduct.vue'
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
const props = defineProps(['posts']);
const posts = props.posts
          
 const redirectToPost = (id) => {
    router.visit(route('posts.showPost', { id }));
};
</script>
<template>
    <Head title="Show Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Show Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
              <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                  <h1 class="text-2xl font-bold mb-6 text-center">Posts</h1>
                  <div v-if="posts.length > 0">
                    <p class="text-center mb-4">Total de posts: {{ posts.length }}</p>
                    <CardShowProduct v-for="post in posts" 
                      :key="post.id" 
                      :title="post.title" 
                      :content="post.content"
                      :create-at="post.created_at"
                      :send-id="post.id"
                    />
                  
                  </div>
                  <div v-else class="text-center text-gray-600">
                    No hay posts creados.
                  </div>
                </div>
              </div>
            </div>
          </div>
    </AuthenticatedLayout>
</template>