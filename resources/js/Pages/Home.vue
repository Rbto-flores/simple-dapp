<script setup>
import PaginationLinks from "./Components/PaginationLinks.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";

const props = defineProps({
    users: Object,
    searchTerm: String,
});

const search = ref(props.searchTerm);

watch(search,
    debounce((value) => router.get("/", { search: value }, { preserveState: true }), 500)
);

const getDate = (date) =>
    new Date(date).toLocaleDateString("en-us", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });

</script>

<template>

    <Head :title="` | ${$page.component}`" />
    <div>
        <h1>Home Page</h1>
    </div>
    <div>
        <div class="flex justify-end mb-4">
            <div class="w-1/4">
                <input type="search" placeholder="Search" v-model="search" />
            </div>
        </div>
        <table>
            <thead>
                <tr class="bg-slate-300">
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="user in users.data" :key="user.id">
                    <td>
                        <img :src="user.avatar ? 'storage/' + user.avatar : 'storage/avatars/default-user.jpg'
                            " class="avatar" />
                    </td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ getDate(user.created_at) }}</td>
                </tr>
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div>
            <PaginationLinks :paginator="users" />
        </div>
    </div>

</template>