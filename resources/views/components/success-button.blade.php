<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-lime-300 dark:border-lime-500 rounded-md font-semibold text-xs text-lime-700 dark:text-lime-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 dark:focus:ring-offset-lime-800 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
