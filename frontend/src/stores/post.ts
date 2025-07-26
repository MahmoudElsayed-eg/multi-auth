import type { Post, User } from "@/types";
import apiClient from "@/utils/api";
import {
  clearAuth,
  getAuthToken,
  getUserType,
  isValidUserType,
} from "@/utils/auth";
import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const usePostStore = defineStore("post", () => {
  async function createPost(post: Post) {
    const formData = new FormData();
    formData.append("title", post.title);
    formData.append("content", post.content);
    formData.append("user_id", post.user_id.toString());
    formData.append('status',post.status);

    if (post.pic) {
      formData.append("pic", post.pic);
    }

    const { data } = await apiClient.post("/posts", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    console.log("Post created:", data);
  }
  async function updatePost(post: Post) {
    if (!post.id) throw new Error("Post ID is required for update");

    const formData = new FormData();
    formData.append("title", post.title);
    formData.append("content", post.content);
    formData.append("user_id", post.user_id.toString());
    formData.append('status',post.status);

    if (post.pic && post.pic instanceof File) {
      formData.append("pic", post.pic);
    }

    const { data } = await apiClient.post(
      `/posts/${post.id}?_method=PUT`,
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    );
    console.log("Post updated:", data);
    return data;
  }

  async function deletePost(post_id:number) {
    const {data} = await apiClient.delete('/posts/'+post_id);
    console.log('post Deleted' ,data);
    
  }
  return { createPost, updatePost ,deletePost };
});
