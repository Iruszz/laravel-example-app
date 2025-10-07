<template>
<ErrorMessage />

<div class="flex min-h-screen flex-col justify-center items-center px-6 py-12 lg:px-88">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="mx-auto h-10 w-auto" />
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign in to your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div>
        <label for="email" class="block text-sm/6 font-medium dark:text-gray-100">Email address</label>
        <div class="mt-2">
          <input v-model="form.email" id="email" type="email" name="email" required autocomplete="email" class="block w-full rounded-md dark:bg-white/5 px-3 py-1.5 text-base dark:text-white outline-1 -outline-offset-1 dark:outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
        <FormError name="email" />
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium dark:text-gray-100">Password</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input v-model="form.password" id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base dark:text-white outline-1 -outline-offset-1 dark:outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
        </div>
        <FormError name="password" />
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign in</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-400">
      Not a member?
      <RouterLink to="/register" class="font-semibold text-indigo-400 hover:text-indigo-300">Start a 14 day free trial</RouterLink>
    </p>
    
  </div>
</div>

</template>

<script setup>
import { ref } from 'vue';
import ErrorMessage from '../../../services/components/ErrorMessage.vue';
import FormError from '../../../services/components/FormError.vue';
import { useRouter } from 'vue-router';
import { setErrorBag, setMessage, destroyErrors, destroyMessage } from '../../../services/error';
import { getRequest, postRequest } from '../../../services/http';

const router = useRouter();

const form = ref({
  email: '',
  password: ''
});

const error = ref('');

const handleSubmit = async () => {
  destroyErrors();
  destroyMessage();

  try {
    await getRequest('/sanctum/csrf-cookie');
    const { data } = await postRequest('/login', form.value);

    router.push({ name: 'tickets.overview' });
  } catch(error) {
      setErrorBag(error.response?.data.errors || {});
      setMessage(error.response?.data.message || 'Login failed.');
  }
}
</script>