<script setup>
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";

let formMode = ref("create");

defineProps({
    task: {
        type: Object,
    },
    types: {
        type: Object,
    },
    statuses: {
        type: Object,
    },
    project: {
        type: Object,
    },
});

let form = useForm({
    name: "",
    start_date: "",
    end_date: "",
    type: "",
    status: "",
});

if (usePage().props.task) {
    form = useForm({
        name: usePage().props.task.name,
        start_date: usePage().props.task.start_date,
        end_date: usePage().props.task.end_date,
        type: usePage().props.task.type,
        status: usePage().props.task.status,
    });

    formMode.value = "edit";
}

const submit = () => {
    if (formMode.value === "create") {
        form.post(
            route("tasks.store", {
                project: usePage().props.project.id,
            })
        );
    } else {
        form.post(
            route("tasks.update", {
                project: usePage().props.project.id,
                task: usePage().props.task.id,
            })
        );
    }
};
</script>

<template>
    <Head title="Task Form" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex">
                            <h2
                                class="flex-none text-lg font-medium text-gray-900 content-center"
                            >
                                <span v-if="formMode === 'create'"
                                    >Create Task Form</span
                                >
                                <span v-else>Edit Task Form</span>
                            </h2>
                        </div>
                    </div>

                    <div class="p-6">
                        <form>
                            <div class="mb-4">
                                <label
                                    for="name"
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    Task Name
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    v-model="form.name"
                                    class="form-input w-full"
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="text-red-500"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>
                            <!-- create start date field -->
                            <div class="mb-4">
                                <label
                                    for="start_date"
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    Start Date
                                </label>
                                <input
                                    type="date"
                                    id="start_date"
                                    name="start_date"
                                    v-model="form.start_date"
                                    class="form-input w-full"
                                />
                                <div
                                    v-if="form.errors.start_date"
                                    class="text-red-500"
                                >
                                    {{ form.errors.start_date }}
                                </div>
                            </div>
                            <!-- end date field -->
                            <div class="mb-4">
                                <label
                                    for="end_date"
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    End Date
                                </label>
                                <input
                                    type="date"
                                    id="end_date"
                                    name="end_date"
                                    v-model="form.end_date"
                                    class="form-input w-full"
                                />
                                <div
                                    v-if="form.errors.end_date"
                                    class="text-red-500"
                                >
                                    {{ form.errors.end_date }}
                                </div>
                            </div>

                            <!-- type dropdown with options (general, development) -->
                            <div class="mb-4">
                                <label
                                    for="type"
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    Type
                                </label>
                                <select
                                    id="type"
                                    name="type"
                                    v-model="form.type"
                                    class="form-select w-full"
                                >
                                    <option selected disabled>
                                        Select Task Type
                                    </option>
                                    <option
                                        v-for="(type, key) in types"
                                        :key="key"
                                        :value="key"
                                    >
                                        {{ type }}
                                    </option>
                                    <div
                                        v-if="form.errors.type"
                                        class="text-red-500"
                                    >
                                        {{ form.errors.type }}
                                    </div>
                                </select>
                            </div>

                            <!-- status dropdown with options (todo, running, completed) -->
                            <div class="mb-4">
                                <label
                                    for="status"
                                    class="block text-gray-700 text-sm font-bold mb-2"
                                >
                                    Status
                                </label>
                                <select
                                    id="status"
                                    name="status"
                                    v-model="form.status"
                                    class="form-select w-full"
                                >
                                    <option selected disabled>
                                        Select Task Status
                                    </option>
                                    <option
                                        v-for="(status, key) in statuses"
                                        :key="key"
                                        :value="key"
                                    >
                                        {{ status }}
                                    </option>
                                    <div
                                        v-if="form.errors.status"
                                        class="text-red-500"
                                    >
                                        {{ form.errors.status }}
                                    </div>
                                </select>
                            </div>

                            <!-- create submit button -->
                            <div class="mb-4">
                                <button
                                    @click.prevent="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
