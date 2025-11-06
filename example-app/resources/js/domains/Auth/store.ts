import { ref, computed } from 'vue';
import { getRequest, postRequest } from '../../services/http';
import { Credentials } from './types';
import { User } from '../User/types';
import { router, goToRoute, goToOverviewPage } from '../../router';
import axios from 'axios';

const loggedInUser = ref<User | null>(null);

export const isLoggedIn = computed(() => loggedInUser.value !== null);
export const getLoggedInUser = computed(() => loggedInUser.value);

export const login = async (credentials: Credentials) => {
  const { data } = await postRequest('login', credentials);
  if (!data) return;
  loggedInUser.value = data.user;
};

export const logout = async () => {
  await axios.post('/api/logout');
  loggedInUser.value = null;
};

export const me = async () => {
  const { data } = await getRequest('me');
  if (!data) return;
  loggedInUser.value = data;
};

export const checkIfLoggedIn = async () => {
  const { data } = await getRequest('me');
  loggedInUser.value = data.user;
};

export const goToLoginPage = () => goToRoute('Login');