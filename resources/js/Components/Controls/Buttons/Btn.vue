<template>
    <button class="btn px-4 py-2 text-gray-100 text-sm">
        <slot/>
    </button>
</template>

<style scoped>
.btn {
    @apply
        items-center
        shadow-sm
        transition
        ease-in-out
        duration-150
        focus:outline-none
        disabled:cursor-not-allowed
        disabled:bg-gray-200
        disabled:text-gray-400
        disabled:border
        disabled:border-gray-300
}
</style>
