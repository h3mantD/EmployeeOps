<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Swal from "sweetalert2";

defineProps({
    employees: Array,
});

const showCreateEmployeeForm = () => {
    router.get(route("employees.create"));
};

const deleteEmployee = (employeeId, employeeName) => {
    Swal.fire({
        title: "Are you sure?",
        text: `You want to delete ${employeeName}?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("employees.destroy", employeeId));
        }
    });
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
                    <div class="p-6">
                        <table class="table table-md">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="employee in employees"
                                    :key="employee.id"
                                >
                                    <th>
                                        {{ employee.name }}
                                    </th>
                                    <th>
                                        {{ employee.email }}
                                    </th>
                                    <th>
                                        <Link
                                            :href="
                                                route(
                                                    'employees.edit',
                                                    employee.id
                                                )
                                            "
                                            class="btn btn-link"
                                            >Edit</Link
                                        >
                                        <button
                                            class="btn btn-link text-red-500"
                                            @click="
                                                deleteEmployee(
                                                    employee.id,
                                                    employee.name
                                                )
                                            "
                                        >
                                            Delete
                                        </button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
