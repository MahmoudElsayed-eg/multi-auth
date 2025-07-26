export function getAuthToken() {
  return localStorage.getItem("auth_token");
}

export function getUserType() {
  return localStorage.getItem("type");
}

export function isValidUserType(type: string | null): type is 'admin' | 'user' {
  return type === 'admin' || type === 'user';
}

export function clearAuth() {
  localStorage.removeItem("auth_token");
  localStorage.removeItem("type");
}