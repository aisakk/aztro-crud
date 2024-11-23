<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive, ref, watch } from 'vue'

const props = defineProps(['success']);
// Usa ref para manejar el estado reactivo del mensaje de éxito
const successMessage = ref(props.success);

watch(() => props.success, (newSuccess) => {
  successMessage.value = newSuccess;
});

const form = reactive({
      title: '',
      content: '',
    });

const submit = () => {
      router.post('/posts', form);
      form.title = ""
      form.content = ""
};

const closeNotification = () => {
  successMessage.value = null;
};
</script>
<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Posts
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
            
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
                            <h1 class="text-2xl font-bold mb-6 text-center">Create Post</h1>
                            <form @submit.prevent="submit" class="space-y-4">
                              <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input
                                  type="text"
                                  id="title"
                                  v-model="form.title"
                                  class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                              </div>
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
                                Create Post
                              </button>
                            </form>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>