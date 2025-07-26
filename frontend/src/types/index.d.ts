export type User = {
  id: number;
  name: string;
  email: string;
};
export type Admin = User;

export type ErrorObject = {
  [key: string]: { message: string };
};
export type Post = {
  id: number;
  title: string;
  content: string;
  status: "draft" | "published";
  pic: string | File | null;
  user_id: number;
};

export type Meta = {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
};
