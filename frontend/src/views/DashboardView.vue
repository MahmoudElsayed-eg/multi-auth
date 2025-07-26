<script setup lang="ts">
import AddPostBtn from "@/components/AddPostBtn.vue";
import DeletePostDialog from "@/components/DeletePostDialog.vue";
import PostDialog from "@/components/PostDialog.vue";
import PostsTable from "@/components/PostsTable.vue";
import SearchForm from "@/components/SearchForm.vue";
import Spinner from "@/components/Spinner.vue";
import UserIcon from "@/components/UserIcon.vue";
import { useDashboardStore } from "@/stores/dashboard";
import { usePostStore } from "@/stores/post";
import type { Post } from "@/types";
import { ErrorObject } from "@/types";
import handleValidationErrors from "@/utils/errors";
import { onMounted, ref } from "vue";

defineProps<{
  role: string;
}>();
const showDialog = ref(false);
const showDeleteDialog = ref(false);
const dialogMode = ref<"add" | "edit">("add");
const currentPost = ref<Post | undefined>(undefined);
const dashboardStore = useDashboardStore();
const postStore = usePostStore();
const loading = ref(true);
const dialogLoading = ref(false);
const errors = ref<ErrorObject>({});
const query = ref("");

// Called to open dialog for adding
const openAdd = () => {
  dialogMode.value = "add";
  currentPost.value = undefined;
  showDialog.value = true;
};

// Called to open dialog for editing
const openEdit = (post: Post) => {
  dialogMode.value = "edit";
  currentPost.value = post;
  showDialog.value = true;
};

const openDelete = (post: Post) => {
  currentPost.value = post;
  showDeleteDialog.value = true;
};

const handleSubmitted = async (post: Post) => {
  dialogLoading.value = true;
  try {
    if (post.id === 0) {
      await postStore.createPost(post);
    } else {
      await postStore.updatePost(post);
    }
    await dashboardStore.getDashboardData();
    errors.value = {};
    showDialog.value = false;
  } catch (error) {
    handleValidationErrors(error, errors);
  } finally {
    dialogLoading.value = false;
  }
};
const handleDelete = async () => {
  dialogLoading.value = true;
  try {
    await postStore.deletePost(currentPost.value.id);
    await dashboardStore.getDashboardData();
    showDeleteDialog.value = false;
  } catch (error) {
    console.log(error);
  } finally {
    dialogLoading.value = false;
  }
};
const handleSearch = async (search: string) => {
  query.value = search;
  loading.value = true;
  try {
    await dashboardStore.getDashboardData(query.value);
  } finally {
    loading.value = false;
  }
};
const handlePage = async (page: number) => {
  loading.value = true;
  try {
    const params = new URLSearchParams(query.value);
    params.set("page", page.toString());
    query.value = params.toString()
    await dashboardStore.getDashboardData(query.value);
  } finally {
    loading.value = false;
  }
};
onMounted(async () => {
  try {
    await dashboardStore.getDashboardData();
  } finally {
    loading.value = false;
  }
});
</script>
<template>
  <main>
    <div class="flex flex-col">
      <UserIcon class="ms-auto mt-3 me-3" />
    </div>
    <div class="flex flex-col md:flex-row md:items-end md:flex-wrap p-3 gap-3">
      <SearchForm :users="dashboardStore.users" @submitted="handleSearch" />
      <AddPostBtn class="w-fit ms-auto" @open="openAdd" />
    </div>
    <div class="overflow-x-auto">
      <Spinner v-if="loading" />
      <PostsTable
        v-else
        :role
        :posts="dashboardStore.posts!"
        :users="dashboardStore.users"
        @edit="openEdit"
        @delete="openDelete"
        @page="handlePage"
      />
    </div>
  </main>
  <PostDialog
    :open="showDialog"
    :mode="dialogMode"
    :post="currentPost"
    @close="
      showDialog = false;
      errors = {};
    "
    @submitted="handleSubmitted"
    :loading="dialogLoading"
    :errors
    :users="dashboardStore.users"
  />
  <DeletePostDialog
    :open="showDeleteDialog"
    @close="showDeleteDialog = false"
    @delete="handleDelete"
    :loading="dialogLoading"
  />
</template>
