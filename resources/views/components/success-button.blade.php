<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-lime-400 dark:border-lime-600 rounded-md font-semibold text-xs text-lime-800 dark:text-lime-400 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 dark:focus:ring-offset-lime-900 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
