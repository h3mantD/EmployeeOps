<script setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { reactive, ref } from "vue";
import Swal from "sweetalert2";

const showProjectCreationModal = ref(false);

defineProps({
    projects: {
        type: Array,
    },
});

const showProjectModal = () => {
    router.get(route("projects.create"));
};

const deleteProject = (projectId, projectName) => {
    Swal.fire({
        title: "Delete Project",
        text: `You are about to delete the project ${projectName}.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("projects.destroy", projectId));
            console.log("deleted");
        }
    });
};
</script>

<template>
    <Head title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h2
                    class="flex-none font-semibold text-xl text-gray-800 leading-tight content-center"
                >
                    Projects
                </h2>

                <button
                    @click="showProjectModal"
                    class="flex-initial btn btn-link"
                >
                    Create Project
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
                                    <th class="w-9/12 text-left">
                                        Project Name
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="project in projects"
                                    :key="project.id"
                                >
                                    <th class="w-9/12 text-left">
                                        {{ project.name }}
                                    </th>
                                    <th>
                                        <Link
                                            :href="
                                                route(
                                                    'projects.edit',
                                                    project.id
                                                )
                                            "
                                            class="btn btn-link"
                                            >Edit</Link
                                        >
                                        <button
                                            v-if="
                                                $page.props.auth.guard.name !==
                                                'employee'
                                            "
                                            class="btn btn-link text-red-500"
                                            @click="
                                                deleteProject(
                                                    project.id,
                                                    project.name
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

<!-- <style src="vue-multiselect/dist/vue-multiselect.min.css"></style> -->
