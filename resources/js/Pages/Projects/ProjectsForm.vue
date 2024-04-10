<script setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import ProjectTasks from "../Tasks/ProjectTasks.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const formMode = ref("create");

const props = defineProps({
    employees: {
        type: Array,
    },
    projectTypes: {
        type: Object,
    },
    project: {
        type: Object,
    },
});

let form = useForm({
    name: "",
    type: "",
    members: [],
});

if (props.project != null) {
    form = useForm({
        name: props.project.name,
        type: props.project.type,
        members: props.project.members,
    });

    formMode.value = "edit";
}

const submit = () => {
    if (formMode.value === "edit")
        form.post(route("projects.update", props.project.id));
    else if (formMode.value === "create") {
        form.post(route("projects.store"));
    }
};
</script>

<template>
    <Head title="Projects Form" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects Form
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            <span v-if="formMode === 'create'"
                                >Create Project</span
                            >
                            <span v-else>Edit Project</span>
                        </h2>
                        <form @submit.prevent="submit">
                            <div class="mt-6">
                                <label
                                    for="name"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Name
                                </label>

                                <input
                                    v-model="form.name"
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                                    :readonly="
                                        $page.props.auth.guard.name ===
                                        'employee'
                                    "
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="text-red-500"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <div class="mt-6">
                                <label
                                    for="type"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Type
                                </label>

                                <select
                                    v-model="form.type"
                                    id="type"
                                    name="type"
                                    class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                                    :disabled="
                                        $page.props.auth.guard.name ===
                                        'employee'
                                    "
                                >
                                    <option
                                        v-for="(type, key) in projectTypes"
                                        :key="key"
                                        :value="key"
                                    >
                                        {{ type }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.type"
                                    class="text-red-500"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <!-- add multi select dropdown for selecting the members for the project -->
                            <div class="mt-6">
                                <label
                                    for="members"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Members
                                </label>

                                <select
                                    v-model="form.members"
                                    id="members"
                                    name="members"
                                    multiple
                                    class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                                    :disabled="
                                        $page.props.auth.guard.name ===
                                        'employee'
                                    "
                                >
                                    <option
                                        v-for="employee in employees"
                                        :key="employee.id"
                                        :value="employee.id"
                                    >
                                        {{ employee.name }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.members"
                                    class="text-red-500"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <div
                                class="flex items-center justify-end mt-4"
                                v-if="
                                    $page.props.auth.guard.name !== 'employee'
                                "
                            >
                                <Link
                                    :href="route('projects.index')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Cancel
                                </Link>

                                <PrimaryButton
                                    class="ms-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                    type="submit"
                                >
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <template v-if="formMode === 'edit'">
            <ProjectTasks :project="project"></ProjectTasks>
        </template>
    </AuthenticatedLayout>
</template>
