<template>
    <div class="md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900">
                <slot name="title" />
            </h3>

            <h3 class="text-lg font-medium text-primary-light">
                <slot name="titlePerso" />
            </h3>

            <p class="mt-1 text-sm text-gray-600">
                <slot name="description" />
            </p>

            <p class="mt-1 text-sm text-primary-light/50">
                <slot name="descriptionPerso" />
            </p>
        </div>

        <div class="px-4 sm:px-0">
            <slot name="aside" />
        </div>
    </div>
</template>
