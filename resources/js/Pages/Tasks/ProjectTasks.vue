<script setup>
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

defineProps({
    project: {
        type: Object,
    },
});

const deleteTask = (taskId, taskName) => {
    Swal.fire({
        title: "Are you sure?",
        text: `You will not be able to recover the task: ${taskName}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(
                route("tasks.destroy", {
                    project: usePage().props.project.id,
                    task: taskId,
                })
            );
        }
    });
};
</script>

<template>
    <div class="pb-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex">
                        <h2
                            class="flex-none text-lg font-medium text-gray-900 content-center"
                        >
                            <span>Tasks Management</span>
                        </h2>
                        <Link
                            :href="route('tasks.create', project.id)"
                            class="btn btn-link"
                            >Create Task</Link
                        >
                    </div>
                </div>

                <div class="p-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="task in project.tasks" :key="task.id">
                                <td>{{ task.name }}</td>
                                <td>{{ task.start_date }}</td>
                                <td>{{ task.end_date }}</td>
                                <td>
                                    {{
                                        task.type.charAt(0).toUpperCase() +
                                        task.type.slice(1).toLowerCase()
                                    }}
                                </td>
                                <td>
                                    {{
                                        task.status.charAt(0).toUpperCase() +
                                        task.status.slice(1).toLowerCase()
                                    }}
                                </td>
                                <td>
                                    <Link
                                        :href="
                                            route('tasks.edit', {
                                                project: project.id,
                                                task: task.id,
                                            })
                                        "
                                        class="btn btn-link"
                                        >Edit</Link
                                    >
                                    <button
                                        @click="deleteTask(task.id, task.name)"
                                        class="btn btn-link text-red-500"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
