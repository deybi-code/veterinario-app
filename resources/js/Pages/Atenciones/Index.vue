<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ atenciones: Array, veterinarios: Array });

const form = ref({ id: null, veterinario_id: '', mascota: '', diagnostico: '', fecha: '', imagen: null });
const isEditing = ref(false);

const handleFile = (e) => {
  form.value.imagen = e.target.files[0];
};

const resetForm = () => {
  form.value = { id: null, veterinario_id: '', mascota: '', diagnostico: '', fecha: '', imagen: null };
  isEditing.value = false;
};

const save = () => {
  const data = new FormData();
  data.append('veterinario_id', form.value.veterinario_id);
  data.append('mascota', form.value.mascota);
  data.append('diagnostico', form.value.diagnostico);
  data.append('fecha', form.value.fecha);
  if (form.value.imagen) {
    data.append('imagen', form.value.imagen);
  }

  if (isEditing.value) {
    data.append('_method', 'PUT');
    router.post(`/atenciones/${form.value.id}`, data, { onSuccess: () => resetForm() });
  } else {
    router.post('/atenciones', data, { onSuccess: () => resetForm() });
  }
};

const edit = (a) => {
  form.value.id = a.id;
  form.value.veterinario_id = a.veterinario_id;
  form.value.mascota = a.mascota;
  form.value.fecha = a.fecha;
  form.value.diagnostico = a.diagnostico;
  form.value.imagen = null; 
  isEditing.value = true;
  
  window.scrollTo({ top: 0, behavior: 'smooth' }); 
};

const destroy = (id) => {
  if (confirm('¿Seguro que deseas eliminar esta atención?')) {
    router.delete(`/atenciones/${id}`);
  }
};
</script>

<template>
  <AppLayout>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-lg shadow h-fit mi-caja-personalizada">
        <h2 class="text-lg font-bold mb-4">{{ isEditing ? 'Editar' : 'Registrar' }} Atención</h2>
        <form @submit.prevent="save" class="space-y-4" enctype="multipart/form-data">
          <div>
            <label class="block text-sm font-medium text-gray-700">Veterinario Asignado</label>
            <select v-model="form.veterinario_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500" required>
              <option value="" disabled>Seleccione un profesional</option>
              <option v-for="v in veterinarios" :key="v.id" :value="v.id">{{ v.nombre }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Nombre de la Mascota</label>
            <input v-model="form.mascota" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Fecha de Atención</label>
            <input v-model="form.fecha" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500" required />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Diagnóstico Técnico</label>
            <textarea v-model="form.diagnostico" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500" required></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Foto Adjunta (Imagen)</label>
            <input type="file" @change="handleFile" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
          </div>
          <div class="flex space-x-2 pt-2">
            <button type="submit" class="mi-boton-personalizado w-full">Guardar Atención</button>
            <button v-if="isEditing" type="button" @click="resetForm" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">Cancelar</button>
          </div>
        </form>
      </div>

      <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow overflow-x-auto">
        <h2 class="text-lg font-bold mb-4">Registro Histórico de Atenciones</h2>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mascota</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Veterinario</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diagnóstico</th>
              <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="a in atenciones" :key="a.id">
              <td class="px-4 py-3 whitespace-nowrap">
                <img v-if="a.imagen" :src="`/storage/${a.imagen}`" alt="Mascota" class="w-12 h-12 object-cover rounded shadow" />
                <span v-else class="text-xs text-gray-400 italic">Sin foto</span>
              </td>
              <td class="px-4 py-3 font-semibold text-gray-900">{{ a.mascota }}</td>
              <td class="px-4 py-3 text-gray-700">{{ a.veterinario ? a.veterinario.nombre : 'No asignado' }}</td>
              <td class="px-4 py-3 text-sm text-gray-500">{{ a.fecha }}</td>
              <td class="px-4 py-3 text-sm text-gray-600 whitespace-normal min-w-[250px]">{{ a.diagnostico }}</td>
              <td class="px-4 py-3 text-right text-sm font-medium space-x-2 whitespace-nowrap">
                <button type="button" @click="edit(a)" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                <button type="button" @click="destroy(a.id)" class="text-red-600 hover:text-red-900">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Aquí va todo tu código CSS para esta vista */
.mi-boton-personalizado {
  background-color: #28a745;
  color: white;
  padding: 8px 16px;
  border-radius: 8px;
  border: none;
  font-weight: bold;
}

.mi-boton-personalizado:hover {
  background-color: #218838;
}

.mi-caja-personalizada {
  border: 2px solid #e5e7eb;
}
</style>