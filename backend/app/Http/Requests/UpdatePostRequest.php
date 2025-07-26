<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'user_id' => 'required',
            'status' => 'required|in:draft,published',
            'pic' => 'nullable|image|max:2048'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = $this->user();
            $post = $this->route('post');
            if (!$post) {
                $validator->errors()->add('post', 'Post not found.');
                return;
            }
            if ($user instanceof \App\Models\Admin) {
                //check user_id exists in users table
                if (!\App\Models\User::where('id', $this->user_id)->exists()) {
                    $validator->errors()->add('user_id', 'The selected user_id does not exist.');
                }
            } else {
                // For regular users: can only update their own post
                if ($post->user_id !== $user->id) {
                    $validator->errors()->add('user_id', 'You are not authorized to update this post.');
                    return;
                }
                //make sure user_id matches their own id
                if ($this->user_id != $user->id) {
                    $validator->errors()->add('user_id', 'You are not allowed to assign posts to other users.');
                }
            }
        });
    }
}
