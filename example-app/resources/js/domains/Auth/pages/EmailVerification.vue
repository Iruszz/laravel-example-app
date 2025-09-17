<template>
    <div id="popup-modal" data-modal-backdrop="static" tabindex="-1" class="fixed inset flex z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full m-10">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 p-10">
                <h3 class="text-base-content mb-1.5 text-2xl font-semibold">Verify your email</h3>
                    <h3 class="mb-10 text-lg font-normal text-gray-500 dark:text-gray-300">
                        An activation link has been sent to your email address: {{ email }}. Please check your inbox and click on the link to complete the activation process. 
                    </h3>
                    <div class="text-center">
                    <p class="text-gray-500 dark:text-gray-300 text-base-content/80 text-center pt-3">
                    Didn't get the mail?
                    </p>
                    <button @click="resend" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-base inline-flex items-center px-10 py-2.5 text-center">
                        Resend
                    </button>
                    <p v-if="message" class="mt-2 text-green-600">{{ message }}</p>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue'
import { postRequest, getRequest } from '../../../services/http';
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const message = ref('')
const email = ref(route.query.email || '');

async function fetchUser() {
  try {
    const res = await getRequest('/user')
    email.value = res.data.email
  } catch (err) {
    email.value = ''
  }
}

async function resend() {
  try {
    await getRequest('/sanctum/csrf-cookie'), { withCredentials: true };
    const res = await postRequest('/email/verification-notification')
    message.value = res.data.message
  } catch (err) {
    console.error(err)
  }
}

onMounted(() => {
  if (route.query.verified) {
    router.push('/tickets/overview');
  }
});
</script>