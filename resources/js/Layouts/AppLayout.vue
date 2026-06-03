<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow mb-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex space-x-8 items-center">
            <span class="font-bold text-xl text-indigo-600">Veterinaria App</span>
            <a href="/atenciones" class="text-gray-700 hover:text-indigo-600 font-medium">Gestionar Atenciones</a>
            <a href="/veterinarios" class="text-gray-700 hover:text-indigo-600 font-medium">Gestionar Veterinarios</a>
          </div>
        </div>
      </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <slot />
    </main>
  </div>
</template>