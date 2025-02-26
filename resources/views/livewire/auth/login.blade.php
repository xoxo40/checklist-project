<div class="min-h-screen flex items-center justify-center bg-white">
  <div class="flex flex-col md:flex-row w-11/12 max-w-5xl rounded-lg shadow-2xl overflow-hidden">
    <!-- Section Formulaire (Gauche) -->
    <div class="w-full md:w-1/2 bg-white p-12">
      <!-- Logo -->
      <div class="flex justify-center mb-8">
        <img src="{{ asset('images/log.jpg') }}" alt="Logo" class="w-24 h-24 object-contain">
      </div>

      @if (session()->has('error'))
      <div class="bg-[#8B0000] text-white p-3 rounded mb-6">
        {{ session('error') }}
      </div>
      @endif

      <form wire:submit.prevent="login" class="space-y-6">
        <!-- Email -->
        <div>
          <label for="email" class="block text-lg font-medium text-gray-700">Adresse email</label>
          <input type="email" id="email" wire:model="email" required
            class="mt-2 py-3 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:ring-[#8B0000] focus:border-[#8B0000]" />
          @error('email') <span class="text-[#8B0000] text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-lg font-medium text-gray-700">Mot de passe</label>
          <input type="password" id="password" wire:model="password" required
            class="mt-2 py-3 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:ring-[#8B0000] focus:border-[#8B0000]" />
          @error('password') <span class="text-[#8B0000] text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Bouton -->
        <button type="submit"
          class="w-full py-3 px-4 bg-[#8B0000] text-white rounded-lg font-semibold text-lg hover:bg-[#DC143C] transition duration-300">
          Se connecter
        </button>
      </form>

      <div class="text-center mt-6">
        <a href="#" class="text-sm text-gray-500 hover:underline">Mot de passe oublié ?</a>
      </div>
    </div>

    <!-- Section Description (Droite) -->
    <div class="w-full md:w-1/2 bg-gradient-to-r from-[#8B0000] via-[#DC143C] to-[#8B0000] p-12 flex flex-col justify-center">
      <div class="text-white space-y-6">
        <h1 class="text-4xl font-extrabold">Bienvenue</h1>
        <p class="text-lg">
          Nous sommes ravis de vous revoir. Connectez-vous pour accéder à votre compte .
        </p>
        
      </div>
    </div>
  </div>
</div>