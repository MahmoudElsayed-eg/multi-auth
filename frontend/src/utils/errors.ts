import type { Ref } from "vue";

const handleValidationErrors = (error: any, errors: Ref) => {
  if (error.response) {
    const status = error.response.status;

    // Laravel validation error
    if (status === 422) {
      const responseErrors = error.response.data.errors || {};
      for (const [key, messages] of Object.entries(
        responseErrors as Record<string, string[] | string>
      )) {
        errors.value[key] = {
          message: Array.isArray(messages) ? messages[0] : messages,
        };
      }
    }

    // Handle 400 Bad Request
    else if (status === 400) {
      const message = error.response.data.message || "Bad request.";
      errors.value["general"] = { message };
    }
  } else {
    console.log(error);
  }
};
export default handleValidationErrors;
