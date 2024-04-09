<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const showCreateEmployeeForm = () => {
    router.get(route("employees.create"));
};
</script>

<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h2
                    class="flex-none font-semibold text-xl text-gray-800 leading-tight content-center"
                >
                    Employees
                </h2>

                <button
                    @click="showCreateEmployeeForm"
                    class="flex-initial btn btn-link"
                >
                    Add Employee
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Employees listing</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
