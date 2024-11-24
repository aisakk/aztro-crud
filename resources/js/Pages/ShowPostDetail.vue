<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive, ref, watch } from 'vue'

const props = defineProps(['posts', 'comments','success'])
const posts = props.posts
const comments = props.comments

// Usa ref para manejar el estado reactivo del mensaje de éxito
const successMessage = ref(props.success);

watch(() => props.success, (newSuccess) => {
  successMessage.value = newSuccess;
});

const form = reactive({
      content: '',
      postId: posts.id
});

const submit = () => {
  router.post('/posts/comments', form, {
    onSuccess: () => {
      form.content = "";
      location.reload();
    }
  });
};
const deleteComment = (commentId, postId) => {
  router.delete(`/post/comments/${commentId}`, {
    data: {postId},
    onSuccess: () => { 
      location.reload();
    }
  })
}
const closeNotification = () => {
  successMessage.value = null;
};

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Show Post Detail and Comments
            </h2>
            <div v-if="successMessage" class="bg-green-500 text-white px-4 py-3 rounded relative flex justify-between items-center" role="alert">
                <div>
                  <strong class="font-bold">
                  <span class="block sm:inline">{{ successMessage }}</span>
                    </strong>
                </div>
                <button @click="closeNotification" class="text-white font-semibold hover:underline">Cerrar</button>
              </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 flex justify-center mb-5">
                <div class="bg-white w-72 flex flex-col justify-center items-center">
                    <p>Titulo: {{ posts.title}}</p>
                    <p>Contenido: {{ posts.content}}</p>
                    <p>Creado: {{ posts.create_at}}</p>
                    <p>id: {{ posts.id}}</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Comentarios</h3>
                    <div v-if="comments.length > 0">
                      <div v-for="comment in comments" :key="comment.id" class="mb-4 p-4 border rounded shadow">
                        <p class="text-gray-700">{{ comment.content }}</p>
                        <p class="text-gray-500">{{ comment.created_at }}</p>
                        <button
                        @click="deleteComment(comment.id, posts.id)"
                        class="mt-4 px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-blue-600"
                      >
                        Eliminar
                      </button>
                      </div>
                    </div>
                </div>
                
            </div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                <div class="p-6 text-gray-900">
                    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
                        <h1 class="text-2xl font-bold mb-6 text-center">Create Comment</h1>
                        <form @submit.prevent="submit" class="space-y-4">
                          <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea
                              id="content"
                              v-model="form.content"
                              class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            ></textarea>
                          </div>
                          <button
                            type="submit"
                            class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                          >
                            Create Comment
                          </button>
                        </form>
                      </div>
                </div>


                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
