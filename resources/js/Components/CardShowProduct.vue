<script setup>
import { router } from '@inertiajs/vue3';
const props = defineProps(['title', 'createAt', 'content', 'sendId']);
          
 const redirectToPost = (id) => {
    router.visit(route('posts.showPost', { id }));
};
</script>

<template>
    <div class="mb-4 p-6 bg-white border border-gray-200 rounded-lg shadow-md w-52">
        <h2 class="text-xl font-semibold text-gray-900"> Titulo: {{ props.title }}</h2>
        <p class="text-gray-600">Tiempo Creado: {{ props.created_at }}</p>
        <p class="mt-2 text-gray-700">Contenido: {{ props.content }}</p>
        <button
          @click="redirectToPost(props.sendId)"
          class="mt-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600"
        >
          Ir
        </button>
      </div>
</template>