<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ veterinarios: Array });

const form = ref({ id: null, nombre: '', especialidad: '' });
const isEditing = ref(false);

const resetForm = () => {
  form.value = { id: null, nombre: '', especialidad: '' };
  isEditing.value = false;
};

const save = () => {
  if (isEditing.value) {
    router.put(`/veterinarios/${form.value.id}`, form.value, { onSuccess: () => resetForm() });
  } else {
    router.post('/veterinarios', form.value, { onSuccess: () => resetForm() });
  }
};

const edit = (v) => {
  form.value = { ...v };
  isEditing.value = true;
};

const destroy = (id) => {
  if (confirm('¿Seguro que deseas eliminar este veterinario?')) {
    router.delete(`/veterinarios/${id}`);
  }
};
</script>

<template>
  <AppLayout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4">{{ isEditing ? 'Editar' : 'Registrar' }} Veterinario</h2>
        <form @submit.prevent="save" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
            <input v-model="form.nombre" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Especialidad</label>
            <input v-model="form.especialidad" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required />
          </div>
          <div class="flex space-x-2">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 w-full">Guardar</button>
            <button v-if="isEditing" type="button" @click="resetForm" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">Cancelar</button>
          </div>
        </form>
      </div>

      <div class="md:col-span-2 bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4">Lista de Veterinarios</h2>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Especialidad</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="v in veterinarios" :key="v.id">
              <td class="px-6 py-4">{{ v.id }}</td>
              <td class="px-6 py-4 font-medium text-gray-900">{{ v.nombre }}</td>
              <td class="px-6 py-4 text-gray-600">{{ v.especialidad }}</td>
              <td class="px-6 py-4 text-right space-x-2">
                <button @click="edit(v)" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                <button @click="destroy(v.id)" class="text-red-600 hover:text-red-900">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>